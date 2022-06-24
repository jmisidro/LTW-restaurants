function add_review_popup() {
    const blur = document.querySelector('#popup-review')
    blur.classList.add('active')
    document.body.classList.add('stop-scrolling')
}

function remove_review_popup() {
    const blur = document.querySelector('#popup-review')
    blur.classList.remove('active')
    document.body.classList.remove('stop-scrolling')
}

async function edit_review(event){

    const reviewId = event.currentTarget.id
    const blur = document.querySelector('#popup-edit-review')
    blur.classList.add('active')
    document.body.classList.add('stop-scrolling')

    const btn = document.querySelector('#edit-review-id')
    btn.value = reviewId
    const response = await fetch('../api/api_edit_review.php?id=' + reviewId)
    const review = await response.json()

    const comment = document.querySelector('#review-edit-text')

    comment.textContent = review.comment
}

function remove_edit_form(){
    const blur = document.querySelector('#popup-edit-review')
    blur.classList.remove('active')
    document.body.classList.remove('stop-scrolling')
}

// Review PopUp //

const reviewbtn = document.querySelector('#add-review-btn')
const closereviewbtn = document.querySelector('#close-review-btn')
const closeoverlay_review = document.querySelector('#popup-review .overlay')
const closeeditrevbtn = document.querySelector('#close-edit-review-btn')
const closeeditrev_ouverlay = document.querySelector('#popup-edit-review .overlay')

reviewbtn.addEventListener('click', add_review_popup)
closereviewbtn.addEventListener('click', remove_review_popup)
closeoverlay_review.addEventListener('click', remove_review_popup)
closeeditrevbtn.addEventListener('click', remove_edit_form)
closeeditrev_ouverlay.addEventListener('click', remove_edit_form)

let editreviewbtns = document.querySelectorAll('.edit-review-btn')
for (let i = 0; i < editreviewbtns.length; i++) {
    let button = editreviewbtns[i]
    button.addEventListener('click', edit_review)
}
