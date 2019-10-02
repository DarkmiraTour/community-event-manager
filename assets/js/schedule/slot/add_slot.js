function displayTalk() {
    const slotType = $("#slot_type option:selected").html();

    if (slotType === "Talk") {
        $("#slot_talk").closest(".form-group").removeClass("d-none");
        $("#slot_title").closest(".form-group").addClass("d-none");
        $("#slot_title").val("");
        return;
    }

    $("#slot_talk").closest(".form-group").addClass("d-none");
    $("#slot_talk").val("");
    $("#slot_title").closest(".form-group").removeClass("d-none");
}

function setTitleFromTalk() {
    const selectedTalk = $("#slot_talk option:selected").html();
    $("#slot_title").val(selectedTalk);
}

$(document).ready(function() {
    displayTalk();
});

$("#slot_type").change(function() {
    displayTalk();
});

$("#slot_talk").change(function() {
    setTitleFromTalk();
});