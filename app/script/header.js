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
 * Makes the navbar sticky
 */
function sticky_navbar () {
    let stickyNavTop = $('.navbar').offset().top;
    let stickyNav = function(){
        let scrollTop = $(window).scrollTop();
        if (scrollTop > stickyNavTop) {
            $('.navbar').addClass('sticky');
        } else {
            $('.navbar').removeClass('sticky');
        }
    };
    stickyNav();
    $(window).scroll(function() {
        stickyNav();
    });
}

/**
 * Allows to create a navbar for each page.
 */
function createNavbar() {
    let myNavbar =
        $('<header/>')
            .append($('<nav/>')
                .addClass('navbar')
                .append($('<ul/>')));
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
    $('body').prepend(myNavbar);
    active_navbar();
    sticky_navbar();
}