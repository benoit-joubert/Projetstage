/***********************************************************************************************************************
 *                                              Main Function                                                          *
 **********************************************************************************************************************/

(function () {

    "use strict";
    $(document).ready(function () {
        newCompletionForm();
        newSearchFields();
        newRegisteredList();
        newPrintButtons();
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
    return string;
}

Date.prototype.toDateInputValue = (function() {
    let local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});

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
            .append(new Option(this[Object.keys(this)] != null ? this[Object.keys(this)] : this, this[Object.keys(this)] != null ? convertToId(this[Object.keys(this)]) : this))
    });
    return true;
}

function returnYears() {
    let yearsDatalist = [];

    let date = new Date();
    let currentYear = String(date.getFullYear()).substring(2, 4);
    for (let i = currentYear; i > 0; --i) {
        yearsDatalist.push(String(i).padStart(2, '0'));
    }
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
            'maxlength' : maxLength,
            'value' : defaultValue,
            'onKeyUp' : 'addChar(event, this, ' + maxLength + ', [' + positionLetters + '], [' + positionNumbers + '])',
            'onKeyDown' : 'preventBackSpace(event)',
            'required' : ''
        })
        .bind('mouseup', function() {
            this.selectionStart = this.selectionEnd;
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
                .html('Ajout d\'un recommande')
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

function searchPerDate() {
    $.ajax({
        url: 'librairie/Connexion.php',
        type: 'POST',
        data: {
            function: 'getElements',
            params: {
                param1: "array('TYPE_ENVOI', 'DOSSIER', 'DEMANDEUR', 'CIVILITE_DEMANDEUR', 'ADRESSE', 'CODE_POSTAL', 'VILLE', 'INSTRUCT', 'DATE_CREATION')",
                param2: "array('T_COMPLETE')",
                param3: "array('TO_DATE(\\\'" + getFileDate('search') + "\\\', \\\'YYYY-MM-DD\\\') = DATE_CREATION')"
            }
        },
        success: function (data) {

            typeTab = 'recherche';
            clickedFile = undefined;
            registeredList = JSON.parse(data);
            nbElements = 0;
            fillRegisteredList();
        }
    });
}

function initializeDateInputScript(currentInputDate) {
    currentInputDate
        .click(function () {searchPerDate();})
        .change(function () {searchPerDate();})
}

function initializeAllSearchInputs() {

    initializeInputScript($('#search_file_fifth_char'), 1, 'J',[0],[0]);
    initializeInputScript($('#search_file_id'), 4, '****',[],[0, 1, 2, 3]);
    initializeInputScript($('#search_file_status'), 1, 'I',[0],[0]);
    initializeDateInputScript($('#search_file_date'));
}

/***********************************************************************************************************************
 *                                          Button Management Functions                                                *
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

function getFileRemark() {

    return $('#file_remarks').val();
}

function getFileDate(prefix) {

    if (prefix === 'search') prefix+= '_';
    return $('#' + prefix + 'file_date').val();
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
                .append($('<input/>').attr({'id' : 'search_file_status'}))
                .append($('<button/>').attr({'id' : 'search_file_button', 'type' : 'submit'}).html('Rechercher')),

        'Date' :
            $('<input/>').attr({'id' : 'search_file_date', 'type' : 'date', 'required' : ''}).val(new Date().toDateInputValue()),
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
    clickHandler();
}

/***********************************************************************************************************************
 *                                       Registered List - Management Functions                                        *
 **********************************************************************************************************************/

function fillRegisteredList() {

    let count = 0;
    clear();
    $('#registered_list table tbody tr:empty')
        .each(function () {
                if (registeredList[count] != null) {
                    $(this)
                        .append($('<td/>')
                            .html(registeredList[count]['TYPE_ENVOI'])
                        )
                        .append($('<td/>')
                            .html(registeredList[count]['DOSSIER'])
                        )
                        .append($('<td/>')
                            .html(registeredList[count]['DEMANDEUR'])
                        )
                        .append($('<td/>')
                            .html(registeredList[count]['ADRESSE'] + ' ' + registeredList[count]['CODE_POSTAL'] + ' ' + registeredList[count]['VILLE'])
                        );
                    ++count
                }
            }
        );

    if (registeredList.length > count){
        for (count; count < registeredList.length; ++count) {
            $('#registered_list table tbody')
                .append($('<tr/>')
                    .append($('<td/>')
                        .html(registeredList[count]['TYPE_ENVOI'])
                    )
                    .append($('<td/>')
                        .html(registeredList[count]['DOSSIER'])
                    )
                    .append($('<td/>')
                        .html(registeredList[count]['DEMANDEUR'])
                    )
                    .append($('<td/>')
                        .html(registeredList[count]['ADRESSE'] + ' ' + registeredList[count]['CODE_POSTAL'] + ' ' + registeredList[count]['VILLE'])
                    )
                );
        }
    }
    clickHandler();
}

function clear() {

    $('#registered_list table tbody')
        .html('')
        .append($('<tr/>'))
        .append($('<tr/>'))
        .append($('<tr/>'))
        .append($('<tr/>'))
        .append($('<tr/>'));
    clickHandler();
}

function clickHandler() {

    $('table tbody tr:not(:empty)').click(function () {
        $('tr').removeClass('clicked');
        if (clickedFile !== undefined) {
            if (clickedFile.index() !== $(this).index()) {
                $(this).addClass('clicked');
                clickedFile = $(this);
            }
            else {
                clickedFile = undefined;
            }
        }
        else {
            $(this).addClass('clicked');
            clickedFile = $(this);
        }
    });
}

/***********************************************************************************************************************
 *                                              Button Initialization                                                  *
 **********************************************************************************************************************/

function initializeButtonScript(currentButton, type) {

    if (!$(currentButton).is('button')) return false;

    if (type === '') {
        $(currentButton)
            .on('click', function () {
                if (getFileNumber(type) === false) return false;

                $.ajax({
                    url: 'librairie/Connexion.php',
                    type: 'POST',
                    data: {
                        function: 'getElements',
                        params: {
                            param1: "array('COUNT(*)')",
                            param2: "array('T_COMPLETE')",
                            param3: "array('\\\'" + getFileNumber(type) + "\\\' = DOSSIER')"
                        }
                    },
                    success: function (data) {

                        let resultTuples = JSON.parse(data);
                        if (resultTuples[0]['COUNT(*)'] > 0) return false;

                        let fileNumber = getFileNumber(type).substring(0, 2) + '13001' + getFileNumber(type).substring(2);

                        $.ajax({
                            url: 'librairie/Connexion.php',
                            type: 'POST',
                            data: {
                                function: 'getElements',
                                params: {
                                    param1: "array('NUMCOM', 'DEMANDEUR', 'DPM_NOM', 'DPM_PRENOM', 'DPM_REP_ME', " +
                                        "'DPM_REP_MR', 'DADR_NUMRUE', 'DADR_NOMRUE', 'DADR_CP', 'DADR_LOCALITE', " +
                                        "'INSTRUCT', 'DADR_LIEUDIT')",
                                    param2: "array('URBANISME.GPC_ENTDOS')",
                                    param3: "array('\\\'" + fileNumber + "\\\' = TYPDOS || NUMDEP || NUMCOM || NUMDOS || PCMODI AND ROWNUM <= 1')"
                                }
                            },
                            success: function (data) {

                                let resultTuples = JSON.parse(data);
                                if (resultTuples.length === 0) return false;

                                let jsonInsert = {
                                    NUMERO_ENVOI : null,
                                    DOSSIER : getFileNumber(type),
                                    COMMUNE : resultTuples[0]['NUMCOM'],
                                    DEMANDEUR : (
                                        (resultTuples[0]['DEMANDEUR'].replace('/ /g', '') !== '')
                                            ? resultTuples[0]['DEMANDEUR']
                                            : 'Demandeur inconnu'
                                    ),
                                    DEMANDEUR_COMP : (
                                        (resultTuples[0]['DPM_NOM'] !== '')
                                            ? (resultTuples[0]['DPM_NOM'] +
                                                ((resultTuples[0]['DPM_PRENOM'] !== '')
                                                        ? ' ' + resultTuples[0]['DPM_PRENOM']
                                                        : ''
                                                )
                                            )
                                            : (
                                                (resultTuples[0]['DPM_PRENOM'] !== '')
                                                    ? resultTuples[0]['DPM_PRENOM']
                                                    : null
                                            )
                                    ),
                                    CIVILITE_DEMANDEUR : (
                                        (resultTuples[0]['DPM_REP_MR'] === 1)
                                            ? ('Mr' + (
                                                    (resultTuples[0]['DPM_REP_ME'] === 1)
                                                        ? '-Mme'
                                                        : ''
                                                )
                                            )
                                            : (
                                                (resultTuples[0]['DPM_REP_ME'] === 1)
                                                    ? 'Mme'
                                                    : null
                                            )
                                    ),
                                    ADRESSE : (
                                        (resultTuples[0]['DADR_NOMRUE'] !== '')
                                            ? (
                                                (resultTuples[0]['DADR_NUMRUE'] !== '')
                                                    ? resultTuples[0]['DADR_NUMRUE'] + ' ' + resultTuples[0]['DADR_NOMRUE']
                                                    : resultTuples[0]['DADR_NOMRUE']
                                            )
                                            : 'Adresse inconnue'
                                    ),
                                    CODE_POSTAL : (
                                        (resultTuples[0]['DADR_CP'] !== '')
                                            ? resultTuples[0]['DADR_CP']
                                            : '13100'
                                    ),
                                    VILLE : (
                                        (resultTuples[0]['DADR_LOCALITE'].replace(/ /g, '') !== '')
                                            ? resultTuples[0]['DADR_LOCALITE']
                                            : 'Aix-en-Provence'
                                    ),
                                    TYPE_ENVOI : getFileRemark(),
                                    INSTRUCT : (
                                        (resultTuples[0]['INSTRUCT'] !== '')
                                            ? resultTuples[0]['INSTRUCT']
                                            : null
                                    ),
                                    LIEU_DIT : (
                                        (resultTuples[0]['DADR_LIEUDIT'] !== '')
                                            ? resultTuples[0]['DADR_LIEUDIT']
                                            : null
                                    ),
                                    DATE_CREATION : getFileDate('')
                                };

                                $.ajax({
                                    url: 'librairie/Connexion.php',
                                    type: 'POST',
                                    data: {
                                        function: 'addElement',
                                        params: {
                                            param1: "array('T_COMPLETE')",
                                            param2: "array('NUMERO_ENVOI', 'DOSSIER', 'COMMUNE', 'DEMANDEUR', " +
                                                "'DEMANDEUR_COMP', 'CIVILITE_DEMANDEUR', 'ADRESSE', 'CODE_POSTAL', " +
                                                "'VILLE', 'TYPE_ENVOI', 'INSTRUCT', 'LIEU_DIT', 'DATE_CREATION')",
                                            param3: "array('" + jsonInsert.NUMERO_ENVOI + "', " +
                                                "'\\\'" + jsonInsert.DOSSIER + "\\\'', " +
                                                "'\\\'" + jsonInsert.COMMUNE + "\\\'', " +
                                                "'\\\'" + jsonInsert.DEMANDEUR + "\\\'', " +
                                                ((jsonInsert.DEMANDEUR_COMP != null) ? "'\\\'" + jsonInsert.DEMANDEUR_COMP + "\\\'', " : "'null', ") +
                                                ((jsonInsert.CIVILITE_DEMANDEUR != null) ? "'\\\'" + jsonInsert.CIVILITE_DEMANDEUR + "\\\'', " : "'null', ") +
                                                "'\\\'" + jsonInsert.ADRESSE + "\\\'', " +
                                                "'" + jsonInsert.CODE_POSTAL + "', " +
                                                "'\\\'" + jsonInsert.VILLE + "\\\'', " +
                                                "'\\\'" + jsonInsert.TYPE_ENVOI + "\\\'', " +
                                                ((jsonInsert.INSTRUCT != null) ? "'\\\'" + jsonInsert.INSTRUCT + "\\\'', " : "'null', ") +
                                                ((jsonInsert.LIEU_DIT != null) ? "'\\\'" + jsonInsert.LIEU_DIT + "\\\'', " : "'null', ") +
                                                "'TO_DATE(\\\'" + jsonInsert.DATE_CREATION + "\\\', \\\'YYYY-MM-DD\\\')')"
                                        },
                                        success: function () {
                                            if (typeTab === 'recherche') {
                                                registeredList = [];
                                                typeTab = 'ajout';
                                            }
                                            registeredList[nbElements] = {
                                                TYPE_ENVOI : jsonInsert.TYPE_ENVOI,
                                                DOSSIER : jsonInsert.DOSSIER,
                                                DEMANDEUR : jsonInsert.DEMANDEUR,
                                                CIVILITE_DEMANDEUR : jsonInsert.CIVILITE_DEMANDEUR,
                                                ADRESSE : jsonInsert.ADRESSE,
                                                CODE_POSTAL : jsonInsert.CODE_POSTAL,
                                                VILLE : jsonInsert.VILLE,
                                                INSTRUCT : jsonInsert.INSTRUCT,
                                                DATE_CREATION : jsonInsert.DATE_CREATION
                                            };
                                            ++nbElements;
                                            fillRegisteredList();
                                        }
                                    }
                                })
                            }
                        })
                    }
                });
            })
    }
    else if (type === 'search') {
        $(currentButton)
            .on('click', function () {
                if (getFileNumber(type) === false) return false;

                $.ajax({
                    url: 'librairie/Connexion.php',
                    type: 'POST',
                    data: {
                        function: 'getElements',
                        params: {
                            param1: "array('TYPE_ENVOI', 'DOSSIER', 'DEMANDEUR', 'CIVILITE_DEMANDEUR', 'ADRESSE', 'CODE_POSTAL', 'VILLE', 'INSTRUCT', 'DATE_CREATION')",
                            param2: "array('T_COMPLETE')",
                            param3: "array('\\\'" + getFileNumber(type) + "\\\' = DOSSIER')"
                        }
                    },
                    success: function (data) {
                        typeTab = 'recherche';
                        registeredList = JSON.parse(data);
                        clickedFile = undefined;
                        nbElements = 0;
                        fillRegisteredList();
                    }
                })
            });
    }
}

function initializeAllButtons() {

    initializeButtonScript($('#file_button'), '');
    initializeButtonScript($('#search_file_button'), 'search');
}

/***********************************************************************************************************************
 *                                         Registered List - Initialization                                            *
 **********************************************************************************************************************/

function createRegisteredList() {

    let myList =
        $('<fieldset/>')
            .append($('<legend/>')
                .html('Liste des recommandes')
            )
            .append($('<table/>')
                .attr({
                    'id' : 'registered_list_tab'
                })
                .append($('<thead/>')
                    .append($('<tr/>')
                        .attr({
                            'id' : 'labels'
                        })
                        .append($('<th/>').html('Type'))
                        .append($('<th/>').html('Description'))
                        .append($('<th/>').html('Demandeur'))
                        .append($('<th/>').html('Adresse'))
                    )
                )
                .append($('<tbody/>')
                    .append($('<tr/>'))
                    .append($('<tr/>'))
                    .append($('<tr/>'))
                    .append($('<tr/>'))
                    .append($('<tr/>'))
                )
            );

    $('#registered_list')
        .append(myList);
}

/***********************************************************************************************************************
 *                                          Print Button - Main Function                                            *
 **********************************************************************************************************************/

function newPrintButtons() {

    createPrintButtons();
    initializePrintButtons();
}

/***********************************************************************************************************************
 *                                           Print Button Management Functions                                         *
 **********************************************************************************************************************/

function initializePrintButtons() {

    $('#registered_list_print').click(function () {
        $.ajax({
            url: 'librairie/PDF.php',
            type: 'POST',
            data: {
                function: 'body',
                params: {
                    param1: "'" + JSON.stringify(registeredList).replace(/'/g, '\\\'')+ "'",
                }
            },
            success: function (data) {
                let win = window.open('', '_blank');
                win.location.href = data;
            }
        });
    });

    $('#registered_print').click(function () {

        let registeredListTemp = [];
        if (clickedFile == null && registeredList.length !== 0) {
            registeredListTemp.push(registeredList);
        }
        else {
            registeredListTemp.push(registeredList[clickedFile.index()]);
        }
        $.ajax({
            url: 'librairie/PDF.php',
            type: 'POST',
            data: {
                function: 'bodyRegistered',
                params: {
                    param1: "'" + JSON.stringify(registeredListTemp).replace(/'/g, '\\\'')+ "'",
                }
            },
            success: function(data) {
                $.ajax({
                    url: 'librairie/Connexion.php',
                    type: 'POST',
                    data: {
                        function: 'updateElement',
                        params: {
                            param1: "'T_COMPLETE'",
                            param2: "'NUMERO_ENVOI'",
                            param3: "'(SELECT MAX(NUMERO_ENVOI) + 1 FROM T_COMPLETE)'",
                            param4: "'" + JSON.stringify(registeredListTemp).replace(/'/g, '\\\'')+ "'",
                        },
                    }
                });
                let win = window.open('', '_blank');
                win.location.href = data;
            }
        });
    });
}

/***********************************************************************************************************************
 *                                           Print Button Initialization                                               *
 **********************************************************************************************************************/

function createPrintButtons() {

    let myButtons =
        $('<div/>')
            .append($('<span/>')
                .html('Recommandé\t')
            )
            .append($('<button/>')
                .attr({
                    'id' : 'registered_print'
                })
                .html('<i class="fas fa-print"></i>')
            )
            .append($('<span/>')
                .html('Liste des recommandés\t')
            )
            .append($('<button/>')
                .attr({
                    'id' : 'registered_list_print'
                })
                .html('<i class="fas fa-print"></i>')
            );

    $('#print_buttons')
        .append(myButtons);
}
