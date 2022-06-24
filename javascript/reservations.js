const calendar = document.querySelector('.calendar')

const month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']

const available_hours = ['20:00', '20:30', '21:00', '21:30']


function isLeapYear(year) {
    return (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) || (year % 100 === 0 && year % 400 ===0)
}

function getFebDays(year) {
    return isLeapYear(year) ? 29 : 28
}

async function makeReservation() {

    if (selectedDay < 10)
        selectedDay_final = '0' + selectedDay
    else
        selectedDay_final = selectedDay

    dateSelected = yearSelected + '-' + (month_names.indexOf(monthSelected) + 1) + '-' + selectedDay_final + ' ' + available_hours[hourSelected] + ':00'

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(Array(quantitySelected, dateSelected))
    }

    const response = await fetch('../api/api_confirm_reservation.php', options)
    const reservationid = await response.text()

    calendar.innerHTML = ''

    const section =  document.createElement('section')
    section.classList.add('calendar-success')

    const h3 = document.createElement('h3')
    h3.textContent = 'Reservation #' + reservationid + ' confirmed for ' + selectedDay + ' of '  + monthSelected + ', ' + yearSelected + ' at ' + available_hours[hourSelected] + ' for ' + quantitySelected + ' people.'
    
    const link = document.createElement('a')
    link.id = 'reservation-return-home'
    link.href = '../pages/index.php'
    link.textContent = 'Return to Home Page'

    section.appendChild(h3)
    section.appendChild(link)
    calendar.appendChild(section)
}

function selectDay(event) {
    const days = document.querySelectorAll('.calendar-day-hover')
    for (let i = 0; i < days.length; i++) {
        let day = days[i]
        if (day.classList.contains('selected')) {
            day.classList.remove('selected')
        }
    }
    selectedDay = event.target.textContent.replaceAll(' ','').replaceAll('\n','')
    event.target.classList.add('selected')
}

function addPickHour() {
    yearSelected = document.querySelector('#year').textContent
    monthSelected = document.querySelector('#month-picker').textContent
    calendar.innerHTML = ''

    section =  document.createElement('section')
    section.classList.add('calendar-pick-hour')

    h3 = document.createElement('h3')
    h3.textContent = "Pick a time for your reservation"

    select = document.createElement('select')
    select.name = 'calendar_hour'
    op1 =  document.createElement('option')
    op1.value = '0'
    op1.textContent = '20:00'
    op2 =  document.createElement('option')
    op2.value = '1'
    op2.textContent = '20:30'
    op3 =  document.createElement('option')
    op3.value = '2'
    op3.textContent = '21:00'
    op4 =  document.createElement('option')
    op4.value = '3'
    op4.textContent = '21:30'

    sectionFooter = document.createElement('section')
    sectionFooter.classList.add('calendar-pick-hour-footer')
    next = document.createElement('a')
    next.id = 'calendar-next'
    next.textContent =  'Next'
    sectionFooter.appendChild(next)

    select.appendChild(op1)
    select.appendChild(op2)
    select.appendChild(op3)
    select.appendChild(op4)
    section.appendChild(h3)
    section.appendChild(select)
    section.appendChild(sectionFooter)
    calendar.appendChild(section)

    hourSelected = select.value
    next.addEventListener('click', selectQuantity)
    select.addEventListener('click', () => {
        hourSelected = select.value
    })
}

function selectQuantity() {
    calendar.innerHTML = ''

    section =  document.createElement('section')
    section.classList.add('calendar-select-quantity')

    h3 = document.createElement('h3')
    h3.textContent = "Number of people for the reservation"

    input = document.createElement('input')
    input.name = 'select_quantity'
    input.type = 'number' 
    input.value = '2'   

    sectionFooter = document.createElement('section')
    sectionFooter.classList.add('calendar-pick-hour-footer')
    confirm = document.createElement('a')
    confirm.id = 'calendar-confirm'
    confirm.textContent =  'Confirm'
    sectionFooter.appendChild(confirm)

    section.appendChild(h3)
    section.appendChild(input)
    section.appendChild(sectionFooter)
    calendar.appendChild(section)


    quantitySelected = input.value
    input.addEventListener('change', () => {
        if (input.value < 1)
            input.value = 1

        quantitySelected = input.value
    })
    confirm.addEventListener('click', makeReservation)
}

function selectDayEventListeners() {
    const days = document.querySelectorAll('.calendar-day-hover')
    for (let i = 0; i < days.length; i++) {
        let day = days[i]
        if (!day.classList.contains('not-available'))
            day.addEventListener('click', selectDay)
    }
}

function generateCalendar(month, year) {

    let calendar_days = calendar.querySelector('.calendar-days')
    let calendar_header_year = calendar.querySelector('#year')

    let days_of_month = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]

    calendar_days.innerHTML = ''

    let currDate = new Date()
    if(month == null) month = currDate.getMonth()
    if (year == null) year = currDate.getFullYear()

    let curr_month = `${month_names[month]}`
    month_picker.innerHTML = curr_month
    calendar_header_year.innerHTML = year

    // get first day of the given month
    
    let first_day = new Date(year, month, 1)

    for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {
        let day = document.createElement('div')
        if (i >= first_day.getDay()) {
            day.classList.add('calendar-day-hover')

            day.innerHTML = i - first_day.getDay() + 1
            day.innerHTML += `<span></span>
                            <span></span>
                            <span></span>
                            <span></span>`
            
            if ((i - first_day.getDay() + 1 < currDate.getDate() && month === currDate.getMonth() && year === currDate.getFullYear())
            || month < currDate.getMonth() && year == currDate.getFullYear() || year < currDate.getFullYear()) {
                day.classList.add('not-available')
            }
            else if (i - first_day.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() && month === currDate.getMonth()) {
                day.classList.add('curr-date')
            }
            
        }
        calendar_days.appendChild(day)
    }
    selectDayEventListeners()
}

let month_list = calendar.querySelector('.month-list')

month_names.forEach((e, index) => {
    let month = document.createElement('div')
    month.innerHTML = `<div data-month="${index}">${e}</div>`
    month.querySelector('div').addEventListener('click', () => {
        month_list.classList.remove('show')
        curr_month.value = index
        generateCalendar(curr_month.value, curr_year.value)
    })
    month_list.appendChild(month)
})

let month_picker = calendar.querySelector('#month-picker')

month_picker.addEventListener('click', () => month_list.classList.add('show'))


let currDate = new Date()

let curr_month = {value: currDate.getMonth()}
let curr_year = {value: currDate.getFullYear()}

generateCalendar(curr_month.value, curr_year.value)
document.querySelector('#calendar-next').addEventListener('click', addPickHour)

document.querySelector('#prev-year').addEventListener('click', () => {
    --curr_year.value
    generateCalendar(curr_month.value, curr_year.value)
})

document.querySelector('#next-year').addEventListener('click', () => {
    ++curr_year.value
    generateCalendar(curr_month.value, curr_year.value)
})
