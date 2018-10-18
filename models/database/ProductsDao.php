<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use models\Product;
use PDO;
use PDOException;

/**
 * Класс содержит в себе всю работу с товарами.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class ProductsDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql --------------------------------------------------------------------------------
    // Получить товар по Id с действительной скидкий или же без неё.
    const GET_PRODUCT_BY_ID = "SELECT p.id, i.image_url, p.title, p.description, p.price, p.subcategory_id, 
                                  p.visible, p.quantity, MAX(pr.percent) percent, AVG(r.rating) average 
                               FROM products p 
                               JOIN images i ON p.id = i.product_id 
                               LEFT JOIN reviews r ON p.id = r.product_id
							   LEFT JOIN promotions pr ON p.id = pr.product_id 
                               WHERE pr.start_date <= NOW() 
                                  AND pr.end_date >= NOW() 
                                  OR pr.id IS NULL
                               GROUP BY p.id 
                               HAVING p.visible = 1 
                                  AND p.subcategory_id IS NOT NULL 
                                  AND p.id = ?";
    // Получить товар по Id для админа
    const GET_PRODUCT_BY_ID_ADMIN = "SELECT p.id, i.image_url, p.title, p.description, p.price, p.subcategory_id, 
                                        p.visible, p.quantity, MAX(pr.percent) percent, AVG(r.rating) average 
                                     FROM products p 
                                     JOIN images i ON p.id = i.product_id 
                                     LEFT JOIN reviews r ON p.id = r.product_id
								     LEFT JOIN promotions pr ON p.id = pr.product_id 
                                     WHERE pr.start_date <= NOW() 
                                        AND pr.end_date >= NOW() 
                                        OR pr.id IS NULL
                                     GROUP BY p.id 
                                     HAVING p.id = ?";
    // Выборка похожих товаров (для сингла)
    const GET_RELATED_PRODUCTS = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                     p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                     p.price, MAX(pr.percent) percent, 
                                     IF(MAX(pr.percent) IS NOT NULL, 
                                     p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                  FROM products p 
                                  JOIN images i ON p.id = i.product_id
                                  LEFT JOIN reviews r ON p.id = r.product_id
                                  LEFT JOIN promotions pr ON p.id = pr.product_id 
                                  WHERE pr.start_date <= NOW() 
                                     AND pr.end_date >= NOW() 
                                     OR pr.id IS NULL
                                  GROUP BY p.id 
                                  HAVING p.visible = 1 
                                     AND p.subcategory_id IS NOT NULL
                                     AND NOT p.id = ? 
                                     AND p.subcategory_id = ?
                                  ORDER BY average DESC, 
                                     reviewsCount DESC 
                                  LIMIT 4";
    // Получить самые продаваемые товары (для главной страницы)
    const GET_MOST_SOLD = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                              p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                              p.price, MAX(pr.percent) percent, 
                              IF(MAX(pr.percent) IS NOT NULL, 
                              p.price - MAX(pr.percent)/100*p.price, p.price) price_fin,
                              SUM(DISTINCT op.quantity) sold, 
                              o.status
                           FROM products p 
                           JOIN images i ON p.id = i.product_id
                           LEFT JOIN reviews r ON p.id = r.product_id
                           LEFT JOIN order_products op ON p.id = op.product_id
                           LEFT JOIN orders o ON o.id = op.order_id 
                           LEFT JOIN promotions pr ON p.id = pr.product_id 
                           WHERE pr.start_date <= NOW() 
                              AND pr.end_date >= NOW() 
                              OR pr.id IS NULL
                           GROUP BY p.id 
                           HAVING p.visible = 1 
                              AND p.subcategory_id IS NOT NULL
                           ORDER BY o.status = 3 DESC, 
                              sold DESC, 
                              average DESC 
                           LIMIT 4";
    // Получить самые популярные товары (для главной страницы)
    const GET_MOST_RATED_PRODUCTS = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                        p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                        p.price, MAX(pr.percent) percent, 
                                        IF(MAX(pr.percent) IS NOT NULL, 
                                        p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                     FROM products p 
                                     JOIN images i ON p.id = i.product_id
                                     LEFT JOIN reviews r ON p.id = r.product_id
                                     LEFT JOIN promotions pr ON p.id = pr.product_id 
                                     WHERE pr.start_date <= NOW() 
                                        AND pr.end_date >= NOW() 
                                        OR pr.id IS NULL
                                     GROUP BY p.id 
                                     HAVING p.visible = 1 
                                        AND p.subcategory_id IS NOT NULL
                                     ORDER BY average DESC, 
                                        reviewsCount DESC 
                                     LIMIT 4";
    // Получить самые последние товары (для главной страницы)
    const GET_MOST_RECENT_PRODUCTS = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                         p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                         p.price, MAX(pr.percent) percent, 
                                         IF(MAX(pr.percent) IS NOT NULL, 
                                         p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                      FROM products p 
                                      JOIN images i ON p.id = i.product_id
                                      LEFT JOIN reviews r ON p.id = r.product_id
                                      LEFT JOIN promotions pr ON p.id = pr.product_id 
                                      WHERE pr.start_date <= NOW() 
                                         AND pr.end_date >= NOW() 
                                         OR pr.id IS NULL 
                                      GROUP BY p.id 
                                      HAVING p.visible = 1 
                                         AND p.subcategory_id IS NOT NULL
                                      ORDER BY p.created_at DESC, 
                                         average DESC, 
                                         reviewsCount DESC 
                                      LIMIT 4";
    // Поиск товаров, лимит 3
    const SEARCH_PRODUCTS = "SELECT p.id, p.title, p.visible, MIN(i.image_url) image_url, p.subcategory_id, 
                                ROUND(IF(MAX(pr.percent) IS NOT NULL, 
                                p.price - MAX(pr.percent)/100*p.price, p.price), 2) price
                             FROM products p 
                             JOIN images i ON p.id = i.product_id
                             LEFT JOIN promotions pr ON p.id = pr.product_id 
                             WHERE pr.start_date <= NOW() 
                                AND pr.end_date >= NOW() 
                                OR pr.id IS NULL
                             GROUP BY p.id 
                             HAVING p.visible = 1 
                                AND p.subcategory_id IS NOT NULL 
                                AND title LIKE ? 
                             LIMIT 3";
    // Поиск товаров, безлимитный
    const SEARCH_PRODUCTS_NO_LIMIT = "SELECT p.id, p.title, p.visible, p.price, MIN(i.image_url) image_url, 
                                         p.subcategory_id, MAX(pr.percent) percent, AVG(r.rating) average,
                                         COUNT(DISTINCT r.id) reviewsCount
                                      FROM products p 
                                      JOIN images i ON p.id = i.product_id
                                      LEFT JOIN reviews r ON p.id = r.product_id
                                      LEFT JOIN promotions pr ON p.id = pr.product_id 
                                      WHERE pr.start_date <= NOW() 
                                         AND pr.end_date >= NOW() 
                                         OR pr.id IS NULL
                                      GROUP BY p.id 
                                      HAVING p.visible = 1 
                                         AND p.subcategory_id IS NOT NULL 
                                         AND title LIKE ?";
    // Получить все продукты для админа
    const GET_ALL_PRODUCTS_ADMIN = "SELECT p.id, p.title, p.description, p.price, p.quantity, p.visible, 
                                       p.created_at, sc.name AS subcat_name, MAX(pr.percent) percent
                                    FROM products p 
                                    LEFT JOIN subcategories sc ON p.subcategory_id = sc.id 
                                    LEFT JOIN promotions pr ON p.id = pr.product_id 
                                    WHERE pr.start_date <= NOW() 
                                       AND pr.end_date >= NOW() 
                                       OR pr.id IS NULL
                                    GROUP BY p.id
                                    ORDER BY p.created_at DESC";
    // Переключить видимость товара
    const TOGGLE_VISIBILITY = "UPDATE products 
                               SET visible = ? 
                               WHERE id = ?";
    // Создать товар
    const CREATE_PRODUCT_INFO = "INSERT INTO products(title, description, price, quantity, visible, created_at, subcategory_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    // Создать изображение для товара
    const CREATE_PRODUCT_IMAGE = "INSERT INTO images (image_url, product_id) VALUES (?, ?)";
    // Создать спецификацию для товара
    const CREATE_PRODUCT_SPEC = "INSERT INTO subcat_specification_value (value, subcat_spec_id, product_id) VALUES (?, ?, ?)";
    // Редактировать товар
    const EDIT_PRODUCT_INFO = "UPDATE products 
                               SET title = ?, description = ?, price = ?, quantity = ?, subcategory_id = ? 
                               WHERE id = ?";
    // Редактировать спецификацию товара
    const EDIT_PRODUCT_SPEC = "UPDATE subcat_specification_value 
                               SET value = ? 
                               WHERE id = ?";
    // Удалить изображение товара
    const DELETE_PRODUCT_IMAGES = "DELETE FROM images 
                                   WHERE product_id = ?";
    // Удалить спецификацию товара
    const DELETE_PRODUCT_SPECS = "DELETE FROM subcat_specification_value 
                                  WHERE product_id = ?";
    // Выборка новинок подкатегории (фильтрация)
    const GET_SUBCAT_PRODUCTS_NEWEST = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                           p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                           p.price, MAX(pr.percent) percent, IF(MAX(pr.percent) IS NOT NULL, 
                                           p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                        FROM products p 
                                        JOIN images i ON p.id = i.product_id
                                        LEFT JOIN reviews r ON p.id = r.product_id
                                        LEFT JOIN promotions pr ON p.id = pr.product_id 
                                        WHERE pr.start_date <= NOW() 
                                           AND pr.end_date >= NOW() 
                                           OR pr.id IS NULL 
                                        GROUP BY p.id 
                                        HAVING p.subcategory_id = :sub 
                                           AND p.visible = 1 
                                           AND price_fin BETWEEN :minP 
                                           AND :maxP 
                                        ORDER BY p.created_at DESC, 
                                           average DESC, 
                                           reviewsCount DESC 
                                        LIMIT 8 OFFSET :off";
    // Выборка самых продаваемых товаров для подкатегории (фильтрация)
    const GET_SUBCAT_PRODUCTS_MOST_SOLD = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                              p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                              p.price, MAX(pr.percent) percent, 
                                              IF(MAX(pr.percent) IS NOT NULL, 
                                              p.price - MAX(pr.percent)/100*p.price, p.price) price_fin,
                                              SUM(DISTINCT op.quantity) sold, 
                                              o.status
                                           FROM products p 
                                           JOIN images i ON p.id = i.product_id
                                           LEFT JOIN reviews r ON p.id = r.product_id
                                           LEFT JOIN order_products op ON p.id = op.product_id
                                           LEFT JOIN orders o ON o.id = op.order_id 
                                           LEFT JOIN promotions pr ON p.id = pr.product_id 
                                           WHERE pr.start_date <= NOW() 
                                              AND pr.end_date >= NOW() 
                                              OR pr.id IS NULL
                                           GROUP BY p.id 
                                           HAVING p.subcategory_id = :sub 
                                              AND p.visible = 1
                                              AND price_fin 
                                              BETWEEN :minP AND :maxP
                                           ORDER BY o.status = 3 DESC, 
                                              sold DESC, 
                                              average DESC 
                                           LIMIT 8 OFFSET :off";
    // Выборка товаров подкатегории, где больше всего отзывов (фильтрация)
    const GET_SUBCAT_PRODUCTS_MOST_REVIEWED = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                                  p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                                  p.price, MAX(pr.percent) percent, 
                                                  IF(MAX(pr.percent) IS NOT NULL, 
                                                  p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                               FROM products p 
                                               JOIN images i ON p.id = i.product_id
                                               LEFT JOIN reviews r ON p.id = r.product_id
                                               LEFT JOIN promotions pr ON p.id = pr.product_id 
                                               WHERE pr.start_date <= NOW() 
                                                  AND pr.end_date >= NOW() 
                                                  OR pr.id IS NULL
                                               GROUP BY p.id 
                                               HAVING p.subcategory_id = :sub 
                                                  AND p.visible = 1 
                                                  AND price_fin 
                                                  BETWEEN :minP AND :maxP
                                               ORDER BY reviewsCount DESC, 
                                                  average DESC 
                                               LIMIT 8 OFFSET :off";
    // Выборка товаров подкатегории с самым высоким рейтингом (фильтрация)
    const GET_SUBCAT_PRODUCTS_HIGHEST_RATED = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                                  p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                                  p.price, MAX(pr.percent) percent, IF(MAX(pr.percent) IS NOT NULL, 
                                                  p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                               FROM products p 
                                               JOIN images i ON p.id = i.product_id
                                               LEFT JOIN reviews r ON p.id = r.product_id
                                               LEFT JOIN promotions pr ON p.id = pr.product_id 
                                               WHERE pr.start_date <= NOW() 
                                                  AND pr.end_date >= NOW() 
                                                  OR pr.id IS NULL
                                               GROUP BY p.id 
                                               HAVING p.subcategory_id = :sub 
                                                  AND p.visible = 1 
                                                  AND price_fin 
                                                  BETWEEN :minP AND :maxP
                                               ORDER BY average DESC, 
                                                  reviewsCount DESC 
                                               LIMIT 8 OFFSET :off";

    // Получаем соединение
    private function __construct() {
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new ProductsDao();
        } // if

        return self::$_instance;
    } // getInstance

    /**
     * Создание продукта/товара.
     * @param Product $product
     * @param $images
     * @param $specs
     * @return string - возвращает айди добавленного товара.
     */
    function createNewProduct(Product $product, $images, $specs) {
        $this->_pdo->beginTransaction();

        try {
            // Информация товара
            $title = $product->getTitle();
            $description = $product->getDescription();
            $price = $product->getPrice();
            $quantity = $product->getQuantity();
            $visible = $product->getVisible();
            $createdAt = $product->getCreatedAt();
            $subcatId = $product->getSubcategoryId();
            // Создаём товар
            $statement = $this->_pdo->prepare(self::CREATE_PRODUCT_INFO);
            $statement->execute(array($title, $description, $price, $quantity, $visible, $createdAt, $subcatId));
            $productId = $this->_pdo->lastInsertId();

            // Изображения товара
            foreach ($images as $image) {
                $statement = $this->_pdo->prepare(self::CREATE_PRODUCT_IMAGE);
                $statement->execute(array($image, $productId));
            } // foreach

            // Спецификации товара
            foreach ($specs as $spec) {
                $value = $spec->getValue();
                $specId = $spec->getSubcatSpecId();

                $statement = $this->_pdo->prepare(self::CREATE_PRODUCT_SPEC);
                $statement->execute(array($value, $specId, $productId));
            } // foreach

            $this->_pdo->commit();
            return $productId;
        } catch (PDOException $e) {
            $this->_pdo->rollBack();
            return false;
        } // try-catch
    } // createNewProduct

    /**
     * Редактирование товара.
     * @param Product $product
     * @param $images
     * @param $specs
     * @return bool|mixed
     */
    function editProduct(Product $product, $images, $specs) {
        $this->_pdo->beginTransaction();

        try {
            // Информация товара
            $productId = $product->getId();
            $title = $product->getTitle();
            $description = $product->getDescription();
            $price = $product->getPrice();
            $quantity = $product->getQuantity();
            $subcatId = $product->getSubcategoryId();
            // Редактируем
            $statement = $this->_pdo->prepare(self::EDIT_PRODUCT_INFO);
            $statement->execute(array($title, $description, $price, $quantity, $subcatId, $productId));

            // Изображения товара.
            // Если изображения получены, удаляются старые и вставляются новые, иначе ничего не произойдёт.
            if (!empty($images)) {
                $statement = $this->_pdo->prepare(self::DELETE_PRODUCT_IMAGES);
                $statement->execute(array($productId));
                foreach ($images as $image) {
                    $statement = $this->_pdo->prepare(self::CREATE_PRODUCT_IMAGE);
                    $statement->execute(array($image, $productId));
                } // foreach
            } // if

            // Спецификации товара
            if ($specs[0]["newSubcat"] == 1) {
                // Если подкатегория изменена, удаляются старые спецификации и вставляются новые
                $statement = $this->_pdo->prepare(self::DELETE_PRODUCT_SPECS);
                $statement->execute(array($productId));

                foreach ($specs[1] as $spec) {
                    if (!empty($spec)) {
                        $value = $spec->getValue();
                    } else {
                        $value = "Не определён";
                    } // if
                    $specId = $spec->getSubcatSpecId();

                    $statement = $this->_pdo->prepare(self::CREATE_PRODUCT_SPEC);
                    $statement->execute(array($value, $specId, $productId));
                } // foreach
            } else {
                // Если сабкатегория не изменена - обновляем старые спецификации
                foreach ($specs[1] as $spec) {
                    $specId = $spec->getId();
                    if (!empty($spec)) {
                        $value = $spec->getValue();
                    } else {
                        $value = "Не определён";
                    } // if

                    $statement = $this->_pdo->prepare(self::EDIT_PRODUCT_SPEC);
                    $statement->execute(array($value, $specId));
                } // foreach
            } // if

            $this->_pdo->commit();

            return $productId;
        } catch (PDOException $e) {
            $this->_pdo->rollBack();
            return false;
        } // try-catch
    } // editProduct

    /**
     * Получает товар по айди.
     * @param $productId - существующий айди товара.
     * @return mixed - возвращает товар в виде массива.
     */
    function getProductByID($productId) {
        $statement = $this->_pdo->prepare(self::GET_PRODUCT_BY_ID);
        $statement->execute(array($productId));
        $product = $statement->fetch(PDO::FETCH_ASSOC);
        return $product;
    } // getProductByID

    /**
     * Получение всей информации о продукте по ID. Используется для операций администратора.
     * @param $productId
     * @return mixed
     */
    function getProductByIDAdmin($productId) {
        $statement = $this->_pdo->prepare(self::GET_PRODUCT_BY_ID_ADMIN);
        $statement->execute(array($productId));
        $product = $statement->fetch(PDO::FETCH_ASSOC);
        return $product;
    } // getProductByIDAdmin

    /**
     * Для отображения товаров в категории - включая фильтры и бесконечную прокрутку.
     * @param $subcatId
     * @param $offset
     * @param $filter
     * @return array
     */
    function getSubCatProducts($subcatId, $offset, $filter, $minPrice, $maxPrice) {
        switch ($filter) {
            case 1:
                $statement = $this->_pdo->prepare(self::GET_SUBCAT_PRODUCTS_NEWEST);
                break;
            case 2:
                $statement = $this->_pdo->prepare(self::GET_SUBCAT_PRODUCTS_MOST_SOLD);
                break;
            case 3:
                $statement = $this->_pdo->prepare(self::GET_SUBCAT_PRODUCTS_MOST_REVIEWED);
                break;
            case 4:
                $statement = $this->_pdo->prepare(self::GET_SUBCAT_PRODUCTS_HIGHEST_RATED);
                break;
        } // switch

        $statement->bindValue(":sub", (int)$subcatId, PDO::PARAM_INT);
        $statement->bindValue(":off", (int)$offset, PDO::PARAM_INT);
        $statement->bindValue(":minP", (int)$minPrice, PDO::PARAM_INT);
        $statement->bindValue(":maxP", (int)$maxPrice, PDO::PARAM_INT);

        $statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } // getSubCatProducts

    /**
     * Получение цены на продукт.
     * @param $productId
     * @return mixed
     */
    function getProductPrice($productId) {
        $statement = $this->_pdo->prepare(self::GET_PRODUCT_BY_ID);
        $statement->execute(array($productId));
        $product = $statement->fetch();
        return $product["price"];
    } // getProductPrice

    /**
     * Получение топовых продуктов для главной страницы.
     * @return array
     */
    function getTopRated() {
        $statement = $this->_pdo->prepare(self::GET_MOST_RATED_PRODUCTS);
        $statement->execute(array());
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    } // getTopRated

    /**
     * Получение связанных продуктов.
     * @param $subCat
     * @param $product
     * @return array
     */
    function getRelated($subCat, $product) {
        $statement = $this->_pdo->prepare(self::GET_RELATED_PRODUCTS);
        $statement->execute(array($product, $subCat));
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    } // getRelated

    /**
     * Получение самых последних товаров.
     * @return array
     */
    function getMostRecent() {
        $statement = $this->_pdo->prepare(self::GET_MOST_RECENT_PRODUCTS);
        $statement->execute(array());
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    } // getMostRecent

    /**
     * Поиск продуктов/товаров.
     * @param $needle
     * @return array
     */
    function searchProduct($needle) {
        $statement = $this->_pdo->prepare(self::SEARCH_PRODUCTS);
        $statement->execute(array("%$needle%"));

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } // searchProduct

    /**
     * Поиск товаров без ограничений.
     * @param $needle
     * @return array
     */
    function searchProductNoLimit($needle) {
        $statement = $this->_pdo->prepare(self::SEARCH_PRODUCTS_NO_LIMIT);
        $statement->execute(array("%$needle%"));

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } // searchProductNoLimit

    /**
     * Получение самых продаваемых товаров.
     * @return array
     */
    function mostSoldProducts() {
        $statement = $this->_pdo->prepare(self::GET_MOST_SOLD);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } // mostSoldProducts

    /**
     * Функция для получения всех товаров. Используется для операций администратора
     * @return array
     */
    function getAllProductsAdmin() {
        $statement = $this->_pdo->prepare(self::GET_ALL_PRODUCTS_ADMIN);
        $statement->execute();

        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    } // getAllProductsAdmin

    /**
     * Переключение видимости товара.
     * @param $productId
     * @param $toggleTo
     * @return bool
     */
    function toggleVisibility($productId, $toggleTo) {
        $statement = $this->_pdo->prepare(self::TOGGLE_VISIBILITY);
        $statement->execute(array($toggleTo, $productId));

        return true;
    } // toggleVisibility
} // ProductsDao // @codingStandardsIgnoreEnd