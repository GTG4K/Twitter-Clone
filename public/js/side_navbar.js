let menu_btn = document.querySelector('#menu_btn')
let logo = document.querySelector('#logo')
let side_navbar = document.querySelector('.side_navbar')
let container = document.querySelector('.container')
let profile = document.querySelector('.profile_content')
let home_side = document.querySelector('.home_side')
let profile_side = document.querySelector('.profile_side')


menu_btn.onclick = function() {
    side_navbar.classList.toggle('active')
    container.classList.toggle('active')
    home_side.classList.toggle('active')
    profile_side.classList.toggle('active')
}

profile.onclick = function(){
    profile.classList.toggle('active')
}

logo.onclick = function(){
    window.location.href = "/home";
}
