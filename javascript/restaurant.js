function add_remove_popup_restaurant() {
    const blur = document.querySelector('#popup-remove-restaurant')
    blur.classList.add('active')
    document.body.classList.add('stop-scrolling')
}

function remove_remove_popup_restaurant() {
    const blur = document.querySelector('#popup-remove-restaurant')
    blur.classList.remove('active')
    document.body.classList.remove('stop-scrolling')
}


const removebtn_restaurant = document.querySelector('#remove-restaurant-btn')
const closeremovebtn_restaurant = document.querySelector('#close-remove-btn')
const cancelremovebtn_restaurant = document.querySelector('#remove-cancel')
const closeoverlay_remove_restaurant = document.querySelector('#popup-remove-restaurant .overlay')


// Remove Restaurant PopUp //

removebtn_restaurant.addEventListener('click', add_remove_popup_restaurant)
closeremovebtn_restaurant.addEventListener('click', remove_remove_popup_restaurant)
cancelremovebtn_restaurant.addEventListener('click', remove_remove_popup_restaurant)
closeoverlay_remove_restaurant.addEventListener('click', remove_remove_popup_restaurant)
