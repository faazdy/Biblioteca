const burgerBtn = document.querySelector('#burger');
const menuBurger = document.querySelector('.menu-burger');

burgerBtn.addEventListener('change', ()=>{
    if(burgerBtn.checked){
        menuBurger.style.display = 'block'
    } else {
        menuBurger.style.display = 'none'
    }
})
