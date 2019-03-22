'use strict'

import $ from "jquery";
import Routing from '../../Components/Routing';

function displayTalk() {
    const slotType = $("#slot_type option:selected").html();

    if (slotType === "Talk") {
        $("#slot_talk").closest(".form-group").removeClass("d-none");
        return;
    }

    $("#slot_talk").closest(".form-group").addClass("d-none");
    $("#slot_talk").val("");
}

function initSlotForm() {
    $('#modalAddSlot').on('submit', 'form', function(e) {
        e.preventDefault()
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
        })
            .done(function(data) {
                location.href = Routing.generate('schedule_index');
            })
            .fail(function(data) {
                $('#modalAddSlot')
                    .find('.modal-body')
                    .html(data.responseJSON.form)
                $('#slot_start').removeClass('form-control')
                $('#slot_end').removeClass('form-control')
            })
    })
}

$(document).ready(function() {
    displayTalk();
    initSlotForm();
});

$("#slot_type").change(function() {
    displayTalk();
});
