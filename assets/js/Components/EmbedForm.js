'use strict';

import $ from 'jquery';

class EmbedForm {
    /**
     * @constructor
     *
     * @param {jQuery} $prototypeContainer - The form container with data-prototype
     * @param {Array} options
     *                  $addButton (optional) custom Add button
     *                  $itemWrapper (optional) custom wrapper to wrap all added items
     */
    constructor($prototypeContainer, options = {}) {
        $prototypeContainer.data('index', $prototypeContainer.find(':input').length);

        if (!options.$addButton) {
            options.$addButton = $('<button type="button" class="btn btn-primary">Add</button>');
        }

        if (!options.$itemWrapper) {
            options.$itemWrapper = $('<fieldset class="form-group"></fieldset>');
        }

        options.$addButton.on('click', function (e) {
            EmbedForm.addPrototypedItem($prototypeContainer, options);
        });

        EmbedForm.addPrototypedItem($prototypeContainer, options);

        $prototypeContainer.after(options.$addButton);
    }

    static addPrototypedItem($prototypeContainer, options) {
        var prototype = $prototypeContainer.data('prototype');
        var index = $prototypeContainer.data('index');

        var newForm = prototype.replace(/__name__/g, index);
        $prototypeContainer.data('index', index + 1);

        $prototypeContainer.append(options.$itemWrapper.clone().append(newForm));
    }
}

export default EmbedForm;
