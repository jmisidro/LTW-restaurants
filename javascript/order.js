/* Customer-Side */

function add_cancel_popup_order(event) {
    const orderid = event.target.parentElement.parentElement.querySelector('#order').textContent.replace("Order #", '')
    document.querySelector('#cancel-order-id').setAttribute('value', orderid)
    const blur = document.querySelector('#popup-cancel-order')
    blur.classList.add('active')
    document.body.classList.add('stop-scrolling')
    if (nav.classList.contains("active")) {
        nav.classList.remove("active")
    }
}

function remove_cancel_popup_order() {
    const blur = document.querySelector('#popup-cancel-order')
    blur.classList.remove('active')
    document.body.classList.remove('stop-scrolling')
}


const closecancelbtn_order = document.querySelector('#close-remove-btn')
const cancelremovebtn_order = document.querySelector('#remove-cancel')
const closeoverlay_remove_order = document.querySelector('#popup-cancel-order .overlay')


// Cancel Order PopUp //

closecancelbtn_order.addEventListener('click', remove_cancel_popup_order)
cancelremovebtn_order.addEventListener('click', remove_cancel_popup_order)
closeoverlay_remove_order.addEventListener('click', remove_cancel_popup_order)


/* Event Listeners */

let cancelOrderButtons = document.querySelectorAll('.cancel-order-button')
for (let i = 0; i < cancelOrderButtons.length; i++) {
    let button = cancelOrderButtons[i]
    if (!button.parentElement.parentElement.classList.contains('canceled'))
        button.addEventListener('click', add_cancel_popup_order)
}
