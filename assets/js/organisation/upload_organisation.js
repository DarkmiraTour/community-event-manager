'use strict'

import $ from 'jquery'

$(document).ready(function () {
    getSelectedFileName();
});

function getSelectedFileName() {
    document.querySelector("input[id=organisation_csv_upload_name]").addEventListener('change', function (element) {
        let target = element.target;

        const value = target.value.replace("C:\\fakepath\\", "");
        if (value !== undefined || value !== '') {
            document.querySelector('label.custom-file-label[for="organisation_csv_upload_name"]').dataset.content = value;
            document.querySelector('label.custom-file-label[for="organisation_csv_upload_name"]').textContent = value;
        }
    });
}
