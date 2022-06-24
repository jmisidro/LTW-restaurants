cart = document.querySelector('.cart')
if (document.querySelector('.shop-item-quantity').textContent !== '')
    document.querySelector('.shop-item-quantity').classList.add('active')
cart.classList.remove("active")
setShippingValue(5)     // Sets Shipping Value (hard-coded for now)
updateCartTotal()       // Updates Cart total

/* Cart Functions */

async function checkout(orderid) {
    const response = await fetch('../api/api_check_info_complete.php')
    const infoComplete = await response.text()

    if (infoComplete) {
        fetch('../api/api_clear_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
    
        setShippingValue(0)
        document.querySelector('.shop-item-quantity').classList.remove('active')
        localStorage.setItem("restaurant", "0")
    
        const messages = document.querySelector('#messages')
        const section = document.createElement('section')
        const link1 = document.createElement('a')
        link1.id = 'view-order'
        link1.href = '../pages/receipt.php?id=' + orderid
        link1.textContent = 'View Order'
        section.appendChild(link1)
    
        const link2 = document.createElement('a')
        link2.id = 'cart-return-home'
        link2.href = '../pages/index.php'
        link2.textContent = 'Return to Home Page'
        section.appendChild(link2)
    
        document.querySelector('.cart-order').remove()
        document.querySelector('.order-summary').remove()
        cart.appendChild(section)
        cart.classList.add('active')
    
        article = document.createElement('article')
        article.classList.add('info')
        article.textContent = "You have submitted your order."
    
        messages.appendChild(article)
    }
    else {
        error = document.querySelector('.infoComplete')
        error.classList.add('active')
    }

}

function setShippingValue(value) {
    document.querySelector('#order-shipping-value').textContent = value + '€'
}

function removeCartItem(event) {
    let buttonClicked = event.target
    cartdishid = buttonClicked.parentElement.id
    removedquantity = parseInt(buttonClicked.parentElement.parentElement.querySelector('.cart-order-quantity').textContent)
    buttonClicked.parentElement.parentElement.remove()
    carticonquantity = parseInt(document.querySelector('.shop-item-quantity').textContent)
    updateCartTotal()
    
    fetch('../api/api_remove_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cartdishid)
    })

    document.querySelector('.shop-item-quantity').textContent = carticonquantity - removedquantity
    if (document.querySelector('.shop-item-quantity').textContent == 0) {
        document.querySelector('.shop-item-quantity').classList.remove('active')
    }
}

function clearCart() {
    let cartItemContainer = document.querySelector('.cart-order')
    let cartRows = cartItemContainer.querySelectorAll('.cart-item')
    for (let i = 0; i < cartRows.length; i++) {
        let cartRow = cartRows[i]
        cartRow.remove()
    }

    updateCartTotal()

}

function quantityDecrease(event) {
    let section = event.target.parentElement.parentElement
    let input = section.querySelector('.cart-order-quantity')
    let value = input.textContent
    carticonquantity = parseInt(document.querySelector('.shop-item-quantity').textContent)
    if (value > 1) {
        value--   
        carticonquantity--
    }
    input.textContent = value
    document.querySelector('.shop-item-quantity').textContent = carticonquantity
    updateCartTotal()
    cartdishid = section.parentElement.querySelector('.delete-button').id

    fetch('../api/api_decrease_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cartdishid)
    })
}


function quantityIncrease(event) {
    let section = event.target.parentElement.parentElement
    let input = section.querySelector('.cart-order-quantity')
    let value = input.textContent
    carticonquantity = parseInt(document.querySelector('.shop-item-quantity').textContent)
    value++
    carticonquantity++
    input.textContent = value
    document.querySelector('.shop-item-quantity').textContent = carticonquantity
    updateCartTotal()
    cartdishid = section.parentElement.querySelector('.delete-button').id

    fetch('../api/api_add_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cartdishid)
    })
}

function updateCartTotal() {
    let cartItemContainer = document.querySelector('.cart-order')
    let cartRows = cartItemContainer.querySelectorAll('.cart-item')
    if (cartRows.length === 0) {
        fetch('../api/api_clear_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })

        setShippingValue(0)
        document.querySelector('.shop-item-quantity').classList.remove('active')
        localStorage.setItem("restaurant", "0")

        const messages = document.querySelector('#messages')
        const section = document.createElement('section')
        const link = document.createElement('a')
        link.id = 'cart-return-home'
        link.href = '../pages/index.php'
        link.textContent = 'Return to Home Page'
        section.appendChild(link)

        document.querySelector('.cart-order').remove()
        document.querySelector('.order-summary').remove()
        cart.appendChild(section)
        cart.classList.add('active')

        article = document.createElement('article')
        article.classList.add('info')
        article.textContent = "Your cart is now empty."

        messages.appendChild(article)
    }
    else {
        let subtotal = 0, total = 0
        for (let i = 0; i < cartRows.length; i++) {
            let cartRow = cartRows[i]
            let priceElement = cartRow.querySelector('.cart-item-price')
            let quantityElement = cartRow.querySelector('.cart-order-quantity')
            let price = parseFloat(priceElement.textContent.replace('€', ''))
            let quantity = quantityElement.textContent
            subtotal = subtotal + (price * quantity)
        }
        subtotal = Math.round(subtotal * 100) / 100
        document.querySelector('#order-subtotal-value').textContent = subtotal + '€'
        shipping = parseFloat(document.querySelector('#order-shipping-value').textContent.replace('€', ''))
        total = subtotal + shipping
        document.querySelector('#order-total-value').textContent = total + '€'
    }
}

/* Event Listeners */

let removeCartItemButtons = document.querySelectorAll('.delete-button')
for (let i = 0; i < removeCartItemButtons.length; i++) {
    let button = removeCartItemButtons[i]
    button.addEventListener('click', removeCartItem)
}

let quantityDecreaseBtns = document.querySelectorAll('.cart-order-quantity-decrease')
for (let i = 0; i < quantityDecreaseBtns.length; i++) {
    let button = quantityDecreaseBtns[i]
    button.addEventListener('click', quantityDecrease)
}

let quantityIncreaseBtns = document.querySelectorAll('.cart-order-quantity-increase')
for (let i = 0; i < quantityIncreaseBtns.length; i++) {
    let button = quantityIncreaseBtns[i]
    button.addEventListener('click', quantityIncrease)
}

const clearCartBtn = document.querySelector('#cart-clear')
clearCartBtn.addEventListener('click', clearCart)


const checkoutBtn = document.querySelector('#checkout-button')
checkoutBtn.addEventListener('click', async function () {
    const ordertotal = parseFloat(document.querySelector('#order-total-value').textContent.replace('€', ''))
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(ordertotal)
    }

    /* Creates a new order through the '../api/api_submit_order.php' API and retrieves the order's id */
    const response = await fetch('../api/api_submit_order.php', options)
    const orderid = await response.text()

    cartItemContainer = document.querySelector('.cart-order')
    cartRows = cartItemContainer.querySelectorAll('.cart-item')
    /* For each item in the cart, creates a new orderdish with the new order's id and the respective dishid and quantity */
    for (let i = 0; i < cartRows.length; i++) {
        let cartRow = cartRows[i]
        const dishid = cartRow.querySelector('.delete-button').id
        const orderquantity = cartRow.querySelector('.cart-order-quantity').textContent

        fetch('../api/api_submit_orderdish.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(Array(orderid, dishid, orderquantity))
        })
    }

    checkout(orderid)
})

