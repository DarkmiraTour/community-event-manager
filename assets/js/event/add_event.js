'use strict';

import {DateRangePicker} from 'tiny-date-picker/dist/date-range-picker';

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

(function () {
    const root = document.querySelector('.inputs-event');
    const txtStart = root.querySelector('.start-at');
    const txtEnd = root.querySelector('.end-at');
    const container = root.querySelector('.inputs-picker-event');

    DateRangePicker(container)
        .on('statechange', function (_, rp) {
            let range = rp.state;
            txtStart.value = range.start ? formatDate(range.start.toDateString()) : '';
            txtEnd.value = range.end ?  formatDate(range.end.toDateString()) : '';
        });

    txtStart.addEventListener('focus', showPicker);
    txtEnd.addEventListener('focus', showPicker);

    function showPicker() {
        container.style.display = "block";
    }
    let previousTimeout;
    root.addEventListener('focusout', function hidePicker() {
        clearTimeout(previousTimeout);
        previousTimeout = setTimeout(function() {
            if (!root.contains(document.activeElement)) {
                container.style.display = "none";

            }
        }, 10);
    });

}());
