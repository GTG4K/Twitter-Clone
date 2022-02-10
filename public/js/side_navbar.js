let menu_btn = document.querySelector('#menu_btn')
let logo = document.querySelector('#logo')
let side_navbar = document.querySelector('.side_navbar')
let container = document.querySelector('.container')
let profile = document.querySelector('.profile_content')
let header = document.querySelector('#header')

menu_btn.onclick = function() {
    side_navbar.classList.toggle('active')
    container.classList.toggle('active')
    header.classList.toggle('active')
}

profile.onclick = function(){
    profile.classList.toggle('active')
}

logo.onclick = function(){
    window.location.href = "/home";
}
