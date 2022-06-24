const searchRestaurant = document.querySelector('#searchrestaurant')
if (searchRestaurant) {
    searchRestaurant.addEventListener('input', async function () {
        const response = await fetch('../api/api_restaurants.php?search=' + this.value)
        const restaurants = await response.json()

        const section = document.querySelector('#restaurants')
        section.innerHTML = ''

        for (const restaurant of restaurants) {
            const article = document.createElement('article')
            const linkwrapper = document.createElement('a')
            linkwrapper.href = '../pages/restaurant.php?id=' + restaurant.id
            const img = document.createElement('img')
            img.src = '../imgs/restaurants/small/' + restaurant.id + '.jpg'

            const link = document.createElement('a')
            link.href = '../pages/restaurant.php?id=' + restaurant.id
            link.textContent = restaurant.name
            linkwrapper.appendChild(img)
            article.appendChild(linkwrapper)
            article.appendChild(link)
            section.appendChild(article)
        }
    })

    searchRestaurant.addEventListener('keypress', async function (e) {
        if (e.keyCode == 13) {
            e.preventDefault()
        }
    })
}

const searchYourRestaurant = document.querySelector('#searchrestaurant-profile')
if (searchYourRestaurant) {
    searchYourRestaurant.addEventListener('input', async function () {
        const response = await fetch('../api/api_owner_restaurants.php?search=' + this.value)
        const restaurants = await response.json()

        const section = document.querySelector('#restaurants')
        section.innerHTML = ''

        for (const restaurant of restaurants) {
            const article = document.createElement('article')
            const img = document.createElement('img')
            img.src = '../imgs/restaurants/small/' + restaurant.id + '.jpg'

            const form = document.createElement('form')
            const input = document.createElement('input')
            input.id = 'edit-id'
            input.type = 'text'
            input.name = 'edit-id'
            input.value = restaurant.id
            const button = document.createElement('button')
            button.name = 'edit'
            button.formAction = 'edit_restaurant.php'
            button.formMethod = 'post'
            button.textContent = 'Edit'
            form.appendChild(input)
            form.appendChild(button)
            const link = document.createElement('a')
            link.href = '../pages/restaurant.php?id=' + restaurant.id
            link.textContent = restaurant.name
            article.appendChild(img)
            article.appendChild(form)
            article.appendChild(link)
            section.appendChild(article)
        }
    })

    searchYourRestaurant.addEventListener('keypress', async function (e) {
        if (e.keyCode == 13) {
            e.preventDefault()
        }
    })
}

const searchYourDish = document.querySelector('#searchdish-profile')
if (searchYourDish) {
    searchYourDish.addEventListener('input', async function () {
        const response = await fetch('../api/api_dishes.php?search=' + this.value)
        const response_array = await response.json()
        const dishes = response_array.dishes

        const section = document.querySelector('#dishes-edit')
        section.innerHTML = ''

        for (const dish of dishes) {
            const article = document.createElement('article')
            const img = document.createElement('img')
            img.src = '../imgs/dishes/originals/' + dish.id + '.jpg'
            img.style.width = "300px"
            img.style.height = "300px"

            const form = document.createElement('form')
            const input = document.createElement('input')
            input.id = 'edit-id'
            input.type = 'text'
            input.name = 'edit-id'
            input.value = dish.id
            const button = document.createElement('button')
            button.name = 'edit'
            button.formAction = 'edit_dish.php'
            button.formMethod = 'post'
            button.textContent = 'Edit'
            form.appendChild(input)
            form.appendChild(button)
            const link = document.createElement('a')
            link.href = '../pages/dish.php?id=' + dish.id
            link.textContent = dish.name
            article.appendChild(img)
            article.appendChild(form)
            article.appendChild(link)
            section.appendChild(article)
        }
    })

    searchYourDish.addEventListener('keypress', async function (e) {
        if (e.keyCode == 13) {
            e.preventDefault()
        }
    })
}

const searchOrder = document.querySelector('#searchorder')
if (searchOrder) {
    searchOrder.addEventListener('input', async function () {
        const response = await fetch('../api/api_orders.php?search=' + this.value)
        const orders = await response.json()

        const section = document.querySelector('#orders-user')
        section.innerHTML = ''

        for (const order of orders) {
            const article = document.createElement('article')
            article.classList.add('order')
            if (order.status == 'canceled')
                article.classList.add('canceled')
            else
                article.classList.add('order')

            /* Order Info */
            const orderinfo = document.createElement('section')
            orderinfo.classList.add('order-info')
            const h2 = document.createElement('h2')
            h2.textContent = order.restaurant_name
            const p1 = document.createElement('p')
            p1.id = 'order'
            p1.textContent = 'Order #' + order.id
            const p2 = document.createElement('p')
            p2.id = 'total'
            p2.textContent = 'Total: ' + order.total + '€'
            const p3 = document.createElement('p')
            p3.id = 'date'
            p3.textContent = order.date
            orderinfo.appendChild(h2)
            orderinfo.appendChild(p1)
            orderinfo.appendChild(p2)
            orderinfo.appendChild(p3)
            

            /* Order Status */
            const orderstatus = document.createElement('section')
            orderstatus.classList.add('order-status')
            const h3 = document.createElement('h3')
            h3.id = order.status
            h3.textContent = order.status
            if (order.status !== 'canceled') {
                const p4 = document.createElement('p')
                p4.id = 'estimated-time'
                p4.textContent = 'Estimated delivery time: 20:53'
                orderstatus.appendChild(h3)
                orderstatus.appendChild(p4)
            }
            else 
                orderstatus.appendChild(h3)


            /* Order Buttons */
            const orderbuttons = document.createElement('section')
            orderbuttons.classList.add('order-buttons')
            const a1 = document.createElement('a')
            a1.href = '../pages/receipt.php?id=' + order.id
            a1.textContent = 'Details'
            const a2 = document.createElement('a')
            a2.classList.add('cancel-order-button')
            a2.textContent = 'Cancel'
            orderbuttons.appendChild(a1)
            orderbuttons.appendChild(a2)

            article.appendChild(orderinfo)
            article.appendChild(orderstatus)
            article.appendChild(orderbuttons)
            section.appendChild(article)
        }
    })

    searchOrder.addEventListener('keypress', async function (e) {
        if (e.keyCode == 13) {
            e.preventDefault()
        }
    })
}


const searchReservation = document.querySelector('#searchreservation')
if (searchReservation) {
    searchReservation.addEventListener('input', async function () {
        const response = await fetch('../api/api_reservations.php?search=' + this.value)
        const reservations = await response.json()

        const section = document.querySelector('#reservations-user')
        section.innerHTML = ''

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
    })

    searchOrder.addEventListener('keypress', async function (e) {
        if (e.keyCode == 13) {
            e.preventDefault()
        }
    })
}