'use strict';

import $ from 'jquery';
import Routing from '../Components/Routing';
import '../../css/sponsorshipLevelBenefit/edit.scss';

$(document).ready(function() {
    updateLevelArrows();
    updateBenefitArrows();
    initSponsorshipLevelBenefitActions();
});

/* edit position of Sponsorhip Level */
function sendLevelPosition(level_id, move) {
    const token = $('#sponsorshipLevelBenefitForm').find('input[name="_token"]').val();

    $.ajax({
        url: Routing.generate('sponsorship_level_benefit_edit_level_position'),
        type: "PUT",
        DataType: "json",
        data: {
            id: level_id,
            move: move,
            _token: token
        },
        success: function(result) {
            moveLevel(level_id, result['new_level_id'], move);
        }
    });
}

function moveLevel(old_id, new_id, move) {
    moveBenefitTr(old_id, new_id, move);
    moveContentLevelTh(old_id, new_id, move);
    updateLevelArrows();
}

function moveBenefitTr(old_id, new_id, move) {
    $('.benefit_tr').each(function() {
        let old_content = '<td data-id="'+old_id+'">' + $(this).find('td[data-id="'+old_id+'"]').html() + '</td>';
        $(this).find('td[data-id="'+old_id+'"]').remove();
        if (move === 'left') {
            $(this).find('td[data-id="'+new_id+'"]').before(old_content);
            return;
        }
        $(this).find('td[data-id="'+new_id+'"]').after(old_content);
    });
}

function moveContentLevelTh(old_id, new_id, move) {
    const old_content = '<th class="level_th" data-id="'+old_id+'">' + $('.level_th[data-id="'+old_id+'"]').html() + '</th>';
    $('.level_th[data-id="'+old_id+'"]').remove();
    if (move === 'left') {
        $('.level_th[data-id="'+new_id+'"]').before(old_content);
        return false;
    }
    $('.level_th[data-id="'+new_id+'"]').after(old_content);
}

function updateLevelArrows() {
    const countLevels = $('.list_levels .level_th').length;

    $('.list_levels .level_th').each(function() {
        let index = parseInt($(this).index());

        $(this).find('.fa-caret-left').removeClass('d-none');
        $(this).find('.fa-caret-right').removeClass('d-none');
        $(this).find('.fa-caret-right').removeClass('ml-sm-2');

        if (index === 1) {
            $(this).find('.fa-caret-left').addClass('d-none');
            $(this).find('.fa-caret-right').addClass('ml-sm-2');
        }
        if (index === countLevels) {
            $(this).find('.fa-caret-right').addClass('d-none');
        }
    });
    initLevelActions();
    initSponsorshipLevelBenefitActions();
}

function initLevelActions() {
    $('.level_th .fa-caret-left').click(function() {
        sendLevelPosition($(this).parent().attr('data-id'), 'left');
    });

    $('.level_th .fa-caret-right').click(function() {
        sendLevelPosition($(this).parent().attr('data-id'), 'right');
    });
}

/* edit position of Sponsorhip Benefit */
function sendBenefitPosition(benefit_id, move) {
    const token = $('#sponsorshipLevelBenefitForm').find('input[name="_token"]').val();

    $.ajax({
        url: Routing.generate('sponsorship_level_benefit_edit_benefit_position'),
        type: "PUT",
        DataType: "json",
        data: {
            id: benefit_id,
            move: move,
            _token: token
        },
        success: function(result) {
            moveBenefit(benefit_id, result['new_benefit_id'], move);
        }
    });
}

function moveBenefit(old_id, new_id, move) {
    let old_object = '<tr class="benefit_tr" data-id="'+old_id+'">' + $('.benefit_tr[data-id="'+old_id+'"]').html() + '</tr>';
    $('.benefit_tr[data-id="'+old_id+'"]').remove();
    if (move === 'up') {
        $('.benefit_tr[data-id="'+new_id+'"]').before(old_object);
        updateBenefitArrows();
        return false;
    }
    $('.benefit_tr[data-id="'+new_id+'"]').after(old_object);
    updateBenefitArrows();
}

function updateBenefitArrows() {
    const countLevels = $('.list_benefits .benefit_tr').length;
    $('.list_benefits .benefit_tr').each(function() {
        let index = parseInt($(this).index());

        $(this).find('.fa-caret-up').removeClass('d-none');
        $(this).find('.fa-caret-up').removeClass('mt-md-3');
        $(this).find('.fa-caret-down').removeClass('d-none');
        $(this).find('.fa-caret-down').removeClass('mt-md-3');

        if (index === 0) {
            $(this).find('.fa-caret-up').addClass('d-none');
            $(this).find('.fa-caret-down').addClass('mt-md-3');
        }
        if (index === countLevels - 1) {
            $(this).find('.fa-caret-down').addClass('d-none');
            $(this).find('.fa-caret-up').addClass('mt-md-3');
        }
    });
    initBenefitActions();
    initSponsorshipLevelBenefitActions();
}

function initBenefitActions() {
    $('.benefit_tr .fa-caret-up').click(function() {
        sendBenefitPosition($(this).closest('.benefit_tr').attr('data-id'), 'up');
    });

    $('.benefit_tr .fa-caret-down').click(function() {
        sendBenefitPosition($(this).closest('.benefit_tr').attr('data-id'), 'down');
    });
}

/* save changes of SponsorshipLevelBenefit */
function initSponsorshipLevelBenefitActions() {
    $('.benefit_tr input[type="checkbox"]').click(function() {
        const benefit_id = $(this).closest('.benefit_tr').attr('data-id');
        const level_id = $(this).parent().attr('data-id');
        const is_check = $(this).is(':checked');

        if (!is_check) {
            $(this).parent().find('input[type="text"]').val("");
        }

        saveDatas(benefit_id, level_id, is_check);
    });

    $('.benefit_tr .fa-check').click(function() {
        const benefit_id = $(this).closest('.benefit_tr').attr('data-id');
        const level_id = $(this).parent().attr('data-id');
        const text = $(this).parent().find('input[type="text"]').val();

        if (text != null) {
            $(this).parent().find('input[type="checkbox"]').prop('checked', true);
        }
        $(this).addClass('text-hide');
        saveDatas(benefit_id, level_id, true, text);
    });

    $('.benefit_tr input[type="text"]').keydown(function() {
        $(this).parent().find('.fa-check').removeClass('text-hide');
    });
}

function saveDatas(benefit_id, level_id, is_checked, text) {
    const token = $('#sponsorshipLevelBenefitForm').find('input[name="_token"]').val();

    $.ajax({
        url: Routing.generate('sponsorship_level_benefit_edit_datas'),
        type: "PUT",
        DataType: "json",
        data: {
            benefit_id: benefit_id,
            level_id: level_id,
            is_checked: is_checked,
            text: text,
            _token: token
        },
        success: function(result) {}
    });
}
