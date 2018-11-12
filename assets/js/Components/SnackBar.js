'use strict';

import $ from 'jquery';

class SnackBar {
    constructor(color, content) {
        let snackbar = $("#snackbar");

        snackbar.html(content);
        snackbar.addClass(color);
        snackbar.addClass('show');
        setTimeout(function () {
            snackbar.removeClass('show');
            snackbar.removeClass(color);
            snackbar.html("");
        }, 3000);
    }
}

export default SnackBar;
