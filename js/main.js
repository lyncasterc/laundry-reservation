const timeslotRows = document.querySelectorAll('.timeslots-container');
const weekdaySelect = document.querySelector('#weekday-input');
const hourSelect = document.querySelector('#hour-input');
const reservationForm = document.querySelector('#reserve');

// renders options for weekday select for weekdays that have at least one timeslot
timeslotRows.forEach(row => {
    if(row.children.length > 0) {
        const option = document.createElement('option');
        option.value = row.dataset.weekday;
        option.textContent = row.dataset.weekday;
        weekdaySelect.appendChild(option);
    }
});

// renders options for hour select for the selected weekday based on the timeslots available
const renderHourOptions = (weekday) => {
    const WeekdayRow = document.querySelector(`[data-weekday="${weekday}"]`);

    Array.from(WeekdayRow.children).forEach(child => {
        const option = document.createElement('option');
        option.value = child.dataset.hour;
        option.textContent = child.textContent;
        hourSelect.appendChild(option);
    });
}

// event listener to re-render hour options when the weekday is changed
weekdaySelect.addEventListener('change', () => {
        hourSelect.innerHTML = '';
        const selectedWeekday = weekdaySelect.value;
        renderHourOptions(selectedWeekday);
    }
);

// confirmation for when timeslot form is submitted
reservationForm.addEventListener('submit', () => {
    const selectedWeekday = weekdaySelect.value;
    const selectedHour = hourSelect.options[hourSelect.selectedIndex].innerText.trim();
    return confirm(`Are you sure you want to reserve this timeslot?\n${selectedWeekday} at ${selectedHour}`);
});

renderHourOptions(weekdaySelect.value);

