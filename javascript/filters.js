/* Filters PopUp */

function add_filters_popup() {
    const blur = document.querySelector('#popup-filters')
    blur.classList.add('active')
    document.body.classList.add('stop-scrolling')
}

function remove_filters_popup() {
    const blur = document.querySelector('#popup-filters')
    blur.classList.remove('active')
    document.body.classList.remove('stop-scrolling')
}


const filtersbtn = document.querySelector('.filtericon')
const closefiltersbtn = document.querySelector('#close-filters-btn')
const closeoverlay_filters = document.querySelector('#popup-filters .overlay')

filtersbtn.addEventListener('click', add_filters_popup)
closefiltersbtn.addEventListener('click', remove_filters_popup)
closeoverlay_filters.addEventListener('click', remove_filters_popup)


/* Filters for Restaurants */

function filterHandler() {
    if (priceSelect.value !== 'None' && (categoryInput.value !== 'None' && categoryInput.value !== '') && favRestaurants !== null) {
        if (favRestaurants.checked) {
            result = intersect_arrays(priceRestaurants, categoryRestaurants)
            restaurants = intersect_arrays(result, favoriteRestaurants)
        }
        else
            restaurants = intersect_arrays(priceRestaurants, categoryRestaurants)
    }
    else if (priceSelect.value !== 'None' && (categoryInput.value !== 'None' && categoryInput.value !== '')) {
        restaurants = intersect_arrays(priceRestaurants, categoryRestaurants)
    }
    else if (priceSelect.value !== 'None' && favRestaurants !== null) {
        if (favRestaurants.checked)
            restaurants = intersect_arrays(priceRestaurants, favoriteRestaurants)
        else
        restaurants = priceRestaurants
    }
    else if ((categoryInput.value !== 'None' && categoryInput.value !== '') && favRestaurants !== null) {
        if (favRestaurants.checked)
            restaurants = intersect_arrays(categoryRestaurants, favoriteRestaurants)
        else
            restaurants = categoryRestaurants
    }
    else if (priceSelect.value !== 'None') {
        restaurants = priceRestaurants
    }
    else if ((categoryInput.value !== 'None' && categoryInput.value !== '')) {
        restaurants = categoryRestaurants
    }
    else if (favRestaurants !== null) {
        if (favRestaurants.checked)
            restaurants = favoriteRestaurants
    }
    else {
        handleSort()
    }

    drawRestaurants(restaurants)
}

function clearValues() {
    priceSelect.value = 'None'
    categoryInput.value = 'None'
    if (favRestaurants !== null)
        favRestaurants.checked = false
}

function sortAsc(){
    if(descArrow.classList.contains('active'))
        descArrow.classList.remove('active')

    if(!ascArrow.classList.contains('active'))
        ascArrow.classList.add('active')

    handleSort()
}

function sortDesc(){
    if(ascArrow.classList.contains('active'))
        ascArrow.classList.remove('active')

    if(!descArrow.classList.contains('active'))
        descArrow.classList.add('active')

    handleSort()
}

async function handleSort() {

    clearValues()
    
    if(!ascArrow.classList.contains('active')) {
        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify('desc')
        }
    
        switch (sortSelect.value) {
            case 'none': 
                response = await fetch('../api/api_restaurants.php?search=')
                restaurants = await response.json()
                restaurants.reverse()
                break;

            case 'name':
                response = await fetch('../api/api_sort_name.php', options)
                restaurants = await response.json()
                break;

            case 'category': 
                response = await fetch('../api/api_sort_category.php', options)
                restaurants = await response.json()
                break;

            case 'price': 
                response = await fetch('../api/api_sort_price.php', options)
                restaurants = await response.json()
                break;

            default: 
                break;
        }
    }
    else {
        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify('asc')
        }
    
        switch (sortSelect.value) {
            case 'none': 
                response = await fetch('../api/api_restaurants.php?search=')
                restaurants = await response.json()
                break;

            case 'name':
                response = await fetch('../api/api_sort_name.php', options)
                restaurants = await response.json()
                break;

            case 'category': 
                response = await fetch('../api/api_sort_category.php', options)
                restaurants = await response.json()
                break;

            case 'price': 
                response = await fetch('../api/api_sort_price.php', options)
                restaurants = await response.json()
                break;

            default: 
                break;
        }
    }


    drawRestaurants(restaurants)
}

async function handlePrice() {

    if(priceSelect.value !== 'None') {
        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(priceSelect.value)
        }

        response = await fetch('../api/api_filter_price.php', options)
        priceRestaurants = await response.json()
  
    }
    else {
        response = await fetch('../api/api_restaurants.php?search=')
        priceRestaurants = await response.json()
    }
        
    filterHandler()
}

async function handleCategory() {
    if((categoryInput.value !== 'None' && categoryInput.value !== '')) {
        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(categoryInput.value)
        }

        response = await fetch('../api/api_filter_category.php', options)
        categoryRestaurants = await response.json()
        
    }
    else {
        response = await fetch('../api/api_restaurants.php?search=')
        categoryRestaurants = await response.json()
    }
        

    filterHandler()
}

async function handleFavRestaurants() {

    if (favRestaurants.checked) {
        response = await fetch('../api/api_filter_favorites.php')
        favoriteRestaurants = await response.json()
    }
    else {
        response = await fetch('../api/api_restaurants.php?search=')
        favoriteRestaurants = await response.json()
    }

    filterHandler()
}


function intersect_arrays(a, b)
{
  let ai=0, bi=0;
  let result = [];

  while( ai < a.length && bi < b.length )
  {
     if      (a[ai]['id'] < b[bi]['id'] ){ ai++; }
     else if (a[ai]['id'] > b[bi]['id'] ){ bi++; }
     else /* they're equal */
     {
       result.push(a[ai]);
       ai++;
       bi++;
     }
  }

  return result;
}


function drawRestaurants(restaurants) {
    const section = document.querySelector('#restaurants')
    section.innerHTML = ''

    if(restaurants.length === 0) {
        const p = document.createElement('p')
        p.textContent = "We couldn't find any restaurants with current filters."
        section.appendChild(p)
    }
    else {
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
    }
}

const ascArrow = document.querySelector('.bxs-up-arrow-alt')
const descArrow = document.querySelector('.bxs-down-arrow-alt')

const sortSelect = document.querySelector("#filters select[name='sort']")
const priceSelect = document.querySelector("#filters select[name='price']")
const categoryInput = document.querySelector("#filters input[name='category']")
const favRestaurants = document.querySelector("#filters input[name='fav']")

/* Event Listeners */
ascArrow.addEventListener('click', sortAsc)
descArrow.addEventListener('click', sortDesc)

sortSelect.addEventListener('change', handleSort)
priceSelect.addEventListener('change', handlePrice)
categoryInput.addEventListener('change', handleCategory)
favRestaurants.addEventListener('change', handleFavRestaurants)
