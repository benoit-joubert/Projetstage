$(document).ready(function () {
    let liste = [
        "test",
        "ok",
        "lalelilolu",
        "attends",
        "marche"
    ];



    $('#nom').autocomplete({
        source: liste,
    });
});