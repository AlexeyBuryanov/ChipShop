<?php // @codingStandardsIgnoreStart
    require_once "../../../controllers/admin/orders/view_order_details_controller.php";
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
        <title>Chip :: Панель администратора :: Заказы :: Подробно о заказе</title>
        <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
        <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
        <script src="../../../web/assets/js/admin/order.manage.js"></script>
    </head>
    <body>
        <div align="center">
            <h2>Заказ №<?= $userDetails[0]["id"] ?></h2>
            <a href="orders_view.php">
                <button class="btn btn-primary">Назад к панели заказов</button>
            </a>
        </div>
        <div class="adminMainWindow">
            Пользователь: <a href="../users/user_details.php?uid=<?= $userDetails[0]["user_id"] ?>"><?= $userDetails[0]["email"] ?></a><br>
            Статус: <div id="status" style="display: inline;"><?= $userDetails[0]['status'] ?></div><br/>
            Изменить статус:
            <select id="newStatus" onchange="changeStatus(<?= $userDetails[0]["id"] ?>)">
                <option value="1" <?= ($userDetails[0]['status'] == 1 ? "selected" : "") ?>>1 - обрабатывается</option>
                <option value="2" <?= ($userDetails[0]['status'] == 2 ? "selected" : "") ?>>2 - отправлен</option>
                <option value="3" <?= ($userDetails[0]['status'] == 3 ? "selected" : "") ?>>3 - завершён</option>
                <option value="4" <?= ($userDetails[0]['status'] == 4 ? "selected" : "") ?>>4 - отменён</option>
            </select><br>
            Дата составления: <?= $userDetails[0]["created_at"] ?><br><br>
            <table>
                <tr>
                    <th>Товар</th>
                    <th>Количество</th>
                </tr>
                <?php
                foreach ($userDetails as $detail) {
                ?>
                    <tr>
                        <td><a href="../../main/single.php?pid=<?= $detail['product_id'] ?>"><?= $detail["product"] ?></a></td>
                        <td><?= $detail["quantity"] ?></td>
                    </tr>
                <?php
                } // foreach
                ?>
            </table>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>