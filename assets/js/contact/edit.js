'use strict';

import $ from 'jquery';
import EmbedForm from '../Components/EmbedForm';

$(function () {
    new EmbedForm($('.contact-addresses'), {
        $addButton: $('<button type="button" class="btn btn-primary">Add address</button>'),
        $itemWrapper: $('<fieldset class="form-group"><legend class="col-form-label">Address</legend></fieldset>')
    });
});
