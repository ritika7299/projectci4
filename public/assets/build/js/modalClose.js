//modal will be close 
$(document).ready(function () {
    // Close any other modals before opening the new one
    $('.modal').on('show.bs.modal', function (e) {
        $('.modal').not(this).modal('hide');
    });
});