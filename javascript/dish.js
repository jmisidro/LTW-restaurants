function add_remove_popup_dish() {
    const blur = document.querySelector('#popup-remove-dish')
    blur.classList.add('active')
    document.body.classList.add('stop-scrolling')
}

function remove_remove_popup_dish() {
    const blur = document.querySelector('#popup-remove-dish')
    blur.classList.remove('active')
    document.body.classList.remove('stop-scrolling')
}


const removebtn_dish = document.querySelector('#remove-dish-btn')
const closeremovebtn_dish = document.querySelector('#close-remove-btn')
const cancelremovebtn_dish = document.querySelector('#remove-cancel')
const closeoverlay_remove_dish = document.querySelector('#popup-remove-dish .overlay')


// Remove Dish PopUp //

removebtn_dish.addEventListener('click', add_remove_popup_dish)
closeremovebtn_dish.addEventListener('click', remove_remove_popup_dish)
cancelremovebtn_dish.addEventListener('click', remove_remove_popup_dish)
closeoverlay_remove_dish.addEventListener('click', remove_remove_popup_dish)
