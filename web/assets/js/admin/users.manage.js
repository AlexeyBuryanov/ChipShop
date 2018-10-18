// Забанить/разбанить
async function banUser(userId) {
    return new Promise((resolve, reject) => {
        var banId = document.getElementById("banId-" + userId);
        
        if (banId.innerText == "Забанен") {
            var action = "разбанить";
            var newStatus = 1;
        } else {
            action = "забанить";
            newStatus = 0;
        } // if

        if (confirm("Вы уверены, что хотите " + action + " пользователя с Id " + userId + "?")) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.status == 500 && this.readyState == 4) {
                    window.location.replace("../error/error_500.php");
                } else if (this.status == 400 && this.readyState == 4) {
                    window.location.replace("../error/error_400.php");
                } else if (this.status == 200 && this.readyState == 4) {
                    if (newStatus == 0) {
                        banId.innerHTML = "Забанен";
                    } else {
                        banId.innerHTML = "Активен";
                    } // if
                } // if
            };

            xhttp.open("GET", "../../../controllers/admin/users/ban_user_controller.php?uid=" + userId + "&stat=" + newStatus, true);
            xhttp.send();
        } // if
        resolve();
    });
} // banUser

// Изменить роль
async function changeRole(userId) {
    return new Promise((resolve, reject) => {
        var roleId = document.getElementById("roleId-" + userId);

        if (roleId.innerText == "Пользователь") {
            var action = "дать";
            var newRole = 2;
        } else if (roleId.innerText == "Модератор") {
            action = "отнять";
            newRole = 1;
        } else if (roleId.innerText == "Администратор") {
            alert("Вы не можете изменить роль администратору!");
            throw "";
        } // if

        var question = "Вы уверены, что хотите " + action;
        if (action == "дать") {
            question += " модератора пользователю с Id " + userId + "?"; 
        } else {
            question += " модератора у пользователя с Id " + userId + "?"; 
        } // if

        if (confirm(question)) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.status == 500 && this.readyState == 4) {
                    window.location.replace("../error/error_500.php");
                } else if (this.status == 400 && this.readyState == 4) {
                    window.location.replace("../error/error_400.php");
                } else if (this.status == 200 && this.readyState == 4) {
                    if (newRole == 2) {
                        roleId.innerHTML = "Модератор";
                    } else {
                        roleId.innerHTML = "Пользователь";
                    } // if
                } // if
            };

            xhttp.open("GET", "../../../controllers/admin/users/moderator_user_controller.php?uid=" + userId + "&nrole=" + newRole, true);
            xhttp.send();
        } // if
        resolve();
    });
} // changeRole