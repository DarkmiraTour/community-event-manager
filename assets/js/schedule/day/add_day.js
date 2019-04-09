'use strict';

import TinyDatePicker from 'tiny-date-picker'

$(document).ready(function() {
    setDefaultDate();
});

function setDefaultDate(){
    document.getElementById("schedule_day").defaultValue = document.querySelector('input[name="eventStart"]').value;
}
TinyDatePicker('.js-datepicker', {
    format(date) {
        var mm = date.getMonth() + 1;
        var dd = date.getDate();
        var yy = date.getFullYear();
        var dateString = yy + '-' + mm + '-' + dd;
        return dateString;
    },
    mode: 'dp-below',
    min: document.querySelector('input[name="eventStart"]').value,
    max: document.querySelector('input[name="eventEnd"]').value,
    }
);
