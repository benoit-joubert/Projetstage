/**
 * Main function.
 */
(function () {
    "use strict";
    $(document).ready(function () {
        createCompletionForm();
    });
}) ();

function fillFileNumberInputScript(e, valueOld, currentInput) {
    let positionLetters = [0, 1, 4, 9];
    let positionNumbers = [2, 3, 4, 5, 6, 7, 8, 9];
    let currentValue = currentInput.value;
    currentValue = currentValue.replace(/\*/g, '');

    if (e.keyCode === 8) {
        currentValue = currentValue.substring(0, currentValue.length-1);
        currentValue += '*'.repeat(10 - currentValue.length);
        currentInput.value = currentValue;
        return true;
    }

    if (!/[a-zA-Z0-9]/.test(e.key) || e.key.length > 1) return false;

    if (currentValue.length < 10) {
        if ((e.key.match(/[0-9]/) && positionNumbers.includes(currentValue.length))
            || (e.key.match(/[a-zA-Z]/) && positionLetters.includes(currentValue.length)))
            currentValue += e.key.toUpperCase();
        else
            return false;
        currentValue += '*'.repeat(10 - currentValue.length);
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
            if (evt.preventDefault) {
                evt.preventDefault();
            } else {
                evt.returnValue = false;
            }
        }
    }
}

function createCompletionForm() {
    let myFields = {
        'Numero de dossier' : $('<input/>').attr({
                                    'type': 'text',
                                    'maxlength' : 10    ,
                                    'value' : '**********',
                                    'onKeyUp' : 'return fillFileNumberInputScript(event, this.value, this)',
                                    'onKeyDown' : 'preventBackSpace(event);',
                                    'required' : ''
                                }),
        'Type'              : $('<select/>')
                                        .append($('<option/>').attr({'value' : 'arrete'}).html('Arrêté'))
                                        .append($('<option/>').attr({'value' : 'courrier'}).html('Courrier'))
                                        .append($('<option/>').attr({'value' : 'irrecevable'}).html('Irrecevable'))
                                        .append($('<option/>').attr({'value' : 'notification'}).html('Notification des délais'))
                                        .append($('<option/>').attr({'value' : 'pieces'}).html('Pièces Complémentaires'))
                                        .append($('<option/>').attr({'value' : 'prolongation'}).html('Prolongation de délai'))
                                        .append($('<option/>').attr({'value' : 'prorogation'}).html('Prorogation'))
                                        .append($('<option/>').attr({'value' : 'rectificatif'}).html('Rectificatif'))
                                        .append($('<option/>').attr({'value' : 'rejet'}).html('Rejet'))
                                        .append($('<option/>').attr({'value' : 'report'}).html('Report de délai'))
                                        .append($('<option/>').attr({'value' : 'retrait'}).html('Retrait'))
                                        .append($('<option/>').attr({'value' : 'suspension'}).html('Suspension des délais')
                                    ),
        'Expediteur'        : $('<input/>').attr({'type': 'text'}),
        'Imprimer'          : $('<select/>')
                                    .append($('<option/>').attr({'value' : 'oui'}).html('Oui'))
                                    .append($('<option/>').attr({'value' : 'non'}).html('Non')
                                ),
        'Date'              : $('<input/>').attr({'type': 'date'}),
    };

    let myForm =
        $('<fieldset/>')
            .append($('<legend/>')
                .html('Ajout d\'un recommandé')
            )
            .append($('<div/>')
                .addClass('table_container')
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
                )
            );

    for (let fieldName in myFields) {
        myForm.find('#labels')
            .append($('<td/>')
                .html(fieldName)
            );
        myForm.find('#contents')
            .append($('<td/>')
                .append(myFields[fieldName])
            );
    }

    $('#completion_form').append(myForm);
}

