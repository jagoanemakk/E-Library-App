$(document).ready(function () {
    var spinner =
        '<div style="height:20px; width: 20px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only"></span></div>  Please Wait';
    $("editModal").on("submit", function (e) {
        e.preventDefault();
        $("#submitBtn").html(spinner);
        $("#submitBtn").attr("disabled", "disabled");
    });
});
