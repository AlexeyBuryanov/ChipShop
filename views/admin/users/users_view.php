<?php // @codingStandardsIgnoreStart
    require_once "../../../controllers/admin/users/view_users_controller.php";
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
        <title>Chip :: Панель администратора :: Пользователи</title>
        <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
        <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
        <script src="../../../web/assets/js/admin/users.manage.js"></script>
    </head>
    <body>
        <div align="center">
            <h2>Пользователи</h2>
            <p>Здесь Вы управляете пользователями.</p>
            <a href="../admin_panel.php"><button class="btn btn-primary">Админ. панель</button></a>
        </div>
        <div class="adminMainWindow">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Email</th>
                    <th>Статус</th>
                    <th>Роль</th>
                </tr>
                <?php
                foreach ($users as $user) {
                ?>
                    <tr>
                        <td><?= $user["id"] ?>
                            <a href="user_details.php?uid=<?= $user['id'] ?>"><button class="btn btn-info">Профиль</button></a>
                        </td>
                        <td><?= $user["email"] ?></td>
                        <td>
                            <div id="banId-<?= $user['id'] ?>"><?= ($user['enabled'] == 1 ? "Активен" : "Забанен") ?></div>
                            <?php
                            if ($user["id"] != 1) {
                            ?>
                                <button class="btn btn-danger" onclick="banUser(<?= $user['id'] ?>)">Забанить/разбанить</button>
                            <?php
                            } // if
                            ?>
                        </td>
                        <td>
                            <div id="roleId-<?= $user['id'] ?>">
                            <?php 
                                switch ($user["role"]) {
                                    case 1:
                                        echo("Пользователь");
                                        break;
                                    case 2:
                                        echo("Модератор");
                                        break;
                                    case 3:
                                        echo("Администратор");
                                        break;
                                } // switch
                            ?></div>
                            <?php
                            if ($user['id'] != 1) {
                            ?>
                                <button class="btn btn-warning" onclick="changeRole(<?= $user['id'] ?>)">Дать/отнять модератора</button>
                            <?php
                            } // if
                            ?>
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