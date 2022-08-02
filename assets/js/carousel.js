const carousels = document.getElementsByClassName('carousel')
const controlsPrev = document.querySelectorAll('.carousel-control-prev');
const controlsNext = document.querySelectorAll('.carousel-control-next');

let i = 0;
for (const carousel of carousels) {
    carousel.setAttribute('id', 'carousel_control' + i)
    controlsPrev[i].setAttribute('data-bs-target', '#carousel_control' + i)
    controlsNext[i].setAttribute('data-bs-target', '#carousel_control' + i)
    i++
}