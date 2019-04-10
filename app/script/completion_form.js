/**
 * Main function.
 */
(function () {
    "use strict";
    $(document).ready(function () {
        createCompletionForm();
    });
}) ();

function fillFileNumberInputScript(e) {
    let input = String.fromCharCode(e.keyCode);
    if (!/[a-zA-Z0-9]/.test(input)) return false;
}

function createCompletionForm() {
    let myFields = {
        'Numero de dossier' : $('<input/>').attr({
                                    'id' : 'file_number_input',
                                    'type': 'text',
                                    'maxlength' : 10,
                                    'placeholder' : '**********',
                                    'onkeypress' : 'return fillFileNumberInputScript(event)',
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
                                    .append($('<option/>').attr({'value' : 'suspension'}).html('Suspension des délais')),
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

