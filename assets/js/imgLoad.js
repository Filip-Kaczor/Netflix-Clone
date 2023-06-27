refresh_handler = function(e) {
var elements = document.querySelectorAll("*[data-src]");
for (var i = 0; i < elements.length; i++) {
        var boundingClientRect = elements[i].getBoundingClientRect();
        if (elements[i].hasAttribute("data-src") && boundingClientRect.top < (window.innerHeight + 200)) {
            elements[i].setAttribute("src", elements[i].getAttribute("data-src"));
            elements[i].removeAttribute("data-src");
        }
    }
};

window.addEventListener('scroll', refresh_handler);
window.addEventListener('load', refresh_handler);
window.addEventListener('resize', refresh_handler);




const images = document.querySelectorAll("[data-src]");

function preloadImage(img) {
    const src = img.getAttribute("data-src");
    if(!src) {
        return;
    }

    img.src = src;
}

function unloadImage(img) {
    const src = img.getAttribute("data-src");
    img.removeAttribute('src');
}

const imgOptions = {
    threshold: 0,
    rootMargin: "0px 80px 300px 80px"
};

const imgObserver = new IntersectionObserver((entries,
imgObserver) => {
    entries.forEach(entry => {
        if(!entry.isIntersecting) {
            return;
        }else{
            preloadImage(entry.target);
            imgObserver.unobserve(entry.target);
        }
    });
}, imgOptions);

images.forEach(image => {
    imgObserver.observe(image);
});