// Удалить обзор
async function delReview(reviewId) {
    return new Promise((resolve, reject) => {
        var xhttp = new XMLHttpRequest();
        
        xhttp.onreadystatechange = function () {
            document.getElementById("rev-" + reviewId).innerHTML = "";
        };

        xhttp.open("GET", "../../controllers/reviews/remove_review_controller.php?rev=" + reviewId, true);
        xhttp.send();
        resolve();
    });
} // delReview