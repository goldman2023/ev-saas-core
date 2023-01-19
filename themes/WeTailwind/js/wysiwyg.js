// Image Compare
document.querySelectorAll('.wysiwyg__image-compare--slider').forEach((slider) => {
    slider.addEventListener('input', (e) => {
        const sliderPos = e.target.value;
        const wrapper = slider.closest('.wysiwyg__image-compare');

        // Update the width of the foreground image
        wrapper.querySelector('.foreground-img').style.width = `${sliderPos - 0.3}%`;
        // Update the position of the slider button
        wrapper.querySelector('.wysiwyg__image-compare--slider-button').style.left = `calc(${sliderPos}% - 19px)`;
    });
});
// END Image Compare