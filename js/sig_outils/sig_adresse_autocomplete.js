// retourne un objet xmlHttpRequest.
// méthode compatible entre tous les navigateurs (IE/Firefox/Opera)
function sigAdresseGetXMLHTTP()
{
    var xhr=null;
    if(window.XMLHttpRequest)
    {
        // Firefox et autres
        xhr = new XMLHttpRequest();
    }
    else if(window.ActiveXObject)
    {
        // Internet Explorer
        try {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            try
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e1)
            {
                xhr = null;
            }
        }
    }
    else
    {
        // XMLHttpRequest non supporté par le navigateur
        alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
    }
    return xhr;
}

var _sigAdresseDocumentFormName = null; // le formulaire contenant notre champ texte
var _sigAdresseDocumentForm = null; // le formulaire contenant notre champ texte
var _sigAdresseInputField = null; // le champ texte lui-même
//var _submitButton=null; // le bouton submit de notre formulaire
var _sigAdresseFunctionCall = 'sigAdresseCallSuggestions';
var _sigAdresseMinCarac = 0; // Nombre de caractère minimum avant de lancer l'autosearch

var _sigAdresseImageOk = 'data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAAAwFBMVEVMnwnv7++82aSDwFLV1dWbu4HK271gsB+/wL+k039WswyPzF3X58rj8Njz9fFqtC2u0ZLMzMy6zaqKwF9XrBFfwRBnuiTe3t7n5+e15o2965h1tUGBxklQpgqdy3ne5s5cwQzH4bOs537f7tTFxcXP7LiM11Do7OVatRGGuV1UrwqWxm7Z8cbn89620aCiyoD39/fx9O5brxmU1lJXtwtisx9sxSXb7szu8erN47rl795utzS/2KthwhNTpRGFu1mZkkLYAAAAQHRSTlP///////////////////////////////////////////////////////////////8A////////////////////4ghnHgAAAAlwSFlzAAALEgAACxIB0t1+/AAAAB90RVh0U29mdHdhcmUATWFjcm9tZWRpYSBGaXJld29ya3MgOLVo0ngAAAAWdEVYdENyZWF0aW9uIFRpbWUAMDIvMTUvMDZqn4r+AAAAi0lEQVQYlWMwQAMMaHwdNAFJKVQBVQ1dFAFzI24UM5TZ7XiRBczZGThBtlhaQfiKRrLWfCABJn55INdQTktLhAfsDgt2LmZ9bVMTExMBqMNsxMREgcDMHu5SPRljNTU1aQuE09mElZSY5ZH9os6qKcTHBxVglBBnEVTh4FARZBGXYASr4ONjhACQGgBIXygIaYljGgAAAABJRU5ErkJggg==';
var _sigAdresseImageKo = 'data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAAAtFBMVEXECwvHw8PjgoLiUlLWOjrl5eXuDQ3lpKTzzMzOKCjv7+/pdHTc3NzTJSXzHx/qNjb////rtrbhb2/vw8PkDQ3kkpLfQ0P75OTyY2P34uLU1NT1FhbyPz/ve3vtKSn55OTMMzPtbW3xjY3XSEjMzMztXFzwcnLvHBz31NTyMjL1Ozvxzs7xk5PvoqLtTEzdOTnUKir67+/2uLjRDAzcIyP/GRn0e3v1KSnhTU3sODj1Zmb3c3N0YdxgAAAAPHRSTlP/////////////////////AP////////////////////////////////////////////////////////8Es7xiAAAACXBIWXMAAAsSAAALEgHS3X78AAAAH3RFWHRTb2Z0d2FyZQBNYWNyb21lZGlhIEZpcmV3b3JrcyA4tWjSeAAAALxJREFUGJVdz4kOgjAMBmBQVJiKk2sOvMCDKeMoCirv/2COAYmxadbkS9P8U/BfKd1IZrPkB9baOwzH2noAN+epKJ67HdgF57wsxVPYEk5zXpIoIiWfn1qAItoRTETvogIE6F5dXwnG5LKpPV0Ay5umEUCz2zZn7Y3nPTtgSjFdvZ7yqBWbKf18aGrGlgRYBsG+qvZBsIQuGDMeznTqPAw2RIfRUVGOI+ijo8nCP6vq2V9MEPS/BUAI5AL+ApmYGX/1h28BAAAAAElFTkSuQmCC';
var _sigAdresseImageLoading = 'data:image/;base64,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';


function sigAdresseInitData(form)
{
	_sigAdresseDocumentFormName = form;
	_sigAdresseDocumentForm = eval('document.'+form);
}

function sigAdresseInitAutoComplete(form, field, functionCall, minCarac)
{
    //_sigAdresseDocumentForm = form;
    _sigAdresseInputField = field;
    _sigAdresseMinCarac = minCarac;
    _sigAdresseFunctionCall = functionCall;
    //  _submitButton=submit;
    _sigAdresseInputField.autocomplete = "off";
    
    if (!document.getElementById('sigAdresseCompleteDiv'))
    {
        sigAdresseCreeAutocompletionDiv();
    }
    
    _sigAdresseCurrentInputFieldValue = _sigAdresseInputField.value;
    _sigAdresseOldInputFieldValue = _sigAdresseCurrentInputFieldValue;
    _sigAdresseResultCache = new Object();
    _sigAdresseResultCacheAction = new Object();
    sigAdresseCacheResults("", new Array())
    document.onkeydown = sigAdresseOnKeyDownHandler;
    _sigAdresseInputField.onkeyup = sigAdresseOnKeyUpHandler;
    _sigAdresseInputField.onblur = sigAdresseOnBlurHandler;
    window.onresize = sigAdresseOnResizeHandler;
    // Premier déclenchement de la fonction dans 200 millisecondes
    setTimeout("sigAdresseMainLoop()", 200);
}

var _sigAdresseOldInputFieldValue = ""; // valeur précédente du champ texte
var _sigAdresseCurrentInputFieldValue = ""; // valeur actuelle du champ texte
var _sigAdresseResultCache = new Object(); // mécanisme de cache des requetes
var _sigAdresseResultCacheAction = new Object(); // mécanisme de cache des requetes

// tourne en permanence pour suggerer suite à un changement du champ texte
function sigAdresseMainLoop()
{
    if (_sigAdresseOldInputFieldValue != _sigAdresseCurrentInputFieldValue)
    {
        var valeur = sigAdresseEscapeURI(_sigAdresseCurrentInputFieldValue);
        var suggestions = _sigAdresseResultCache[_sigAdresseCurrentInputFieldValue];
        var actions = _sigAdresseResultCacheAction[_sigAdresseCurrentInputFieldValue];
        if (_sigAdresseCurrentInputFieldValue.length > _sigAdresseMinCarac)
        {
            if (suggestions)
            {
                // la réponse était encore dans le cache
                sigAdresseMetsEnPlace(valeur, suggestions, actions);
            }
            else
            {
                //sigAdresseCallSuggestions(valeur) // appel distant
                eval(_sigAdresseFunctionCall + '(valeur);');
            }
        }
        _sigAdresseInputField.focus();
    }
    _sigAdresseOldInputFieldValue = _sigAdresseCurrentInputFieldValue;
    setTimeout("sigAdresseMainLoop()", 200); // la fonction se redéclenchera dans 200 ms
    return true;
}

// echappe les caractère spéciaux
function sigAdresseEscapeURI(La)
{
    if (encodeURIComponent)
    {
        return encodeURIComponent(La);
    }
    if (escape)
    {
        return escape(La);
    }
}

var _sigAdresseXmlHttp = null; //l'objet xmlHttpRequest utilisé pour contacter le serveur
var _sigAdresseAdresseRecherche = "index.php" //l'adresse à interroger pour trouver les suggestions

function sigAdresseInitXmlHttp()
{
	if (_sigAdresseXmlHttp == null)
	{
		_sigAdresseXmlHttp = sigAdresseGetXMLHTTP();
	}
}


function sigAdresseGetValeur(xml, attribut, defaut)
{
    if (defaut != undefined)
    {
        var val = defaut;
    }
    else
    {
        var val = '';
    }
    
    try
    {
        val = xml.getElementsByTagName(attribut)[0].firstChild.nodeValue;
    }
    catch (e)
    {
        //val = '';
    }
    return val;
}


function sigAdresseCallSuggestionsAdresse(valeur)
{
    if (_sigAdresseXmlHttp&&_sigAdresseXmlHttp.readyState!=0)
    {
        _sigAdresseXmlHttp.abort()
    }
    _sigAdresseXmlHttp = sigAdresseGetXMLHTTP();
    if (_sigAdresseXmlHttp)
    {
        //appel à l'url distante
        _sigAdresseXmlHttp.open("GET", _sigAdresseAdresseRecherche + "?P=SIGADRVOIE&voie=" + valeur, true);
        _sigAdresseXmlHttp.onreadystatechange = function()
        {
            if (_sigAdresseXmlHttp.readyState == 4 && _sigAdresseXmlHttp.responseXML)
            {
                //var liste = traiteXmlSuggestions(_sigAdresseXmlHttp.responseXML)
                //var liste;
                var items = _sigAdresseXmlHttp.responseXML.getElementsByTagName('item');
                var optionsListe = new Array();
                var optionsAction = new Array();
                var elt, chAction;
                
                //alert(items.length);
                for (var i=0; i < items.length; ++i)
                {
                    elt = sigAdresseGetValeur(items[i], 'adresse');
                    //chAction = "document.formldap.intervention_cle.value='"+elt+"';";
                    //chAction = "window.document.getElementById(\"divajoutuser\").innerHTML='Ajout de &lt;span class=s&gt;"+elt+"&lt;/span&gt; en cours...&nbsp;&lt;img src=\"images/loading.gif\"&gt;';";
                    chAction = "document." + _sigAdresseDocumentFormName + ".sig_adresse_cdruru.value='" + sigAdresseGetValeur(items[i], 'cdruru') + "';";
                    //chAction += "document.form1.cdrurulib.value='"+sigAdresseGetValeur(items[i],'cdruru')+"';";
                    chAction += "window.document.getElementById(\"sig_adresse_adresse_check\").innerHTML='&lt;img align=absbottom src=\"" + _sigAdresseImageOk + "\"&gt;';";
                    chAction += "window.document.getElementById(\"sig_adresse_adr_num_voie_check\").innerHTML='&lt;img align=absbottom src=\"" + _sigAdresseImageKo + "\"&gt; Tapez ici le num&eacute;ro de voirie';";
                    chAction += "window.document.getElementById(\"sig_adresse_adr_ens_nom_check\").innerHTML='&lt;img align=absbottom src=\"" + _sigAdresseImageKo + "\"&gt; Tapez ici le nom de l\\'ensemble';";
                    chAction += "document." + _sigAdresseDocumentFormName + ".sig_adresse_adr_num_voie.value='';";
                    chAction += "document." + _sigAdresseDocumentFormName + ".sig_adresse_adr_ens_nom.value='';";
                    //            chAction += "document.form1.sous_adressage.value='';";
                    //chAction += "window.document.getElementById(\"cdrurulib_check\").innerHTML='&lt;img src=\"images/icon-16-checkin.png\"&gt;';";
                    chAction += "document.getElementById('sig_adresse_adr_num_voie').style.display='block';";
                    chAction += "document.getElementById('sig_adresse_adr_ens_nom').style.display='block';";
                    chAction += "document.getElementById('sig_adresse_sous_adressage').style.display='block';";
                    chAction += "document." + _sigAdresseDocumentFormName + ".sig_adresse_adr_num_voie.focus();";
                    
                    //            chAction += "tooltip.init();";
                    //            chAction += "document.getElementById(\"lienajoutprob\").focus();";
                    optionsListe.push(elt);
                    optionsAction.push(chAction);
                }
                
                sigAdresseCacheResults(valeur, optionsListe, optionsAction);
                sigAdresseMetsEnPlace(valeur, optionsListe, optionsAction);
            }
        };
        // envoi de la requete
        _sigAdresseXmlHttp.send(null);
    }
}

// Mecanisme de caching des réponses
function sigAdresseCacheResults(debut, suggestions, actions)
{
    _sigAdresseResultCache[debut] = suggestions;
    _sigAdresseResultCacheAction[debut] = actions;
}


// Transformation XML en tableau
//function traiteXmlSuggestions(xmlDoc) {
////  var options = xmlDoc.getElementsByTagName('option');
////  var optionsListe = new Array();
////  for (var i=0; i < options.length; ++i) {
////    optionsListe.push(options[i].firstChild.data);
////  }
////  return optionsListe;
//  
//    var items = xmlDoc.getElementsByTagName('item');
//    var optionsListe = new Array();
//    var elt;
//    //alert(items.length);
//    for (var i=0; i < items.length; ++i)
//    {
//        //optionsListe.push(options[i].firstChild.data);
//        elt = items[i].getElementsByTagName('enseigne');
//        //alert(elt.length);
//        if (elt[0].hasChildNodes)
//        {
//            //alert(elt[0].firstChild.nodeValue);
//            optionsListe.push(elt[0].firstChild.nodeValue);
//        }
//    }
//    return optionsListe;
//    
//}

//insère une règle avec son nom
function sigAdresseInsereCSS(nom, regle)
{
    if (document.styleSheets)
    {
        var I = null;
        for (var i = 0; i < document.styleSheets.length; ++i)
        {
            if (document.styleSheets[i].href.substr(0, 25) != 'http://img.prod.intranet/')
            {
                I = document.styleSheets[i];
                break;
            }
        }
        //var I=document.styleSheets[2];
        if( I.addRule)
        {
            // méthode IE
            I.addRule(nom,regle)
        }
        else if(I.insertRule)
        {
            // méthode DOM
            I.insertRule(nom + " { " + regle + " }", I.cssRules.length)
        }
    }
}
    
function sigAdresseInitStyle()
{
    //  var AutoCompleteDivListeStyle="font-size: 13px; font-family: arial,sans-serif; word-wrap:break-word; ";
    //  var AutoCompleteDivListeStyle="font-size: 10px; font-family: Verdana,Arial,sans-serif,Geneva; color: #505050; ";
    //  var AutoCompleteDivStyle="display: block; padding-left: 3; padding-right: 3; height: 13px; overflow: hidden; background-color: #F1FBD3;";
    //  var AutoCompleteDivActStyle="cursor: pointer; background-color: #D6FF49; color: #000000; ";
    //  var AutoCompleteDivActionStyle="display: none; ";
    //  
    //  sigAdresseInsereCSS(".AutoCompleteDivListeStyle",AutoCompleteDivListeStyle);
    //  sigAdresseInsereCSS(".AutoCompleteDiv",AutoCompleteDivStyle);
    //  sigAdresseInsereCSS(".AutoCompleteDivAct",AutoCompleteDivActStyle);
    //  sigAdresseInsereCSS(".AutoCompleteDivAction",AutoCompleteDivActionStyle);
}

function sigAdresseSetStylePourElement(c, name)
{
    c.className = name;
}

// calcule le décalage à gauche
function sigAdresseCalculateOffsetLeft(r)
{
    return sigAdresseCalculateOffset(r, "offsetLeft");
}

// calcule le décalage vertical
function sigAdresseCalculateOffsetTop(r)
{
    return sigAdresseCalculateOffset(r, "offsetTop");
}

function sigAdresseCalculateOffset(r, attr)
{
    var kb = 0;
    while (r)
    {
        kb += r[attr];
        r = r.offsetParent;
    }
    return kb;
}

// calcule la largeur du champ
function sigAdresseCalculateWidth()
{
    return _sigAdresseInputField.offsetWidth - 2 * 1;
}

function sigAdresseSetCompleteDivSize()
{
    if(_sigAdresseCompleteDiv){
        _sigAdresseCompleteDiv.style.left = sigAdresseCalculateOffsetLeft(_sigAdresseInputField) + "px";
        _sigAdresseCompleteDiv.style.top = sigAdresseCalculateOffsetTop(_sigAdresseInputField) + _sigAdresseInputField.offsetHeight - 1 + "px";
        _sigAdresseCompleteDiv.style.width = sigAdresseCalculateWidth() + "px";
    }
}

function sigAdresseCreeAutocompletionDiv()
{
    sigAdresseInitStyle();
    _sigAdresseCompleteDiv = document.createElement("DIV");
    _sigAdresseCompleteDiv.id = "sigAdresseCompleteDiv";
    var borderLeftRight = 1;
    var borderTopBottom = 1;
    //  _sigAdresseCompleteDiv.style.borderRight="#7DC622 "+borderLeftRight+"px solid";
    //  _sigAdresseCompleteDiv.style.borderLeft="#7DC622 "+borderLeftRight+"px solid";
    //  _sigAdresseCompleteDiv.style.borderTop="#7DC622 "+borderTopBottom+"px solid";
    //  _sigAdresseCompleteDiv.style.borderBottom="#7DC622 "+borderTopBottom+"px solid";
    _sigAdresseCompleteDiv.style.zIndex = "1";
    _sigAdresseCompleteDiv.style.paddingRight = "0";
    _sigAdresseCompleteDiv.style.paddingLeft = "0";
    _sigAdresseCompleteDiv.style.paddingTop = "0";
    _sigAdresseCompleteDiv.style.paddingBottom = "0";
    sigAdresseSetCompleteDivSize();
    _sigAdresseCompleteDiv.style.visibility = "hidden";
    _sigAdresseCompleteDiv.style.position = "absolute";
    _sigAdresseCompleteDiv.style.backgroundColor = "white";
    document.body.appendChild(_sigAdresseCompleteDiv);
    sigAdresseSetStylePourElement(_sigAdresseCompleteDiv, "AutoCompleteDivListeStyle");
}

function sigAdresseMetsEnPlace(valeur, liste, actions)
{
    while (_sigAdresseCompleteDiv.childNodes.length > 0)
    {
        _sigAdresseCompleteDiv.removeChild(_sigAdresseCompleteDiv.childNodes[0]);
    }
    var ch = '';
    // mise en place des suggestions
    for(var f = 0; f < liste.length; ++f)
    {
        var nouveauDiv = document.createElement("DIV");
        nouveauDiv.onmousedown = sigAdresseDivOnMouseDown;
        nouveauDiv.onmouseover = sigAdresseDivOnMouseOver;
        nouveauDiv.onmouseout = sigAdresseDivOnMouseOut;
        sigAdresseSetStylePourElement(nouveauDiv, "AutoCompleteDiv");
        
        var nouveauSpan = document.createElement("SPAN");
        nouveauSpan.innerHTML = liste[f];
        sigAdresseSetStylePourElement(nouveauSpan, "AutoCompleteDivAction");
        nouveauDiv.appendChild(nouveauSpan);
        
        var nouveauSpan = document.createElement("SPAN");
        ch = liste[f];
        //Ajout d'un \ devant chaque parenthèse pour que l'evalution de la chaine ne plante pas.
        chaineAEval = "ch = ch.replace(/" + valeur.replace(/\(/g, '\\(').replace(/\)/g, '\\)') + "/g, '<strong><u>" + valeur + "</u></strong>');";
        
        
        eval(chaineAEval);
        nouveauSpan.innerHTML = ch; // le texte de la suggestion
        nouveauDiv.appendChild(nouveauSpan);
        ch = '';
        
        var nouveauSpanAction = document.createElement("SPAN");
        nouveauSpanAction.innerHTML = actions[f]; // l'action à faire
        sigAdresseSetStylePourElement(nouveauSpanAction, "AutoCompleteDivAction");
        nouveauDiv.appendChild(nouveauSpanAction);
        
        _sigAdresseCompleteDiv.appendChild(nouveauDiv);
        
        sigAdresseSetStylePourElement(nouveauDiv, "AutoCompleteDiv");
    
    }
    sigAdressePressAction();
    if (_sigAdresseCompleteDivRows > 0)
    {
        _sigAdresseCompleteDiv.height = 16 * _sigAdresseCompleteDivRows + 4;
    }
    else
    {
        sigAdresseHideCompleteDiv();
    }
}

var _sigAdresseLastKeyCode = null;

// Handler pour le keydown du document
var sigAdresseOnKeyDownHandler = function(event)
{
    // accès evenement compatible IE/Firefox
    if (!event && window.event)
    {
        event = window.event;
    }
    // on enregistre la touche ayant déclenché l'evenement
    if (event) {
        _sigAdresseLastKeyCode = event.keyCode;
    }
}

var _sigAdresseEventKeycode = null;

// Handler pour le keyup de lu champ texte
var sigAdresseOnKeyUpHandler = function(event)
{
    // accès evenement compatible IE/Firefox
    if (!event && window.event)
    {
        event = window.event;
    }
    _sigAdresseEventKeycode = event.keyCode;
    // Dans les cas touches touche haute(38) ou touche basse (40)
    if (_sigAdresseEventKeycode == 40 || _sigAdresseEventKeycode == 38)
    {
        // on autorise le blur du champ (traitement dans onblur)
        sigAdresseBlurThenGetFocus();
    }
    // taille de la selection
    var N = sigAdresseRangeSize(_sigAdresseInputField);
    // taille du texte avant la selection (selection = suggestion d'autocomplétion)
    var v = sigAdresseBeforeRangeSize(_sigAdresseInputField);
    // contenu du champ texte
    var V = _sigAdresseInputField.value;
    if (_sigAdresseEventKeycode != 0)
    {
        if (N > 0 && v != -1)
        {
            // on recupere uniquement le champ texte tapé par l'utilisateur
            V = V.substring(0, v);
        }
        // 13 = touche entrée
        if(_sigAdresseEventKeycode == 13 || _sigAdresseEventKeycode == 3)
        {
            var d = _sigAdresseInputField;
            // on mets en place l'ensemble du champ texte en repoussant la selection
            if (_sigAdresseInputField.createTextRange)
            {
                var t = _sigAdresseInputField.createTextRange();
                t.moveStart("character", _sigAdresseInputField.value.length);
                _sigAdresseInputField.select();
            }
            else if (d.setSelectionRange)
            {
                _sigAdresseInputField.setSelectionRange(_sigAdresseInputField.value.length, _sigAdresseInputField.value.length);
            }
            
            var actionCh = sigAdresseGetAction(_sigAdresseHighlightedSuggestionDiv);
            eval(actionCh);
            sigAdresseHideCompleteDiv();
            //alert('13 ou 3');
        }
        else
        {
            // si on a pas pu agrandir le champ non selectionné, on le mets en place violemment.
            if (_sigAdresseInputField.value != V)
            {
                _sigAdresseInputField.value = V;
            }
        }
    }
    // si la touche n'est ni haut, ni bas, on stocke la valeur utilisateur du champ
    if (_sigAdresseEventKeycode != 40 && _sigAdresseEventKeycode != 38)
    {
        // le champ courant n est pas change si key Up ou key Down
        _sigAdresseCurrentInputFieldValue = V;
    }
    if (sigAdresseHandleCursorUpDownEnter(_sigAdresseEventKeycode) && _sigAdresseEventKeycode != 0)
    {
        // si on a préssé une touche autre que haut/bas/enter
        sigAdressePressAction();
    }
}

// Change la suggestion selectionné.
// cette méthode traite les touches haut, bas et enter
function sigAdresseHandleCursorUpDownEnter(eventCode)
{
    if (eventCode == 40)
    {
        sigAdresseHighlightNewValue(_sigAdresseHighlightedSuggestionIndex + 1);
        return false;
    }
    else if (eventCode == 38)
    {
        sigAdresseHighlightNewValue(_sigAdresseHighlightedSuggestionIndex - 1);
        return false;
    }
    else if (eventCode == 13 || eventCode == 3)
    {
        return false;
    }
    return true;
}

var _sigAdresseCompleteDivRows = 0;
var _sigAdresseCompleteDivDivList = null;
var _sigAdresseHighlightedSuggestionIndex = -1;
var _sigAdresseHighlightedSuggestionDiv = null;

// gère une touche pressée autre que haut/bas/enter
function sigAdressePressAction()
{
    _sigAdresseHighlightedSuggestionIndex = -1;
    var suggestionList = _sigAdresseCompleteDiv.getElementsByTagName("div");
    var suggestionLongueur = suggestionList.length;
    // on stocke les valeurs précédentes
    // nombre de possibilités de complétion
    _sigAdresseCompleteDivRows = suggestionLongueur;
    // possiblités de complétion
    _sigAdresseCompleteDivDivList = suggestionList;
    // si le champ est vide, on cache les propositions de complétion
    if (_sigAdresseCurrentInputFieldValue == "" || suggestionLongueur == 0)
    {
        sigAdresseHideCompleteDiv();
    }
    else
    {
        sigAdresseShowCompleteDiv();
    }
    var trouve = false;
    // si on a du texte sur lequel travailler
    if (_sigAdresseCurrentInputFieldValue.length > 0)
    {
        var indice;
        // T vaut true si on a dans la liste de suggestions un mot commencant comme l'entrée utilisateur
        for (indice = 0; indice < suggestionLongueur; indice++)
        {
            if (sigAdresseGetSuggestion(suggestionList.item(indice)).toUpperCase().indexOf(_sigAdresseCurrentInputFieldValue.toUpperCase()) == 0)
            {
                trouve = true;
                break
            }
        }
    }
    // on désélectionne toutes les suggestions
    for (var i = 0; i < suggestionLongueur; i++)
    {
        sigAdresseSetStylePourElement(suggestionList.item(i), "AutoCompleteDiv");
    }
    // si l'entrée utilisateur (n) est le début d'une suggestion (n-1) on sélectionne cette suggestion avant de continuer
    if (trouve)
    {
        _sigAdresseHighlightedSuggestionIndex = indice;
        _sigAdresseHighlightedSuggestionDiv = suggestionList.item(_sigAdresseHighlightedSuggestionIndex);
    }
    else
    {
        _sigAdresseHighlightedSuggestionIndex = -1;
        _sigAdresseHighlightedSuggestionDiv = null;
    }
    var supprSelection = false;
    switch (_sigAdresseEventKeycode)
    {
        // cursor left, cursor right, page up, page down, others??
        case 8:
        case 33:
        case 34:
        case 35:
        case 35:
        case 36:
        case 37:
        case 39:
        case 45:
        case 46:
            // on supprime la suggestion du texte utilisateur
            supprSelection = true;
            break;
        default:
            break;
    }
    // si on a une suggestion (n-1) sélectionnée
    if (!supprSelection && _sigAdresseHighlightedSuggestionDiv)
    {
        sigAdresseSetStylePourElement(_sigAdresseHighlightedSuggestionDiv, "AutoCompleteDivAct");
        var z;
        if (trouve)
        {
            z = sigAdresseGetSuggestion(_sigAdresseHighlightedSuggestionDiv).substr(0);
        }
        else
        {
            z = _sigAdresseCurrentInputFieldValue;
        }
        if (z!=_sigAdresseInputField.value)
        {
            if (_sigAdresseInputField.value != _sigAdresseCurrentInputFieldValue)
            {
                return;
            }
            // si on peut créer des range dans le document
            if (_sigAdresseInputField.createTextRange || _sigAdresseInputField.setSelectionRange)
            {
                _sigAdresseInputField.value = z;
            }
            // on sélectionne la fin de la suggestion
            if (_sigAdresseInputField.createTextRange)
            {
                var t = _sigAdresseInputField.createTextRange();
                t.moveStart("character", _sigAdresseCurrentInputFieldValue.length);
                t.select();
            }
            else if(_sigAdresseInputField.setSelectionRange)
            {
                _sigAdresseInputField.setSelectionRange(_sigAdresseCurrentInputFieldValue.length, _sigAdresseInputField.value.length);
            }
        }
    }
    else
    {
        // sinon, plus aucune suggestion de sélectionnée
        _sigAdresseHighlightedSuggestionIndex = -1;
    }
}

var _sigAdresseCursorUpDownPressed = null;

// permet le blur du champ texte après que la touche haut/bas ai été pressé.
// le focus est récupéré après traitement (via le timeout).
function sigAdresseBlurThenGetFocus()
{
  _sigAdresseCursorUpDownPressed = true;
  //_sigAdresseInputField.blur();
  setTimeout("_sigAdresseInputField.focus();", 10);
  return;
}

// taille de la selection dans le champ input
function sigAdresseRangeSize(n)
{
    var N = -1;
    if (n.createTextRange)
    {
        var fa = document.selection.createRange().duplicate();
        N = fa.text.length;
    }
    else if (n.setSelectionRange)
    {
        N = n.selectionEnd - n.selectionStart;
    }
    return N;
}

// taille du champ input non selectionne
function sigAdresseBeforeRangeSize(n)
{
    var v = 0;
    if (n.createTextRange)
    {
        var fa = document.selection.createRange().duplicate();
        fa.moveEnd("textedit", 1);
        v = n.value.length - fa.text.length;
    }
    else if (n.setSelectionRange)
    {
        v = n.selectionStart;
    }
    else
    {
        v = -1;
    }
    return v;
}

// Place le curseur à la fin du champ
function sigAdresseCursorAfterValue(n)
{
    if (n.createTextRange)
    {
        var t = n.createTextRange();
        t.moveStart("character", n.value.length);
        t.select();
    }
    else if(n.setSelectionRange)
    {
        n.setSelectionRange(n.value.length, n.value.length);
    }
}


// Retourne la valeur de la possibilite (texte) contenu dans une div de possibilite
function sigAdresseGetSuggestion(uneDiv)
{
    if (!uneDiv)
    {
        return null;
    }
    return sigAdresseTrimCR(uneDiv.getElementsByTagName('span')[0].firstChild.data);
}

// Retourne l'action contenu dans une div de possibilite
function sigAdresseGetAction(uneDiv)
{
    if (!uneDiv)
    {
        return null;
    }
    return sigAdresseTrimCR(uneDiv.getElementsByTagName('span')[2].firstChild.data);
}

// supprime les caractères retour chariot et line feed d'une chaine de caractères
function sigAdresseTrimCR(chaine)
{
    for (var f = 0, nChaine = "", zb = "\n\r"; f < chaine.length; f++)
    {
        if (zb.indexOf(chaine.charAt(f) )== -1) {
            nChaine += chaine.charAt(f);
        }
    }
    return nChaine;
}

// Cache completement les choix de completion
function sigAdresseHideCompleteDiv()
{
    _sigAdresseCompleteDiv.style.visibility = "hidden";
}

// Rends les choix de completion visibles
function sigAdresseShowCompleteDiv()
{
    _sigAdresseCompleteDiv.style.visibility = "visible";
    sigAdresseSetCompleteDivSize();
}

// Change la suggestion en surbrillance
function sigAdresseHighlightNewValue(C)
{
    if (!_sigAdresseCompleteDivDivList || _sigAdresseCompleteDivRows <= 0)
    {
        return;
    }
    sigAdresseShowCompleteDiv();
    if (C >= _sigAdresseCompleteDivRows)
    {
        C = _sigAdresseCompleteDivRows - 1;
    }
    if (_sigAdresseHighlightedSuggestionIndex != -1 && C != _sigAdresseHighlightedSuggestionIndex)
    {
        sigAdresseSetStylePourElement(_sigAdresseHighlightedSuggestionDiv, "AutoCompleteDiv");
        _sigAdresseHighlightedSuggestionIndex = -1;
    }
    if (C < 0)
    {
        _sigAdresseHighlightedSuggestionIndex = -1;
        _sigAdresseInputField.focus();
        return;
    }
    _sigAdresseHighlightedSuggestionIndex = C;
    _sigAdresseHighlightedSuggestionDiv = _sigAdresseCompleteDivDivList.item(C);
    sigAdresseSetStylePourElement(_sigAdresseHighlightedSuggestionDiv, "AutoCompleteDivAct");
    _sigAdresseInputField.value = sigAdresseGetSuggestion(_sigAdresseHighlightedSuggestionDiv);
}

// Handler de resize de la fenetre
var sigAdresseOnResizeHandler = function(event)
{
    // recalcule la taille des suggestions
    sigAdresseSetCompleteDivSize();
}

// Handler de blur sur le champ texte
var sigAdresseOnBlurHandler = function(event)
{
    if (!_sigAdresseCursorUpDownPressed)
    {
        // si le blur n'est pas causé par la touche haut/bas
        sigAdresseHideCompleteDiv();
        // Si la dernière touche préssé est tab, on passe au bouton de validation
        if (_sigAdresseLastKeyCode == 9)
        {
            //_submitButton.focus();
            _sigAdresseLastKeyCode = -1
        }
    }
    _sigAdresseCursorUpDownPressed = false;
};

// declenchee quand on clique sur une div contenant une possibilite
var sigAdresseDivOnMouseDown = function()
{
    _sigAdresseInputField.value = sigAdresseGetSuggestion(this);
    var actionCh = sigAdresseGetAction(this);
    eval(actionCh);
    sigAdresseHideCompleteDiv(); // on cache le div
    //_sigAdresseDocumentForm.submit();
};

// declenchee quand on passe sur une div de possibilite. La div précédente est passee en style normal
var sigAdresseDivOnMouseOver = function()
{
    if (_sigAdresseHighlightedSuggestionDiv)
    {
        sigAdresseSetStylePourElement(_sigAdresseHighlightedSuggestionDiv, "AutoCompleteDiv");
    }
    sigAdresseSetStylePourElement(this, "AutoCompleteDivAct");
};

// declenchee quand la sourie quitte une div de possiblite. La div repasse a l'etat normal
var sigAdresseDivOnMouseOut = function()
{
    sigAdresseSetStylePourElement(this, "AutoCompleteDiv");
};

function sigAdresseCacheChampsAdresse(display_input)
{
	var rechargeFormulaire = false;//alert(_sigAdresseDocumentForm.sig_adresse_id_adr_location.value);
	
	if (_sigAdresseDocumentForm.sig_adresse_id_adr_location.value.length == 0)
	{
		rechargeFormulaire = true;
	}
	else if (confirm("Voulez-vous rechercher une autre adresse ?"))
	{
		rechargeFormulaire = true;
	}
	
	
	if (rechargeFormulaire == true)
	{
		//window.document.getElementById("cdrurulib_check").innerHTML='';
		window.document.getElementById("sig_adresse_adresse_check").innerHTML = '&nbsp;<img align="absbottom" src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAAAtFBMVEXECwvHw8PjgoLiUlLWOjrl5eXuDQ3lpKTzzMzOKCjv7+/pdHTc3NzTJSXzHx/qNjb////rtrbhb2/vw8PkDQ3kkpLfQ0P75OTyY2P34uLU1NT1FhbyPz/ve3vtKSn55OTMMzPtbW3xjY3XSEjMzMztXFzwcnLvHBz31NTyMjL1Ozvxzs7xk5PvoqLtTEzdOTnUKir67+/2uLjRDAzcIyP/GRn0e3v1KSnhTU3sODj1Zmb3c3N0YdxgAAAAPHRSTlP/////////////////////AP////////////////////////////////////////////////////////8Es7xiAAAACXBIWXMAAAsSAAALEgHS3X78AAAAH3RFWHRTb2Z0d2FyZQBNYWNyb21lZGlhIEZpcmV3b3JrcyA4tWjSeAAAALxJREFUGJVdz4kOgjAMBmBQVJiKk2sOvMCDKeMoCirv/2COAYmxadbkS9P8U/BfKd1IZrPkB9baOwzH2noAN+epKJ67HdgF57wsxVPYEk5zXpIoIiWfn1qAItoRTETvogIE6F5dXwnG5LKpPV0Ay5umEUCz2zZn7Y3nPTtgSjFdvZ7yqBWbKf18aGrGlgRYBsG+qvZBsIQuGDMeznTqPAw2RIfRUVGOI+ijo8nCP6vq2V9MEPS/BUAI5AL+ApmYGX/1h28BAAAAAElFTkSuQmCC">&nbsp;Tapez ici les premières lettres du nom de la voie';
		window.document.getElementById("sig_adresse_adr_num_voie_check").innerHTML = '';
		window.document.getElementById("sig_adresse_adr_ens_nom_check").innerHTML = '';
		window.document.getElementById("sig_adresse_sous_adressage").innerHTML = '';
		window.document.getElementById("sig_adresse_cdpsru_check").innerHTML = '';
		window.document.getElementById("sig_adresse_lcomru_check").innerHTML = '';
		_sigAdresseDocumentForm.sig_adresse_adresse.value = '';
		_sigAdresseDocumentForm.sig_adresse_id_adr_location.value = '';
		
		if (display_input == false)
		{
			document.getElementById('sig_adresse_adr_num_voie').style.display = 'none';
			document.getElementById('sig_adresse_adr_ens_nom').style.display = 'none';
			document.getElementById('sig_adresse_sous_adressage').style.display = 'none';
			document.getElementById('sig_adresse_cdpsru').style.display = 'none';
			document.getElementById('sig_adresse_lcomru').style.display = 'none';
		}
		
		tooltip.init();
		_sigAdresseDocumentForm.sig_adresse_adresse.focus();
	}
}

function sigAdresseVerifAdrNumVoie(forceTouteVoie)
{
	var force = 1;
	if (!forceTouteVoie)
	{
		force = 0;
	}
	var cdruru = _sigAdresseDocumentForm.sig_adresse_cdruru.value;
	var adr_num_voie = _sigAdresseDocumentForm.sig_adresse_adr_num_voie.value;
	if (adr_num_voie != '')
	{
		document.getElementById("sig_adresse_adr_num_voie_check").innerHTML = '<span class="r"><img src="' + _sigAdresseImageLoading + '">&nbsp;Veuillez patienter... R&eacute;cup&eacute;ration des Sous-Adressage en cours...</span>';
		document.getElementById('sig_adresse_sous_adressage').innerHTML = '';
		//var xmlhttp = getHTTPObject();
		//xmlhttp.open("GET", "index.php?P=SIGADRNUMERO&cdruru=" + cdruru + "&adr_num_voie=" + adr_num_voie + "&force=" + force, true);
		//xmlhttp.send(null);
		sigAdresseInitXmlHttp();
		_sigAdresseXmlHttp.open("GET", _sigAdresseAdresseRecherche + "?P=SIGADRNUMERO&cdruru=" + cdruru + "&adr_num_voie=" + adr_num_voie + "&force=" + force, true);
		
		_sigAdresseXmlHttp.onreadystatechange = function()
        {
            if (_sigAdresseXmlHttp.readyState == 4 && _sigAdresseXmlHttp.responseText)
            {
				eval(_sigAdresseXmlHttp.responseText);
            }
        };
        
		_sigAdresseXmlHttp.send(null);
	}
}

function sigAdresseVerifEnsemble()
{
	var force = 1;
	var cdruru = _sigAdresseDocumentForm.sig_adresse_cdruru.value;
	var adr_ens_nom = _sigAdresseDocumentForm.sig_adresse_adr_ens_nom.value;
	if (adr_ens_nom != '')
	{
		document.getElementById("sig_adresse_adr_ens_nom_check").innerHTML = '<span class="r"><img src="' + _sigAdresseImageLoading + '">&nbsp;Veuillez patienter... R&eacute;cup&eacute;ration des Sous-Adressage en cours...</span>';
		document.getElementById('sig_adresse_sous_adressage').innerHTML = '';
		//var xmlhttp = getHTTPObject();
		//xmlhttp.open("GET", "index.php?P=SIGADRSOUSADRESSE&cdruru="+cdruru+"&adr_ens_nom="+adr_ens_nom+"&force="+force,true);
		//xmlhttp.send(null);
		sigAdresseInitXmlHttp();
		_sigAdresseXmlHttp.open("GET", _sigAdresseAdresseRecherche + "?P=SIGADRSOUSADRESSE&cdruru="+cdruru+"&adr_ens_nom="+adr_ens_nom+"&force="+force, true);
		_sigAdresseXmlHttp.send(null);
	}
}

function sigAdresseLoadInfoVoie(id_bati_adr, adr_num, cdpsru, lcomru, adr_ens_nom, txtadr, idadrloc)
{
	//_sigAdresseDocumentForm.sig_adresse_id_bati_adr.value = id_bati_adr;
	_sigAdresseDocumentForm.sig_adresse_cdpsru.value = cdpsru;
	_sigAdresseDocumentForm.sig_adresse_lcomru.value = lcomru;
	_sigAdresseDocumentForm.sig_adresse_adr_num_voie.value = adr_num;
	_sigAdresseDocumentForm.sig_adresse_adr_ens_nom.value = adr_ens_nom;
	//_sigAdresseDocumentForm.sig_adresse_id_adr_location_new.value = idadrloc;
	_sigAdresseDocumentForm.sig_adresse_id_adr_location.value = idadrloc;
	document.getElementById('sig_adresse_cdpsru').style.display = 'block';
	document.getElementById('sig_adresse_lcomru').style.display = 'block';
	window.document.getElementById("sig_adresse_sous_adressage").innerHTML = txtadr;
	window.document.getElementById("sig_adresse_adr_ens_nom_check").innerHTML = '<img align=absbottom src="' + _sigAdresseImageOk + '">';
	window.document.getElementById("sig_adresse_cdpsru_check").innerHTML = '<img align=absbottom src="' + _sigAdresseImageOk + '">';
	window.document.getElementById("sig_adresse_lcomru_check").innerHTML = '<img align=absbottom src="' + _sigAdresseImageOk + '">';
}

if (tooltip == undefined)
{

//Coded by Travis Beckham
//Heavily modified by Craig Erskine
//extended to TagName img & input by reddog (and little personal tip)
var tooltip =
{
	name : 'tooltipDiv',
	offsetX : -10,
	offsetY : 11,
	tip : null
};
var viewport = {
	getWinWidth: function () {
		this.width = 0;
		if (window.innerWidth) this.width = window.innerWidth - 18;
		else if (document.documentElement && document.documentElement.clientWidth)
			this.width = document.documentElement.clientWidth;
		else if (document.body && document.body.clientWidth)
			this.width = document.body.clientWidth;
	},
	getWinHeight: function () {
		this.height = 0;
		if (window.innerHeight) this.height = window.innerHeight - 18;
		else if (document.documentElement && document.documentElement.clientHeight)
			this.height = document.documentElement.clientHeight;
		else if (document.body && document.body.clientHeight)
			this.height = document.body.clientHeight;
	},
	getScrollX: function () {
		this.scrollX = 0;
		if (typeof window.pageXOffset == "number") this.scrollX = window.pageXOffset;
		else if (document.documentElement && document.documentElement.scrollLeft)
			this.scrollX = document.documentElement.scrollLeft;
		else if (document.body && document.body.scrollLeft)
			this.scrollX = document.body.scrollLeft;
		else if (window.scrollX) this.scrollX = window.scrollX;
	},
	getScrollY: function () {
		this.scrollY = 0;
		if (typeof window.pageYOffset == "number") this.scrollY = window.pageYOffset;
		else if (document.documentElement && document.documentElement.scrollTop)
			this.scrollY = document.documentElement.scrollTop;
		else if (document.body && document.body.scrollTop)
			this.scrollY = document.body.scrollTop;
		else if (window.scrollY) this.scrollY = window.scrollY;
	},
	getAll: function () {
		this.getWinWidth(); this.getWinHeight();
		this.getScrollX(); this.getScrollY();
	}
};
tooltip.init = function ()
{
	var tipNameSpaceURI = 'http://www.w3.org/1999/xhtml';
	if (!tipContainerID)
	{
		var tipContainerID = 'tooltipDiv';
	}
	var tipContainer = document.getElementById(tipContainerID);
	if(!tipContainer)
	{
		tipContainer = document.createElementNS ? document.createElementNS(tipNameSpaceURI, 'div') : document.createElement('div');
		tipContainer.setAttribute('id', tipContainerID);
		tipContainer.style.display = 'none';
		document.getElementsByTagName('body').item(0).appendChild(tipContainer);
	}
	if (!document.getElementById) return;
	this.tip = document.getElementById (this.name);
	if (this.tip) document.onmousemove = function (evt)
	{
		tooltip.move (evt)
	};
	var a, sTitle;
	var anchors = document.getElementsByTagName('a');
	for (var i = 0; i < anchors.length; i ++)
	{
		a = anchors[i];
		sTitle = a.getAttribute('title');
		if (sTitle) {
			a.setAttribute('tiptitle', sTitle);
			a.removeAttribute('title');
			a.removeAttribute('alt');
			a.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle'))};
			a.onmouseout = function() {tooltip.hide()};
		}
	}
	//extended to img TagName by reddog
	var img, iTitle, iClass;
	var anchors = document.getElementsByTagName('img');
	for (var i = 0; i < anchors.length; i ++)
	{
		img = anchors[i];
		iTitle = img.getAttribute('title');
		iClass = (document.all) ? img.getAttribute('className') : img.getAttribute('class');
		if(iTitle) {
			img.setAttribute('tiptitle', iTitle);
			img.removeAttribute('title');
			img.removeAttribute('alt');
			//ensure gradual shine compliancy (reddog)
			if (iClass == 'gradualshine')
			{
				img.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle')); slowhigh(this);};
				img.onmouseout = function() {tooltip.hide(); slowlow(this);};
			}
			else
			{
				img.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle'))};
				img.onmouseout = function() {tooltip.hide()};
			}
		}
	}
	//extended to img TagName by MarinJC
	var img, iTitle, iClass;
	var anchors = document.getElementsByTagName('td');
	for (var i = 0; i < anchors.length; i ++)
	{
		img = anchors[i];
		iTitle = img.getAttribute('title');
		iClass = (document.all) ? img.getAttribute('className') : img.getAttribute('class');
		if(iTitle) {
			img.setAttribute('tiptitle', iTitle);
			img.removeAttribute('title');
			img.removeAttribute('alt');
			//ensure gradual shine compliancy (reddog)
			if (iClass == 'gradualshine')
			{
				img.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle')); slowhigh(this);};
				img.onmouseout = function() {tooltip.hide(); slowlow(this);};
			}
			else
			{
				img.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle'))};
				img.onmouseout = function() {tooltip.hide()};
			}
		}
	}
	//extended to div TagName by MarinJC
	var img, iTitle, iClass;
	var anchors = document.getElementsByTagName('div');
	var ch = '';
	for (var i = 0; i < anchors.length; i ++)
	{
		img = anchors[i];
		iTitle = img.getAttribute('title');
		iClass = (document.all) ? img.getAttribute('className') : img.getAttribute('class');
		if(iTitle) {
			img.setAttribute('tiptitle', iTitle);
			img.removeAttribute('title');
			img.removeAttribute('alt');
			//ensure gradual shine compliancy (reddog)
			if (iClass == 'gradualshine')
			{
				img.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle')); slowhigh(this);};
				img.onmouseout = function() {tooltip.hide(); slowlow(this);};
			}
			else if (iClass == 'Onglet')
			{
				if (document.all) // IE
				{
					img.onmouseover = function() {this.className='OngletSelected';this.style.cursor='hand';tooltip.show(this.getAttribute('tiptitle'));};
					img.onmouseout = function() {tooltip.objetSurvole=null;this.className='Onglet';tooltip.hide()};
				}
				else // Firefox
				{
					img.setAttribute('onmouseover', 'this.className=\'OngletSelected\';this.style.cursor=\'pointer\';tooltip.show(this.getAttribute(\'tiptitle\'));');
					img.setAttribute('onmouseout', 'this.className=\'Onglet\';tooltip.hide();');
				}
			}
			else
			{
				img.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle'))};
				img.onmouseout = function() {tooltip.hide()};
			}
		}
	}
	//extended to input TagName by reddog
	var nput, nTitle;
	var anchors = document.getElementsByTagName('input');
	for (var i = 0; i < anchors.length; i ++)
	{
		nput = anchors[i];
		nTitle = nput.getAttribute('title');
		if(nTitle)
		{
			nput.setAttribute('tiptitle', nTitle);
			nput.removeAttribute('title');
			nput.removeAttribute('alt');
			nput.onmouseover = function() {tooltip.show(this.getAttribute('tiptitle'))};
			nput.onmouseout = function() {tooltip.hide()};
		}
	}
};
tooltip.move = function (evt)
{
	var x=0, y=0;
	if (document.all)
	{ // IE
		x = (document.documentElement && document.documentElement.scrollLeft) ? document.documentElement.scrollLeft : document.body.scrollLeft;
		y = (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop : document.body.scrollTop;
		x += window.event.clientX;
		y += window.event.clientY;
	}
	else
	{ // Mozilla
		x = evt.pageX;
		y = evt.pageY;
	}
	viewport.getAll();
	if ( x + this.tip.offsetWidth + this.offsetX > viewport.width + viewport.scrollX )
		x = x - this.tip.offsetWidth - this.offsetX;
	else x = x + this.offsetX;
		if ( y + this.tip.offsetHeight + this.offsetY > viewport.height + viewport.scrollY )
			y = ( y - this.tip.offsetHeight - this.offsetY > viewport.scrollY )? y - this.tip.offsetHeight - this.offsetY - 6 : viewport.height + viewport.scrollY - this.tip.offsetHeight;
		else y = y + this.offsetY;
	this.tip.style.left = (x + this.offsetX) + 'px';
	this.tip.style.top = (y + this.offsetY) + 'px';
	//this.tip.innerHTML = (x + this.offsetX) + 'px x ' + (y + this.offsetY) + 'px';
};
tooltip.show = function (text)
{
	if (!this.tip) return;
	this.tip.innerHTML = text;
	this.tip.style.visibility = 'visible';
	this.tip.style.display = 'block';
};
tooltip.hide = function ()
{
	if (!this.tip) return;
	this.tip.style.visibility = 'hidden';
	this.tip.style.display = 'none';
	this.tip.innerHTML = '';
};

window.onload = function ()
{
	tooltip.init ();
}

}