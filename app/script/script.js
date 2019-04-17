/***********************************************************************************************************************
 *                                              Main Function                                                          *
 **********************************************************************************************************************/

(function () {

    "use strict";
    $(document).ready(function () {
        newNavbar();
        newCompletionForm();
        newSearchFields();
        newRegisteredList();
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

Date.prototype.toDateInputValue = (function() {
    let local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});

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
                    'value' : (this[Object.keys(this)] != null ? convertToId(this[Object.keys(this)]) : this)
                })
                .html((this[Object.keys(this)] != null ? this[Object.keys(this)] : this))
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

    fillSelectScript($('#file_type'), fileTypeList);
    fillSelectScript($('#file_year'), returnYears());
    fillSelectScript($('#file_remarks'), remarkList);
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
            $('<input/>').attr({'id' : 'file_date', 'type' : 'date', 'required' : ''}).val(new Date().toDateInputValue()),
        '' :
            $('<button/>').attr({'id' : 'file_button', 'type' : 'submit'}).html('Ajouter')
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
}

/***********************************************************************************************************************
 *                                            Search Fields - Main Function                                            *
 **********************************************************************************************************************/

function newSearchFields() {

    createSearchFields();
    fillAllSearchSelects();
    initializeAllSearchInputs();
    initializeAllButtons();
}

/***********************************************************************************************************************
 *                                    Search Fields - Select Management Functions                                      *
 **********************************************************************************************************************/

function fillAllSearchSelects() {

    fillSelectScript($('#search_file_type'), fileTypeList);
    fillSelectScript($('#search_file_year'), returnYears());
    fillSelectScript($('#search_file_remarks'), remarkList);
}

/***********************************************************************************************************************
 *                                      Search Fields - Input Management Functions                                     *
 **********************************************************************************************************************/

function initializeAllSearchInputs() {

    initializeInputScript($('#search_file_fifth_char'), 1, 'J',[0],[0]);
    initializeInputScript($('#search_file_id'), 4, '****',[],[0, 1, 2, 3]);
    initializeInputScript($('#search_file_status'), 1, 'I',[0],[0]);
}

/***********************************************************************************************************************
 *                                      Search Fields - Button Management Functions                                    *
 **********************************************************************************************************************/

function getFileNumber(prefix) {

    if (prefix === 'search') prefix+= '_';
    let fileNumber =
        $('#' + prefix + 'file_type').val() +
        $('#' + prefix + 'file_year').val() +
        $('#' + prefix + 'file_fifth_char').val() +
        $('#' + prefix + 'file_id').val() +
        $('#' + prefix + 'file_status').val();
    fileNumber = fileNumber.toUpperCase();

    if (!fileNumber.match(/[A-Z]{2}[0-9]{2}[A-Z0-9][0-9]{4}[A-Z0-9]/)) return false;
    return fileNumber;
}

function getFileDate(prefix) {

    if (prefix === 'search') prefix+= '_';
    return $('#' + prefix + 'file_date').val();
}

function initializeButtonScript(currentButton, type) {

    let fileNumber;
    let fileDate;

    if (!$(currentButton).is('button')) return false;

    $(currentButton)
        .on('click', function () {
            fileNumber = getFileNumber(type);
            fileDate = getFileDate(type);
        })
}

function initializeAllButtons() {

    initializeButtonScript($('#file_button'), '');
    initializeButtonScript($('#search_file_button'), 'search');
}

/***********************************************************************************************************************
 *                                           Search fields - Initialization                                            *
 **********************************************************************************************************************/

function createSearchFields() {

    let myFields = {
        'Numero de dossier' :
            $('<div/>').attr({'id' : 'search_file_number'})
                .append($('<select/>').attr({'id' : 'search_file_type'}))
                .append($('<select/>').attr({'id' : 'search_file_year'}))
                .append($('<input/>').attr({'id' : 'search_file_fifth_char'}))
                .append($('<input/>').attr({'id' : 'search_file_id'}))
                .append($('<input/>').attr({'id' : 'search_file_status'})),

        'Date' :
            $('<input/>').attr({'id' : 'search_file_date', 'type' : 'date', 'required' : ''}).val(new Date().toDateInputValue()),
        '' :
            $('<button/>').attr({'id' : 'search_file_button', 'type' : 'submit'}).html('Rechercher')
    };

    let myForm =
        $('<fieldset/>')
            .append($('<legend/>')
                .html('Recherche')
            )
            .append($('<table/>')
                .append($('<tr/>')
                    .attr({
                        'id' : 'search_labels'
                    })
                )
                .append($('<tr/>')
                    .attr({
                        'id' : 'search_contents'
                    })
                )
            );

    for (let fieldName in myFields) {
        myForm.find('#search_labels')
            .append($('<th/>')
                .html(fieldName)
            );
        myForm.find('#search_contents')
            .append($('<td/>')
                .append(myFields[fieldName])
            );
    }

    $('#search_fields')
        .append(myForm);
}

/***********************************************************************************************************************
 *                                          Registered List - Main Function                                            *
 **********************************************************************************************************************/

function newRegisteredList() {

    createRegisteredList();
    fillRegisteredList();
}

/***********************************************************************************************************************
 *                                       Registered List - Management Functions                                        *
 **********************************************************************************************************************/

function fillRegisteredList() {

    for (let registered in registeredList) {
        $('#registered_list table')
            .append($('<tr/>')
                .append($('<td/>')
                    .html(registeredList[registered]['TYPE_ENVOI'])
                )
                .append($('<td/>')
                    .html(registeredList[registered]['DOSSIER'])
                )
                .append($('<td/>')
                    .html(registeredList[registered]['DEMANDEUR'])
                )
                .append($('<td/>')
                    .html(registeredList[registered]['ADRESSE_1']
                        + (registeredList[registered]['ADRESSE_2'] !== undefined ? '<br/>' + registeredList[registered]['ADRESSE_2'] : '')
                        + (registeredList[registered]['ADRESSE_3'] !== undefined ? '<br/>' + registeredList[registered]['ADRESSE_3'] : '')
                    )
                )
            );
    }
}

/***********************************************************************************************************************
 *                                         Registered List - Initialization                                            *
 **********************************************************************************************************************/

function createRegisteredList() {

    let myList =
        $('<fieldset/>')
            .append($('<legend/>')
                .html('Liste des recommandés')
            )
            .append($('<table/>')
                .attr({
                    'id' : 'registered_list_tab'
                })
                .append($('<tr/>')
                    .attr({
                        'id' : 'labels'
                    })
                    .append($('<th/>').html('Type'))
                    .append($('<th/>').html('Description'))
                    .append($('<th/>').html('Demandeur'))
                    .append($('<th/>').html('Adresse'))
                )
            );

    $('#registered_list')
        .append(myList);
}
