function ValiderFormulaireDemandeur(){
	var F = document.F1;
    var msg = '';
    var ok = 1;
    if(ok == 1 && !checkString(F.nom.value)){
        ok = 0;
        msg = 'Veuillez saisir le nom du demandeur...';
    }
    /*
    if(ok == 1 && !checkString(F.prenom.value)){
        ok = 0;
        msg = 'Veuillez saisir le pr&eacute;nom du demandeur...';
    }
    */
    if(ok == 1 && !checkString(F.adresse.value)){
        ok = 0;
        msg = 'Veuillez saisir l\'adresse du demandeur...';
    }
    if(ok == 1 && !checkString(F.cp.value)){
        ok = 0;
        msg = 'Veuillez saisir le code postal du demandeur...';
    }
    if(ok == 1 && !checkString(F.ville.value)){
        ok = 0;
        msg = 'Veuillez saisir la ville du demandeur...';
    }
    if(ok == 1){
        F.submit();
    }else{
		$("#dialog-erreur").html("<img src='./images/stop_48.png' border='0' /><br/>" + msg);
	    // Define the Dialog and its properties.
	    $("#dialog-erreur").dialog({
	        resizable: false,
	        modal: true,
	        title: "Erreur de saisie",
	        height: 250,
	        width: 400,
	        buttons: {
	            "OK": function () {
	                $(this).dialog('close');
	            }
	        }
	    });
        return false;
    }
}

function SupprimerDemandeur(demandeur){
    var msg = 'Etes-vous s&ucirc;r(e) de vouloir supprimer le demandeur <b>#' + demandeur + '</b><br/>Et toutes les demandes associ&eacute;es ?'
    $("#dialog-confirm").html("<img src='./images/imagesQuestion2_48.png' border='0'/><br/>" + msg);
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation Suppression",
        height: 250,
        width: 400,
        buttons: {
            "OK": function () {
                $(this).dialog('close');
                window.location="./index.php?P=203&demandeur="+demandeur+"&action=DeleteDemandeur";
            },
            "Annuler": function () {
                $(this).dialog('close');
            }
        }
    });
    return false;
}
function SupprimerDemande(demandeur,demande,from){
    var msg = 'Etes-vous s&ucirc;r(e) de vouloir supprimer la demande <b>#' + demande + '</b><br/>Et tous les documents associ&eacute;es ?'
    $("#dialog-confirm").html("<img src='./images/imagesQuestion1_48.png' border='0'/><br/>" + msg);
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation Suppression",
        height: 250,
        width: 400,
        buttons: {
            "OK": function () {
                $(this).dialog('close');
                window.location="./index.php?P=305&demandeur="+demandeur+"&demande="+demande+"&from="+from+"&action=DeleteDemande";
            },
            "Annuler": function () {
                $(this).dialog('close');
            }
        }
    });
    return false;
}
function ValiderFormulaireDemande(){
    var F = document.F1;
    var msg = '';
    var statut_demande = F.statut_demande.options[F.statut_demande.selectedIndex].value;
    var ok = 1;
    if(ok == 1 && F.id_demandeur.options && F.id_demandeur.selectedIndex==0){
        ok = 0;
        msg = 'Veuillez sel&eacute;ctionner le demandeur...';
    }
    if(ok == 1 && !checkString(F.contact.value)){
        ok = 0;
        msg = 'Veuillez saisir le contact...';
    }
    
    if(ok == 1 && !checkString(F.date_demande.value)){
        ok = 0;
        msg = 'Veuillez saisir la date de la demande...';
    }
    if(ok == 1 && !VerifDate(F.date_demande.value)){
        ok = 0;
        msg = 'La date de la demande est incorrecte.<br>Veuillez saisir une date ao format DD/MM/YYYY...';
    }
    if(ok == 1 && statut_demande==5 && !checkString(F.date_reponse.value)){
        ok = 0;
        msg = 'Veuillez saisir la date de r&eacute;ponse si cette demande est trait&eacute;e...';
    }
    if(ok == 1 && checkString(F.date_reponse.value)){
        if(!VerifDate(F.date_reponse.value)){
            ok = 0;
            msg = 'La date de la r&eacute;ponse est incorrecte.<br>Veuillez saisir une date ao format DD/MM/YYYY...';
        }
    }
    if(ok == 1 && statut_demande==5){ //Traité
        if(ok == 1 && F.statut_aep.selectedIndex == 0){
            ok = 0;
            msg = 'Veuiilez indiquer la raccordabilité de la demande au réseau AEP...';
        }
        if(ok == 1 && F.statut_eu.selectedIndex == 0){
            ok = 0;
            msg = 'Veuiilez indiquer la raccordabilité de la demande au réseau EU...';
        }
        if(ok == 1 && F.id_interlocuteur.selectedIndex == 0){
            ok = 0;
            msg = 'Veuiilez indiquer l\'interlocuteur de la demande...';
        }
        if(ok == 1 && F.id_attestant.selectedIndex == 0){
            ok = 0;
            msg = 'Veuiilez indiquer la personne attestant le courrier...';
        }
        if(ok == 1 && F.id_signataire.selectedIndex == 0){
            ok = 0;
            msg = 'Veuiilez indiquer le signataire du courrier...';
        }
    }

    if(ok == 1){
        F.submit();
    }else{
        $("#dialog-erreur").html("<img src='./images/stop_48.png' border='0' /><br/>" + msg);
        // Define the Dialog and its properties.
        $("#dialog-erreur").dialog({
            resizable: false,
            modal: true,
            title: "Erreur de saisie",
            height: 250,
            width: 400,
            buttons: {
                "OK": function () {
                    $(this).dialog('close');
                }
            }
        });
        return false;
    }
}

function ValiderFormulaireAgent(TypeAgent){
    var F = document.F1;
    var msg = '';
    var ok = 1;
    if(ok == 1 && !checkString(F.agent.value)){
        ok = 0;
        if(TypeAgent=='INTERLOCUTEUR'){
            var t_a = "l'interlocuteur";
        }else if(TypeAgent=='ATTESTANT'){
            var t_a = "l'attesatnt";
        }else{
            var t_a = "le signataire";
        }
        msg = 'Veuillez saisir ' + t_a + '...';
    }
    if(ok == 1 && F.actif.selectedIndex==0){
        ok = 0;
        msg = 'Veuillez s&eacute;lectionner l\'&eacute;tat...';
    }
    if(ok == 1){
        F.submit();
    }else{
        $("#dialog-erreur").html("<img src='./images/stop_48.png' border='0' /><br/>" + msg);
        // Define the Dialog and its properties.
        $("#dialog-erreur").dialog({
            resizable: false,
            modal: true,
            title: "Erreur de saisie",
            height: 250,
            width: 400,
            buttons: {
                "OK": function () {
                    $(this).dialog('close');
                }
            }
        });
        return false;
    }
}

function ValiderFormulaireParam(TypeParam){
    var F = document.F1;
    var msg = '';
    var ok = 1;
    if(TypeParam == 'COURRIER_ENTETE'){
        if(ok == 1 && !checkString(F.LIGNE1.value)){
            ok = 0;
            msg = 'Veuillez saisir la ligne 1...';
        }
    }
    if(ok == 1 && TypeParam=='COURRIER_ENTETE'){
        F.submit();
    }else{
        $("#dialog-erreur").html("<img src='./images/stop_48.png' border='0' /><br/>" + msg);
        // Define the Dialog and its properties.
        $("#dialog-erreur").dialog({
            resizable: false,
            modal: true,
            title: "Erreur de saisie",
            height: 250,
            width: 400,
            buttons: {
                "OK": function () {
                    $(this).dialog('close');
                }
            }
        });
        return false;
    }
}
var dlg;

function AddParcelle(){
    //$("#dialog-addParcelle").html("<img src='./images/stop_48.png' border='0' /><br/>" + msg);
    // Define the Dialog and its properties.
    $("#dialog-add").dialog({
        resizable: false,
        modal: true,
        title: "Ajouter une Parcelle",
        height: 260,
        width: 400,
        buttons: {
            "Enregistrer": function () {
                window.document.getElementById('msgAddVoie').innerHTML = "";
                window.document.getElementById('msgAddDoc').innerHTML = "";
                window.document.getElementById('msgAddParcelle').innerHTML = "";tooltip.init();

                if(document.getElementById('SelectNsec').selectedIndex)
                    var SelectNsec = document.getElementById('SelectNsec');
                else
                    var SelectNsec = document.getElementById('SelectNsec').value;
                var SelectParcelle = document.getElementById('SelectParcelle');
                var code_com  = document.getElementById('code_com');
                var format_parc_nb_lettre = document.getElementById('format_parc_nb_lettre').value * 1;
                var format_parc_nb_chiffre = document.getElementById('format_parc_nb_chiffre').value * 1;
                //var reg = /[A-Z]{2}\d{4}/;
                //var regNsec = /[A-Z]{2}/;
                //var reg = /\d{4}/;
                if(format_parc_nb_lettre == 2){
                    var regNsec = /[A-Z]{2}/;
                }else{
                    var regNsec = /[A-Z]{1}/;
                }
                if(format_parc_nb_chiffre==4){
                    var reg = /\d{4}/;
                }else{
                    var reg = /\d{3}/;
                }
                var id_parc = document.getElementById('id_parc').value.toUpperCase();
                if(document.getElementById('SelectNsec').selectedIndex){
                    if(SelectNsec.selectedIndex==0){
                        alert('Veuillez s&eacute;lectionner la s&eacute;ction cadastrale.');
                        return false;
                    }
                }else{
                    if(!checkString(SelectNsec)){
                        alert('Veuillez saisir la section cadastrale.');
                        return false;
                    }else{
                        SelectNsec = document.getElementById('SelectNsec').value.toUpperCase();
                        if(!SelectNsec.match(regNsec)){
                            alert('La section cadastrale n\'est pas valide. Veuillez saisir ' + format_parc_nb_lettre + ' lettres.');
                            return false;
                        }
                    }
                }
                if(document.getElementById('SelectParcelle').selectedIndex){
                    if(SelectParcelle.selectedIndex==0 && !checkString(id_parc)){
                        alert("Veuillez selectionner une parcelle dans la liste\nou saisir une parcelle dans la zone de saisie.");
                        return false;
                    }
                    if(SelectParcelle.selectedIndex==0 && !id_parc.match(reg)){
                        alert('La parcelle saisie n\'est pas valide. Veuillez saisir ' + format_parc_nb_chiffre + ' chiffres.');
                        return false;
                    }
                    if(SelectParcelle.selectedIndex > 0){
                        id_parc = SelectParcelle.options[SelectParcelle.selectedIndex].value
                    }
                }else{
                    if(!checkString(id_parc)){
                        alert("Veuillez saisir la parcelle.");
                        return false;
                    }
                    if(!id_parc.match(reg)){
                        alert('La parcelle saisie n\'est pas valide. Veuillez saisir 4 chiffres.');
                        return false;
                    }
                }
                $(this).dialog('close');
                /*
                
                if(!id_parc.match(reg)){
                    alert('Parcelle non valide');
                    return false;
                }
                */
                if(document.getElementById('SelectNsec').selectedIndex){
                    id_parc = SelectNsec.options[SelectNsec.selectedIndex].value + id_parc;
                    $("#SelectNsec").val('-1').trigger('change');
                    $("#SelectParcelle").val('-1').trigger('change');
                }else{
                    id_parc = SelectNsec + id_parc;
                    $("#SelectNsec").value = '';
                }
                document.getElementById('id_parc').value = "";
                //$("#SelectNsec").val('-1').trigger('change');
                //$("#SelectParcelle").val('-1').trigger('change');
                var MSG="";
                $.ajax({
                            type: "POST",
                            url: "index.php",
                            async: false,
                            data:
                            {
                                P : '303',
                                action: 'AddPARCELLE',
                                idDossier : id_parc,
                                NbLettre: format_parc_nb_lettre
                            }
                        })
                        .done(function(data){
                            eval(data);
                            if(MSG == 'OK'){
                                window.document.getElementById('msgAddParcelle').innerHTML = "Parcelle ajout&eacute;e";tooltip.init();
                                /*
                                var msg = 'Parcelle ajout&eacute;e';
                                $("#dialog-confirm").html("<img src='./images/information.gif' border='0' /><br/><br/>" + msg);
                                // Define the Dialog and its properties.
                                $("#dialog-confirm").dialog({
                                    resizable: false,
                                    modal: true,
                                    title: "Ajout Parcelle",
                                    height: 250,
                                    width: 400,
                                    buttons: {
                                        "OK": function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                */
                            }else{
                                var msg = "Erreur lors de l'ajout de la Parcelle";
                                $("#dialog-confirm").html("<img src='./images/stop_48.png' border='0' /><br/><br/>" + msg);
                                // Define the Dialog and its properties.
                                $("#dialog-confirm").dialog({
                                    resizable: false,
                                    modal: true,
                                    title: "Ajout Parcelle",
                                    height: 250,
                                    width: 400,
                                    buttons: {
                                        "Fermer": function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                            }
                        });
                
            },
            "Annuler": function () {
                $(this).dialog('close');
            }
        }
    });
    return false;
}

function SupprimerParcelle(idDemParc,idParc){
    var msg = 'Etes-vous s&ucirc;r(e) de vouloir<br/>supprimer la parcelle <b>' + idParc + '</b> ?';
    $("#dialog-confirm").html("<img src='./images/imagesQuestion1_48.png' border='0' /><br/>" + msg);
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation Suppression",
        height: 250,
        width: 400,
        buttons: {
            "OK": function () {
                $(this).dialog('close');
                DeleteDemandeAjax('PARCELLE',idDemParc);
            },
            "Annuler": function () {
                $(this).dialog('close');
            }
        }
    });
    return false;
}

function AddVoie(){
    //$("#dialog-addParcelle").html("<img src='./images/stop_48.png' border='0' /><br/>" + msg);
    // Define the Dialog and its properties.
    $("#dialog-addVoie").dialog({
        resizable: false,
        modal: true,
        title: "Ajouter une Voie",
        height: 260,
        width: 460,
        buttons: {
            "Enregistrer": function () {
                window.document.getElementById('msgAddVoie').innerHTML = "";
                window.document.getElementById('msgAddDoc').innerHTML = "";
                window.document.getElementById('msgAddParcelle').innerHTML = "";tooltip.init();

                var SelectCdruru = document.getElementById('cdruru');
                var libelle_voie = document.getElementById('libelle_voie').value;
                var code_com = document.getElementById('code_com').value;
                if(code_com == '13001' && SelectCdruru.selectedIndex == 0){
                    alert("Veuillez selectionner une rue");
                    return false;
                }
                var cdruru = SelectCdruru.options[SelectCdruru.selectedIndex].value;
                if(cdruru == '-1'){
                    cdruru = '';
                }
                if(cdruru=='' && !checkString(libelle_voie)){
                    alert("Veuillez saisir une rue ou en selectionner une dans la liste");
                    return false;
                }
                $("#SelectCdruru").val('-1');
                $("#SelectCdruru").trigger('change.select2');
                document.getElementById('libelle_voie').value = "";
                $(this).dialog('close');
                var MSG="";
                $.ajax({
                            type: "POST",
                            url: "index.php",
                            async: false,
                            data:
                            {
                                P : '303',
                                action: 'AddVOIE',
                                idDossier : cdruru,
                                libelle_voie : libelle_voie
                            }
                        })
                        .done(function(data){
                            eval(data);
                            if(MSG=='OK'){
                                window.document.getElementById('msgAddVoie').innerHTML = "Rue ajout&eacute;e";tooltip.init();
                                /*
                                var msg = 'Rue ajout&eacute;e';
                                $("#dialog-confirm").html("<img src='./images/information.gif' border='0' /><br/><br/>" + msg);
                                // Define the Dialog and its properties.
                                $("#dialog-confirm").dialog({
                                    resizable: false,
                                    modal: true,
                                    title: "Ajout Rue",
                                    height: 250,
                                    width: 400,
                                    buttons: {
                                        "OK": function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                                */
                            }else{
                                var msg = "Erreur lors de l'ajout de la rue";
                                $("#dialog-confirm").html("<img src='./images/stop_48.png' border='0' /><br/><br/>" + msg);
                                // Define the Dialog and its properties.
                                $("#dialog-confirm").dialog({
                                    resizable: false,
                                    modal: true,
                                    title: "Ajout Rue",
                                    height: 250,
                                    width: 400,
                                    buttons: {
                                        "Fermer": function () {
                                            $(this).dialog('close');
                                        }
                                    }
                                });
                            }
                        });
                
            },
            "Annuler": function () {
                $(this).dialog('close');
            }
        }
    });
    return false;
}

function SupprimerVoie(idDemVoie,cdruru){
    var msg = 'Etes-vous s&ucirc;r(e) de vouloir<br/>supprimer la Rue <b>#' + cdruru + '</b> ?';
    $("#dialog-confirm").html("<img src='./images/imagesQuestion2_48.png' border='0' /><br/>" + msg);
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation Suppression",
        height: 250,
        width: 400,
        buttons: {
            "OK": function () {
                $(this).dialog('close');
                DeleteDemandeAjax('VOIE',idDemVoie);
            },
            "Annuler": function () {
                $(this).dialog('close');
            }
        }
    });
    return false;
}

function AddDocument(){
    //$("#dialog-addParcelle").html("<img src='./images/stop_48.png' border='0' /><br/>" + msg);
    // Define the Dialog and its properties.
    $("#dialog-addDoc").dialog({
        resizable: false,
        modal: true,
        title: "Ajouter un Document",
        height: 250,
        width: 500,
        buttons: {
            "Enregistrer": function () {
                var nom_doc = document.getElementById('nom_doc').value;
                var fichier = document.getElementById('fichier').value;
                window.document.getElementById('msgAddVoie').innerHTML = "";
                window.document.getElementById('msgAddDoc').innerHTML = "";
                window.document.getElementById('msgAddParcelle').innerHTML = "";tooltip.init();
                if(!checkString(nom_doc)){
                    alert("Veuillez saisir le nom du document.");
                    return false;
                }
                if(!checkString(fichier)){
                    alert("Veuillez selectionner le fichier.");
                    return false;
                }
                $(this).dialog('close');
                $("#F3").submit();
                /*
                var MSG="";
                var params = $( "#F3" ).serialize();
                $.post( "./index.php", params )
                .done(function( data )
                {
                    eval(data);
                    if(MSG=='OK'){
                        var msg = 'Document ajout&eacute;';
                        $("#dialog-confirm").html("<img src='./images/information.gif' border='0' /><br/><br/>" + msg);
                        // Define the Dialog and its properties.
                        $("#dialog-confirm").dialog({
                            resizable: false,
                            modal: true,
                            title: "Ajout Document",
                            height: 250,
                            width: 400,
                            buttons: {
                                "OK": function () {
                                    $(this).dialog('close');
                                }
                            }
                        });
                    }
                });
                */
            },
            "Annuler": function () {
                $(this).dialog('close');
            }
        }
    });
    return false;
}

function SupprimerDocument(idDocument,idDocument){
    var msg = 'Etes-vous s&ucirc;r(e) de vouloir<br/>supprimer le document <b>#' + idDocument + '</b> ?';
    $("#dialog-confirm").html("<img src='./images/imagesQuestion2_48.png' border='0' /><br/>" + msg);
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation Suppression",
        height: 250,
        width: 400,
        buttons: {
            "OK": function () {
                $(this).dialog('close');
                DeleteDemandeAjax('DOCUMENT',idDocument);
            },
            "Annuler": function () {
                $(this).dialog('close');
            }
        }
    });
    return false;
}

function DeleteDemandeAjax(typeDossier,idDossier){
    var MSG="";
    var messageV = "";
    var messageD = "";
    var messageP = "";
    if(typeDossier == "PARCELLE"){
        messageP = "<font color='red'>Parcelle supprim&eacute;e</font>";
    }else if(typeDossier == "DOCUMENT"){
        messageD = "<font color='red'>Document supprim&eacute;</font>";
    }else if(typeDossier == "VOIE"){
        messageV = "<font color='red'>Rue supprim&eacute;e</font>";
    }
    $.ajax({
                type: "POST",
                url: "index.php",
                async: false,
                data:
                {
                    P : '303',
                    action: 'Delete'+typeDossier,
                    idDossier : idDossier
                }
            })
            .done(function(data){
                eval(data);
                if(MSG=='OK'){
                    window.document.getElementById('msgAddVoie').innerHTML = messageV;
                    window.document.getElementById('msgAddDoc').innerHTML = messageD;
                    window.document.getElementById('msgAddParcelle').innerHTML = messageP;tooltip.init();
                    /*
                    var msg = 'Suppression r&eacute;alis&eacute;e';
                    $("#dialog-confirm").html("<img src='./images/information.gif' border='0' /><br/><br/>" + msg);
                    // Define the Dialog and its properties.
                    $("#dialog-confirm").dialog({
                        resizable: false,
                        modal: true,
                        title: "Suppression",
                        height: 250,
                        width: 400,
                        buttons: {
                            "OK": function () {
                                $(this).dialog('close');
                            }
                        }
                    });
                    */
                }
            });
}

function ChargeSelectParcelle(){
    if(_xmlHttp&&_xmlHttp.readyState!=0){
        _xmlHttp.abort()
    }
    _xmlHttp=getXMLHTTP();
    if(_xmlHttp){
        //appel à l'url distante
        var SelectNsec = document.F2.SelectNsec;
        var nsec = SelectNsec.options[SelectNsec.selectedIndex].value;
        if(nsec == ''){
          return false;
        }
        _xmlHttp.open("GET","./index.php?P=303&action=SearchParcelle&nsec="+nsec,true);
        _xmlHttp.onreadystatechange=function() {
            if(_xmlHttp.readyState==4&&_xmlHttp.responseXML)
            {
                //var liste = traiteXmlSuggestions(_xmlHttp.responseXML)
                //var liste;
                var items = _xmlHttp.responseXML.getElementsByTagName('item');
                var option,elt;
                var SelectParcelle = document.getElementById('SelectParcelle');
                $("#SelectParcelle").empty();
                //SelectParcelle.clear();
                //alert(items.length);
                option = document.createElement( 'option' );
                option.value = "-1";
                option.text = "----";
                SelectParcelle.add(option);
                for (var i=0; i < items.length; ++i)
                {
                    elt = getValeur(items[i],'IDPARC');
                    option = document.createElement( 'option' );
                    option.value = option.text = elt;
                    SelectParcelle.add(option);
                }
            }
        };
        // envoi de la requete
        _xmlHttp.send(null)
    }
}

function ImprimerCourrier(){
    F = document.getElementById('F1');
    var msg = '';
    var ok = 1;
    if(ok == 1 && F.statut_aep.selectedIndex == 0){
        ok = 0;
        msg = 'Veuillez indiquer si la parcelle est raccordable au r&eacute;seau AEP...';
    }
    if(ok == 1 && F.statut_eu.selectedIndex == 0){
        ok = 0;
        msg = 'Veuillez indiquer si la parcelle est raccordable au r&eacute;seau EU...';
    }
    if(ok == 1 && F.id_interlocuteur.selectedIndex == 0){
        ok = 0;
        msg = 'Veuillez indiquer l\'interlocuteur...';
    }
    if(ok == 1 && F.id_attestant.selectedIndex == 0){
        ok = 0;
        msg = 'Veuillez indiquer la personne attestant le courrier...';
    }
    if(ok == 1 && F.id_signataire.selectedIndex == 0){
        ok = 0;
        msg = 'Veuillez indiquer le signataire du courrier...';
    }

    if(ok == 1){
        var id_demande = F.id_demande.value;
        var w = window.open('','frm');
        w.location = './index.php?P=304&id_demande='+id_demande;
    }else{
        $("#dialog-erreur").html("<img src='./images/stop_48.png' border='0' /><br/>" + msg);
        // Define the Dialog and its properties.
        $("#dialog-erreur").dialog({
            resizable: false,
            modal: true,
            title: "Erreur de saisie",
            height: 250,
            width: 400,
            buttons: {
                "OK": function () {
                    $(this).dialog('close');
                }
            }
        });
        return false;
    }
}

function VerifDate(vDate) { 
    var objDate,  // date object initialized from the ExpiryDate string 
        mSeconds, // ExpiryDate in milliseconds 
        day,      // day 
        month,    // month 
        year,     // year 
        hour,
        minute,
        seconde;
    var ExpiryDate = vDate;
    if(ExpiryDate.length == 16){
        ExpiryDate = ExpiryDate + ':00';
    }
    // date length should be 10 characters (no more no less) 
    if (ExpiryDate.length !== 10 && ExpiryDate.length !== 19) { 
        return false; 
    } 
    // third and sixth character should be '/' 
    if (ExpiryDate.substring(2, 3) !== '/' || ExpiryDate.substring(5, 6) !== '/') { 
        return false; 
    }
    if(ExpiryDate.length == 19  && (ExpiryDate.substring(13, 14) !== ':' || ExpiryDate.substring(16, 17) !== ':')){
        return false;
    }
    // extract month, day and year from the ExpiryDate (expected format is mm/dd/yyyy) 
    // subtraction will cast variables to integer implicitly (needed 
    // for !== comparing) 
    day = ExpiryDate.substring(0, 2) - 0; // because months in JS start from 0 
    month = ExpiryDate.substring(3, 5) - 1; 
    year = ExpiryDate.substring(6, 10) - 0; 
    if(ExpiryDate.length == 19){
        hour = ExpiryDate.substring(11, 13) - 0;
        minute = ExpiryDate.substring(14, 16) - 0;
        seconde = ExpiryDate.substring(17, 19) - 0;
    }else{
        hour = 0;
        minute = 0;
        seconde = 0;
    }
    //alert('day:'+day+', month:' + month + ', year:' + year + ', hour:' + hour + ', minute:' + minute + ', seconde:' + seconde);
    // test year range 
    if (year < 2000 || year > 2045) { 
        return false; 
    } 
    // convert ExpiryDate to milliseconds
    mSeconds = (new Date(year, month, day, hour, minute, seconde)).getTime(); 
    // initialize Date() object from calculated milliseconds 
    objDate = new Date(); 
    objDate.setTime(mSeconds); 
    // compare input date and parts from Date() object 
    // if difference exists then date isn't valid 
    if (objDate.getFullYear() !== year || 
        objDate.getMonth() !== month || 
        objDate.getDate() !== day ||
        objDate.getHours() !== hour ||
        objDate.getMinutes() !== minute ||
        objDate.getSeconds() !== seconde) { 
        return false; 
    } 
    // otherwise return true 
    return true; 
}

function checkString(entry){
	for(var i = 0; i < entry.length; i++){
		if (entry.charAt(i) != " "){
			return true;
		}           
	}
	return false;
}


