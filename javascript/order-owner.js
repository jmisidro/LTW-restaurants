/* Owner-Side */

async function show_order(event) {
    const restaurantid = event.target.id
    const response = await fetch('../api/api_restaurant_orders.php?id=' + restaurantid)
    const orders = await response.json()

    const section = document.querySelector('#orders-owner')
    section.innerHTML = ''

    if(orders.length === 0) {
        const p = document.createElement('p')
        p.textContent = "There aren't any orders from this restaurant."
        section.appendChild(p)
    }

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
        
        if (order.status !== 'canceled') {
            const select = document.createElement('select')
            select.classList.add('order-status-select')
            select.name = 'status'

            const op1 = document.createElement('option')
            op1.setAttribute('value', 'preparing')
            op1.textContent = 'Preparing'
            const op2 = document.createElement('option')
            op2.setAttribute('value', 'delivery')
            op2.textContent = 'Delivery'
            const op3 = document.createElement('option')
            op3.setAttribute('value', 'completed')
            op3.textContent = 'Completed'

            select.appendChild(op1)
            select.appendChild(op2)
            select.appendChild(op3)
            orderbuttons.appendChild(select)
        }
                
        orderbuttons.appendChild(a1)

        article.appendChild(orderinfo)
        article.appendChild(orderstatus)
        article.appendChild(orderbuttons)
        section.appendChild(article)
    }
}


/* Event Listeners */

let showOrderButtons = document.querySelectorAll('.show-orders-buttons')
for (let i = 0; i < showOrderButtons.length; i++) {
    let button = showOrderButtons[i]
    button.addEventListener('click', show_order)
}