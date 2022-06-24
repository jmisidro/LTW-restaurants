/* Owner-Side */

async function show_reservation(event) {
    const restaurantid = event.target.id
    const response = await fetch('../api/api_restaurant_reservations.php?id=' + restaurantid)
    const reservations = await response.json()

    const section = document.querySelector('#reservations-owner')
    section.innerHTML = ''

    if(reservations.length === 0) {
        const p = document.createElement('p')
        p.textContent = "There aren't any reservations from this restaurant."
        section.appendChild(p)
    }

    for (const reservation of reservations) {
        const article = document.createElement('article')
        article.classList.add('reservation')
        if (reservation.status == 'canceled')
            article.classList.add('canceled')
        else
            article.classList.add('reservation')

        /* Reservation Info */
        const reservationinfo = document.createElement('section')
        reservationinfo.classList.add('reservation-info')
        const h2 = document.createElement('h2')
        h2.textContent = reservation.restaurant_name
        const p1 = document.createElement('p')
        p1.id = 'reservation'
        p1.textContent = 'Reservation #' + reservation.id
        const p2 = document.createElement('p')
        p2.id = 'quantity'
        p2.textContent = 'Quantity: ' + reservation.quantity
        const p3 = document.createElement('p')
        p3.id = 'datetime'
        p3.textContent = reservation.datetime
        reservationinfo.appendChild(h2)
        reservationinfo.appendChild(p1)
        reservationinfo.appendChild(p2)
        reservationinfo.appendChild(p3)
        

        /* Reservation Status */
        const reservationstatus = document.createElement('section')
        reservationstatus.classList.add('reservation-status')
        const h3 = document.createElement('h3')
        h3.id = reservation.status
        h3.textContent = reservation.status
        reservationstatus.appendChild(h3)


        /* Reservation Buttons */
        const reservationbuttons = document.createElement('section')
        reservationbuttons.classList.add('reservation-buttons')
        const cancel = document.createElement('a')
        cancel.classList.add('cancel-reservation-button')
        cancel.textContent = 'Cancel'
        reservationbuttons.appendChild(cancel)

        article.appendChild(reservationinfo)
        article.appendChild(reservationstatus)
        article.appendChild(reservationbuttons)
        section.appendChild(article)
    }

    let cancelReservationButtons = document.querySelectorAll('.cancel-reservation-button')
    for (let i = 0; i < cancelReservationButtons.length; i++) {
        let button = cancelReservationButtons[i]
        if (!button.parentElement.parentElement.classList.contains('canceled'))
            button.addEventListener('click', add_cancel_popup_reservation)
    }
}


/* Event Listeners */

let showReservationButtons = document.querySelectorAll('.show-reservations-buttons')
for (let i = 0; i < showReservationButtons.length; i++) {
    let button = showReservationButtons[i]
    button.addEventListener('click', show_reservation)
}