function add_comment_form_popup(event){

    const invisbutton = document.querySelector('#add-comment-id')
    invisbutton.value = event.currentTarget.id;

    const blur = document.querySelector('#popup-comment')
    blur.classList.add('active')
    document.body.classList.add('stop-scrolling')
}

function remove_comment_form_popup() {
    const blur = document.querySelector('#popup-comment')
    blur.classList.remove('active')
    document.body.classList.remove('stop-scrolling')
}


async function show_comments(){

    const response = await fetch('../api/api_comments.php')
    const response_array = await response.json()
    const owner = response_array.owner
    const comments = response_array.comments
    const restaurant = response_array.restaurant

    const reviews = document.querySelectorAll('.reviews article')
    if (comments.length !== 0) {
        for (const comment of comments) {
            reviewid = parseInt(comment.ReviewId)
            comment_section = document.querySelector('.comment' + reviewid)
            for (const review of reviews) {
                if (reviewid === parseInt(review.querySelector('section.info').id)) {
                    comment_info = document.createElement('section')
                    comment_info.classList.add('comment-info')
    
                    comment_details = document.createElement('section')
                    comment_details.classList.add('comment-details')
    
                    h3 = document.createElement('h3')
                    h3.textContent = 'Replying to ' + review.querySelector('h3.nome').textContent
                    h3.id = "replying"
    
                    h2 = document.createElement('h3')
                    h2.textContent = 'Owner of ' + restaurant.name
                    h2.id = "ownership"
    
                    img = document.createElement('img')
                    img.src = '../imgs/profile/owners/originals/' + owner.id + '.jpg'
                    img.style.width = "100px"
                    img.style.height = "100px"
                    
                    nome = document.createElement('h3')
                    nome.textContent = owner.name
                    nome.id = "nome"
    
                    p2 = document.createElement('p')
                    p2.textContent = comment.date
                    p2.id = "date"
    
                    cmt = document.createElement('p')
                    cmt.textContent = comment.Comment
                    cmt.id = "review-comment"
                    
                    comment_details.appendChild(p2)
                    comment_details.appendChild(nome)
                    comment_details.appendChild(h2)
                    comment_info.appendChild(img)
                    comment_info.appendChild(comment_details)
                    comment_section.appendChild(h3)
                    comment_section.appendChild(comment_info)
                    comment_section.appendChild(cmt)
                }
            }
        }
    }    
}

let commentreviewbtns = document.querySelectorAll('.add-comment-btn')
for (let i = 0; i < commentreviewbtns.length; i++) {
    let button = commentreviewbtns[i]
    button.addEventListener('click', add_comment_form_popup)
}

let closecomment_overlay = document.querySelectorAll('#popup-comment .overlay')
for (let i = 0; i < closecomment_overlay.length; i++) {
    let button = closecomment_overlay[i]
    button.addEventListener('click', remove_comment_form_popup)
}

let closecomment_btn = document.querySelectorAll('#close-comment-form-btn')
for (let i = 0; i < closecomment_btn.length; i++) {
    let button = closecomment_btn[i]
    button.addEventListener('click', remove_comment_form_popup)
}

show_comments()