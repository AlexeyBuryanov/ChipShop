<?php // @codingStandardsIgnoreStart
    require_once "../../../controllers/admin/orders/view_orders_controller.php";
    // Проверка, если пользователь заблокирован
    require_once "../../../utils/blocked_user_dir_back.php";
?>

<!DOCTYPE html>
<html lang="ru-RU">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Алексей Бурьянов"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Chip :: Панель администратора :: Заказы</title>
        <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
        <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
    </head>
    <body>
        <div align="center">
            <h2>Заказы</h2>
            <p>Здесь Вы можете управлять заказами.</p>
            <a href="../admin_panel.php">
                <button class="btn btn-primary">Назад к админ. панели</button>
            </a>
        </div>
        <div class="adminMainWindow">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Пользователь</th>
                    <th>Дата составления</th>
                    <th>Статус</th>
                    <th>Опции</th>
                </tr>
                <?php
                foreach ($orders as $order) {
                ?>
                    <tr>
                        <td><?= $order["id"] ?></td>
                        <td><?= $order["email"] ?></td>
                        <td><?= $order["created_at"] ?></td>
                        <td><?php 
                            switch ($order["status"]) {
                                case 1:
                                    echo("Обрабатывается");
                                    break;
                                case 2:
                                    echo("Отправлен");
                                    break;
                                case 3:
                                    echo("Завершён");
                                    break;
                                case 4:
                                    echo("Отменён");
                                    break;
                            } // switch
                            ?></td>
                        <td>
                            <a href="order_details.php?oid=<?= $order['id'] ?>">
                                <button class="btn btn-warning">Детали</button>
                            </a>
                        </td>
                    </tr>
                <?php
                } // foreach
                ?>
            </table>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>