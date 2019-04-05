'use strict';

import TinyDatePicker from 'tiny-date-picker'

TinyDatePicker('.js-datepicker', {
    format(date) {
        var mm = date.getMonth() + 1;
        var dd = date.getDate();
        var yy = date.getFullYear();
        var dateString = yy + '-' + mm + '-' + dd;
        return dateString;
    },
    mode: 'dp-below',
    hilightedDate: document.querySelector('input[name="eventStart"]').value,
    min: document.querySelector('input[name="eventStart"]').value,
    max: document.querySelector('input[name="eventEnd"]').value,
    }
);
