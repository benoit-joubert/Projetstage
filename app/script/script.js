/***********************************************************************************************************************
 *                                              Main Function                                                          *
 **********************************************************************************************************************/

(function () {

    "use strict";
    $(document).ready(function () {
        newNavbar();
        newCompletionForm();
    });
}) ();

/***********************************************************************************************************************
 *                                             Common Functions                                                        *
 **********************************************************************************************************************/

function isJSON(obj) {

    let objectType = typeof obj;
    return ['boolean', 'number', 'string', 'symbol', 'function'].indexOf(objectType) === -1;
}

function convertToId(string) {

    string = string.replace(/ /g, '_');
    string = string.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    string = string.toLowerCase();
    return string;
}

/***********************************************************************************************************************
 *                                          Navbar - Main Function                                                     *
 **********************************************************************************************************************/

function newNavbar() {

    createNavbar();
    active_navbar();
    sticky_navbar();
}

/***********************************************************************************************************************
 *                                     Navbar - Navbar Management Functions                                            *
 **********************************************************************************************************************/

function active_navbar () {

    let loc = window.location.pathname.split('/').pop();
    $('.navbar').find('a').each(function() {
        $(this).toggleClass('active', $(this).attr('href') === loc);
    });
}

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

/***********************************************************************************************************************
 *                                            Navbar - Initialization                                                  *
 **********************************************************************************************************************/

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
}

/***********************************************************************************************************************
 *                                          Completion Form - Main Function                                            *
 **********************************************************************************************************************/

function newCompletionForm() {

    createCompletionForm();
    fillAllSelects();
    initializeAllInputs();
}

/***********************************************************************************************************************
 *                                  Completion Form - Select Management Functions                                      *
 **********************************************************************************************************************/

function fillSelectScript(currentSelect, datalist) {

    if (!$(currentSelect).is('select') ||
        !isJSON(datalist))
        return false;

    jQuery.each(datalist, function () {
        $(currentSelect)
            .append($('<option/>')
                .attr({
                    'value' : convertToId(this)
                })
                .html(this)
            )
    });

    return true;
}

function returnYears() {

    let yearsDatalist = [];
    let currentYear = String(new Date().getFullYear()).substring(2, 4);

    for (let i = currentYear; i > 0; --i)
        yearsDatalist.push(String(i).padStart(2, '0'));

    return yearsDatalist;
}

function fillAllSelects() {

    fillSelectScript($('#file_type'), ['PC', 'DT', 'CU', 'PD', 'CC', 'DI', 'LT']);
    fillSelectScript($('#file_year'), returnYears());
    fillSelectScript($('#file_remarks'), ['Arrêté', 'Courrier', 'Irrecevable', 'Notification des délais',
        'Pièces complémentaires', 'Prolongation de délai', 'Prorogation', 'Rectificatif', 'Rejet', 'Report de délai',
        'Retrait', 'Suspension des délais'])
}

/***********************************************************************************************************************
 *                                   Completion Form - Input Management Functions                                      *
 **********************************************************************************************************************/

function initializeInputScript(currentInput, maxLength, defaultValue, positionLetters, positionNumbers) {

    if (!$(currentInput).is('input') ||
        !Number.isInteger(maxLength) ||
        !isJSON(positionLetters) ||
        !isJSON(positionNumbers))
        return false;

    $(currentInput)
        .attr({
            'type' : 'text',
            'maxlength' : maxLength,
            'value' : defaultValue,
            'onKeyUp' : 'addChar(event, this, ' + maxLength + ', [' + positionLetters + '], [' + positionNumbers + '])',
            'onKeyDown' : 'preventBackSpace()',
            'required' : ''
        });
}

function addChar(e, currentInput, maxLength, positionLetters, positionNumbers) {

    let currentValue = currentInput.value;
    currentValue = currentValue.replace(/\*/g, '');

    if (e.keyCode === 8) {
        currentValue = currentValue.substring(0, currentValue.length-1);
        currentValue += '*'.repeat(maxLength - currentValue.length);
        currentInput.value = currentValue;
        return true;
    }

    if (!/[a-zA-Z0-9]/.test(e.key) || e.key.length > 1) return false;

    if (currentValue.length < maxLength) {
        if ((e.key.match(/[0-9]/) && positionNumbers.includes(currentValue.length)) ||
            (e.key.match(/[a-zA-Z]/) && positionLetters.includes(currentValue.length)))
            currentValue += e.key.toUpperCase();
        else
            return false;
        currentValue += '*'.repeat(maxLength - currentValue.length);
        currentInput.value = currentValue;
        return true;
    }
    return false;
}

function preventBackSpace(e) {

    let evt = e || window.event;
    if (evt) {
        let keyCode = evt.charCode || evt.keyCode;
        if (keyCode === 8) {
            if (evt.preventDefault) evt.preventDefault();
            else evt.returnValue = false;
        }
    }
}

function initializeAllInputs() {

    initializeInputScript($('#file_fifth_char'), 1, 'J',[0],[0]);
    initializeInputScript($('#file_id'), 4, '****',[],[0, 1, 2, 3]);
    initializeInputScript($('#file_status'), 1, 'I',[0],[0]);
}

/***********************************************************************************************************************
 *                                         Completion Form - Initialization                                            *
 **********************************************************************************************************************/

function createCompletionForm() {
    let myFields = {
        'Numero de dossier' :
            $('<div/>').attr({'id' : 'file_number'})
                .append($('<select/>').attr({'id' : 'file_type'}))
                .append($('<select/>').attr({'id' : 'file_year'}))
                .append($('<input/>').attr({'id' : 'file_fifth_char'}))
                .append($('<input/>').attr({'id' : 'file_id'}))
                .append($('<input/>').attr({'id' : 'file_status'})),

        'Type' :
            $('<select/>').attr({'id' : 'file_remarks'}),

        'Date' :
            $('<input/>').attr({'id' : 'file_date', 'type': 'date'}),
        '' :
            $('<button/>').attr({'type' : 'submit'}).html('Ajouter')
    };

    let myForm =
        $('<fieldset/>')
            .append($('<legend/>')
                .html('Ajout d\'un recommandé')
            )
            .append($('<table/>')
                .append($('<tr/>')
                        .attr({
                            'id' : 'labels'
                        })
                )
                .append($('<tr/>')
                        .attr({
                            'id' : 'contents'
                        })
                )
            );

    let myList =
        $('<fieldset/>')
            .append($('<legend/>')
                .html('Liste des recommandés')
            )
            .append($('<table/>')
                .append($('<tr/>')
                    .attr({
                        'id' : 'labels'
                    })
                    .append($('<td/>').html('Type'))
                    .append($('<td/>').html('Description'))
                    .append($('<td/>').html('Demandeur'))
                    .append($('<td/>').html('Adresse'))
                )
            );

    for (let fieldName in myFields) {
        myForm.find('#labels')
            .append($('<th/>')
                .html(fieldName)
            );
        myForm.find('#contents')
            .append($('<td/>')
                .append(myFields[fieldName])
            );
    }

    $('#registered_form')
        .append(myForm);
    $('#registered_list')
        .append(myList);
}
