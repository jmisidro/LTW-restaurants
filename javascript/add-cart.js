/* Cart Functions */
if (localStorage.getItem("restaurant") == null)
    localStorage.setItem("restaurant", "0")

function addToCartClicked(event) {
    /* checks for the restarant's name restaurants page, if it is null, check for the restarant's name in the dish page */
    if(document.querySelector('.Rest_header h2') !== null) {
        resth2 = document.querySelector('.Rest_header h2').textContent
    }
    else {
        resth2 = document.querySelector('#restaurant_name > a').textContent
    }
    rest_name = localStorage.getItem("restaurant")
    if(!rest_name || rest_name == "0")
        localStorage.setItem("restaurant", resth2)
    else if (resth2 != rest_name) {
        alert('You may only order from one restaurant at a time.')
        return
    }
    let buttonClicked = event.target
    cartdishid = buttonClicked.id
    carticonquantity = parseInt(document.querySelector('.shop-item-quantity').textContent)

    if (carticonquantity >= 1) {
        document.querySelector('.shop-item-quantity').textContent = carticonquantity + 1
    }
    else {
        document.querySelector('.shop-item-quantity').classList.add('active')
        document.querySelector('.shop-item-quantity').textContent = 1
    }

    fetch('../api/api_add_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cartdishid)
    })
}


/* Event Listeners */

function addToCartEventListeners() {
    let addToCartButtons = document.querySelectorAll('.shop-item-button')
    for (let i = 0; i < addToCartButtons.length; i++) {
        let button = addToCartButtons[i]
        button.addEventListener('click', addToCartClicked)
    }
}


/* Dishes Search */
const searchDish = document.querySelector('#searchdish')
if (searchDish) {
    searchDish.addEventListener('input', async function () {
        const response = await fetch('../api/api_dishes.php?search=' + this.value)
        const response_array = await response.json()
        const dishes = response_array.dishes
        const loggedIn = response_array.loggedIn

        

        const section = document.querySelector('#dishes')
        section.innerHTML = ''

        for (const dish of dishes) {
            const article = document.createElement('article')
            const price = document.createElement('p')
            price.textContent = dish.price + '€'
            price.classList.add('shop-item-price')
            const linkwrapper = document.createElement('a')
            linkwrapper.href = '../pages/dish.php?id=' + dish.id
            const img = document.createElement('img')
            img.src = '../imgs/dishes/small/' + dish.id + '.jpg'
            img.classList.add('shop-item-image')

            const link = document.createElement('a')
            link.href = '../pages/dish.php?id=' + dish.id
            link.textContent = dish.name
            link.classList.add('shop-item-name')
            linkwrapper.appendChild(img)
            article.appendChild(price)
            article.appendChild(linkwrapper)
            article.appendChild(link)

            if(loggedIn) {
                const addlink = document.createElement('a')
                addlink.classList.add('shop-item-button')
                addlink.id = dish.id
                addlink.textContent = 'Add to Cart'
                article.appendChild(addlink)
            }

            section.appendChild(article)
            addToCartEventListeners()
        }
    })

    searchDish.addEventListener('keypress', async function (e) {
        if (e.keyCode == 13) {
            e.preventDefault()
        }
    })
}

addToCartEventListeners()