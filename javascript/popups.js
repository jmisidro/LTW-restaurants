const blurLogin = document.querySelector('#popup-login')
const blurRegister = document.querySelector('#popup-register')

function add_login_popup() {
    if (blurRegister.classList.contains("active"))
        blurRegister.classList.remove("active")
        
    blurLogin.classList.add('active')
    document.body.classList.add('stop-scrolling')
    if (nav.classList.contains("active")) {
        nav.classList.remove("active")
    }
}

function remove_login_popup() {
    blurLogin.classList.remove('active')
    document.body.classList.remove('stop-scrolling')
}

function add_register_popup() {
    if (blurLogin.classList.contains("active"))
        blurLogin.classList.remove("active")

    blurRegister.classList.add('active')
    document.body.classList.add('stop-scrolling')
    if (nav.classList.contains("active")) {
        nav.classList.remove("active")
    }
}

function remove_register_popup() {
    blurRegister.classList.remove('active')
    document.body.classList.remove('stop-scrolling')
}

const loginbtn = document.querySelector('#loginbtn')
const registerbtn = document.querySelector('#registerbtn')

const closeloginbtn = document.querySelector('#close-login-btn')
const closeoverlay_login = document.querySelector('#popup-login .overlay')

const closeregisterbtn = document.querySelector('#close-register-btn')
const closeoverlay_register = document.querySelector('#popup-register .overlay')


// Login and Register PopUps //

loginbtn.addEventListener('click', add_login_popup)
registerbtn.addEventListener('click', add_register_popup)

closeloginbtn.addEventListener('click', remove_login_popup)
closeregisterbtn.addEventListener('click', remove_register_popup)

closeoverlay_login.addEventListener('click', remove_login_popup)
closeoverlay_register.addEventListener('click', remove_register_popup)

