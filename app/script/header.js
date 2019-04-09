/**
 * Main function.
 */
(function () {
    "use strict";
    $(document).ready(function () {
        createNavbar();
    });
}) ();

/**
 * Handle which page is active.
 */
function active_navbar () {
    let loc = window.location.pathname.split('/').pop();
    $('.navbar').find('a').each(function() {
        $(this).toggleClass('active', $(this).attr('href') === loc);
    });
}

/**
 * Allows to create a navbar for each page.
 */
function createNavbar() {
    let myNavbar = $('<nav/>')
        .addClass('navbar')
        .append($('<ul/>'));
    let myParams = {
        'Recommandes'   : 'index.php',
        'Recherche'     : 'recherche.php'
    };

    for (let paramName in myParams) {
        myNavbar.find('ul')
            .append($('<li/>')
            .append($('<a/>')
                .attr({
                    'href' : myParams[paramName]
                })
                .html(paramName)));
    }
    $('body').append(myNavbar);
    active_navbar();
}