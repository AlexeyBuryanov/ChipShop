var slideIndex = 1;
showDivs(slideIndex);

async function plusDivs(n) {
    await showDivs(slideIndex += n);
} // plusDivs

async function currentDiv(n) {
    await showDivs(slideIndex = n);
} // currentDiv

async function showDivs(n) {
    return new Promise((resolve, reject) => {
        var i;
        var x = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        if (n > x.length) {slideIndex = 1}
        if (n < 1) {slideIndex = x.length}
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        } // for i
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
        } // for i
        x[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " w3-opacity-off";
        resolve();
    });
} // showDivs