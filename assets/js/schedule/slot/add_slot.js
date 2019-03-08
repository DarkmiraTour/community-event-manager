function displayTalk() {
    const slotType = $("#slot_type option:selected").html();

    if (slotType === "Talk") {
        $("#slot_talk").closest(".form-group").removeClass("d-none");
        return;
    }

    $("#slot_talk").closest(".form-group").addClass("d-none");
    $("#slot_talk").val("");
}

$(document).ready(function() {
    displayTalk();
});

$("#slot_type").change(function() {
    displayTalk();
});
