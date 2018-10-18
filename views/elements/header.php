</head>
<body>
<div class="top_bar">
    <div class="container">
        <div class="header_top">
            <!-- Пользовательский элемент -->
            <div class="top_right">
                <ul>
                    <?php // @codingStandardsIgnoreStart
                    if (isset($_SESSION['loggedUser'])) {
                        echo("<li><a href='../../utils/log_out.php'>Выйти</a></li>");
                        echo("<li><a href='../user/edit.php'>Редактировать профиль</a></li>");
                    } else {
                        echo("<li><a href='../user/login.php'>Войти</a></li>");
                        echo("<li><a href='../user/register.php'>Регистрация</a></li>");
                    } // if ?>
                    <?php 
                    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 3)) { ?>
                        <li><a href="../admin/admin_panel.php">Панель администратора</a></li>
                    <?php 
                    } else if (isset($_SESSION["role"]) && ($_SESSION["role"] == 2)) { ?>
                        <li><a href="../admin/admin_panel.php">Панель модератора</a></li>
                    <?php } // if ?>
                </ul>
            </div>
            <?php
            $url = $_SERVER["PHP_SELF"];
            $urlCheck = array_slice(explode('/', $url), -2)[0];
            $urlCheck2 = array_slice(explode('/', $url), -3)[0];
            // Если это не папка admin, добавляем панель поиска
            if ($urlCheck != "admin" && $urlCheck2 != "admin") { ?>
                <!-- Панель поиска -->
                <div class="top_left">
                    <form action="../main/search.php" method="get" autocomplete="off">
                        <input name="search" id="search" class="form-control" type="text" placeholder="Enter для поиска" onkeyup="searchSuggest()" required>
                        <div id="result"></div>
                        <input type="submit" id="search-submit">
                    </form>
                </div>
            <?php
            } // if ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php // @codingStandardsIgnoreEnd ?>