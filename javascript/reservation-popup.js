/* Customer-Side */

function add_cancel_popup_reservation(event) {
    if (event.target.parentElement.parentElement.querySelector('#reservation') !== null)
        reservationid = event.target.parentElement.parentElement.querySelector('#reservation').textContent.replace("Reservation #", '')
    else 
        reservationid = event.target.parentElement.parentElement.querySelector('.reservation-info p:first-of-type').textContent.replace("Reservation #", '')
        
    document.querySelector('#cancel-reservation-id').setAttribute('value', reservationid)
    const blur = document.querySelector('#popup-cancel-reservation')
    blur.classList.add('active')
    document.body.classList.add('stop-scrolling')
    if (nav.classList.contains("active")) {
        nav.classList.remove("active")
    }
}

function remove_cancel_popup_reservation() {
    const blur = document.querySelector('#popup-cancel-reservation')
    blur.classList.remove('active')
    document.body.classList.remove('stop-scrolling')
}


const closecancelbtn_reservation = document.querySelector('#close-remove-btn')
const cancelremovebtn_reservation = document.querySelector('#remove-cancel')
const closeoverlay_remove_reservation = document.querySelector('#popup-cancel-reservation .overlay')


// Cancel reservation PopUp //

closecancelbtn_reservation.addEventListener('click', remove_cancel_popup_reservation)
cancelremovebtn_reservation.addEventListener('click', remove_cancel_popup_reservation)
closeoverlay_remove_reservation.addEventListener('click', remove_cancel_popup_reservation)


/* Event Listeners */

let cancelReservationButtons = document.querySelectorAll('.cancel-reservation-button')
for (let i = 0; i < cancelReservationButtons.length; i++) {
    let button = cancelReservationButtons[i]
    if (!button.parentElement.parentElement.classList.contains('canceled'))
        button.addEventListener('click', add_cancel_popup_reservation)
}
