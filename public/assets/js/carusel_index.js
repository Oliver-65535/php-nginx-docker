document.addEventListener("DOMContentLoaded", function() {

    let animation_values = ["wealth","stability","prosperity","freedom", "SELF", "future"];

    let animation_list = document.querySelector(".animation__container__list");

    let animation_item = document.querySelector(".animation__container__list>.animation__item");

    let index = 0;

    animation_list.addEventListener("animationiteration", () => {
        if (index >= animation_values.length) {index = 0;}
        animation_item.innerHTML = animation_values[index];
        index++;
    });

 });