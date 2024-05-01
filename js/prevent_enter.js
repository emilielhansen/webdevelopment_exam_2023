// jQuery code to prevent form submission on Enter key
$(document).ready(function () {
    $('#frm_search').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission
    });
});