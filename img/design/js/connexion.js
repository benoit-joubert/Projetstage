var timerPoint = null;
/* HTTP REQUEST */
function getHTTPObject()
{
  var xmlhttp = false;

  /* Compilation conditionnelle d'IE */
  /*@cc_on
  @if (@_jscript_version >= 5)
     try
     {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
     }
     catch (e)
     {
        try
        {
           xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (E)
        {
           xmlhttp = false;
        }
     }
  @else
     xmlhttp = false;
  @end @*/

  /* on essaie de créer l'objet si ce n'est pas déjà fait */
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined')
  {
     try
     {
        xmlhttp = new XMLHttpRequest();
     }
     catch (e)
     {
        xmlhttp = false;
     }
  }

  if (xmlhttp)
  {
     /* on définit ce qui doit se passer quand la page répondra */
     /*
     xmlhttp.onreadystatechange=function()
     {
        if (xmlhttp.readyState == 4) // 4 : état "complete"
        {
           if (xmlhttp.status == 200) // 200 : code HTTP pour OK
           {
              
              //Traitement de la réponse.
              //Ici on affiche la réponse dans une boîte de dialogue.
              
              
              alert(xmlhttp.responseText);
              
              //eval(xmlhttp.responseText);
           }
        }
     }
     */
  }
  return xmlhttp;
}


// Mets le focus sur le champs user ou sur le champs password
function focusOnUserOrPassword()
{
//    alert(window.document.getElementById('agent_login').value);
    if (window.document.getElementById('agent_login').value == '')
    {
        window.document.getElementById('agent_login').focus();
    }
    else
    {
        window.document.getElementById('agent_password').focus();
    }
    
//    self.focus();
}

// Se connecte
function connexion()
{
    document.formconnexion.agent_password.blur();
    document.formconnexion.boutton.style.visibility='hidden';
//    setInfo('<img align=absbottom src=\'http://design.prod.intranet/design/connexion/about.gif\'>&nbsp;Connexion en cours... <strong>Veuillez patientez</strong>...');
    
    var xmlhttp = getHTTPObject();
    xmlhttp.onreadystatechange=function()
     {
        if (xmlhttp.readyState == 4) /* 4 : état "complete" */
        {
           if (xmlhttp.status == 200) /* 200 : code HTTP pour OK */
           {
              clearTimeout(timerPoint); // Arret du timer point
              eval(xmlhttp.responseText);
           }
        }
     }
     
//    xmlhttp.onreadystatechange=function()
//    {
//        if (xmlhttp.readyState == 4) // 4 : état "complete"
//        {
//            var statusChargement = 0;
//            try
//            {
//                statusChargement = xmlhttp.status;
//            }
//            catch (e)
//            {
//                //afficheMessage("Erreur: Le serveur de recherche est injoignable. Veuillez ressayer dans quelques minutes! Merci!", 5000, "color:red", "chrome://intrasearch/skin/warning.png");
//                //playSound('error.wav');
//                //setInfo('<font color=red><strong>ERREUR</strong></font>', 1);
//            }
//            if (statusChargement == 200) // 200 : code HTTP pour OK
//            {
//                //setInfo('<font color=green><strong>OK</strong></font>', 1);
//                clearTimeout(timerPoint); // Arret du timer point
//                eval(xmlhttp.responseText);
//                //alert(xmlhttp.responseText);
//                
//                //activeLoadingRecherche(false);
//                //var nbResultXML = xmlhttp.responseXML.getElementsByTagName('nb_resultat');
//                //alert(nbResult[0].nodeValue);
//                //var nbResult = nbResultXML[0].firstChild.nodeValue;
//            }
//        }
//    }
    //setInfo('<br><br>&nbsp;Requete au serveur de connexion en cours... ', 1);
    xmlhttp.open("POST", "index.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    
    
//    setTimeout('setInfo(\'&nbsp;<font color=green><strong>OK</strong></font>\', 1);clearTimeout(timerPoint);', 200);
//    
//    setTimeout('setInfo(\'<br><br>&nbsp;Authentification du compte <strong>'+ document.formconnexion.agent_login.value +'</strong>...\', 1);affichePoint();', 300);

//    setInfo('<br><br><div id=progressbar></div>', 1);
//    
//    setInfo('<br><br><span class="status" id="p3text">&nbsp;Requete au serveur de connexion en cours...</span>', 1);
    
//    window.document.getElementById('progressbar').innerHTML = '';
//    window.document.getElementById('progressbar').style.visibility = 'visible';
    
    window.document.getElementById('progressbar').innerHTML = '<table><tr><td><img align=absbottom src=\'http://web1.intranet/img/design/connexion/loading.png\'></td><td>&nbsp;<b>Authentification</b> en cours...</td></tr></table>';
    
    /*
    var pbar3 = new Ext.ProgressBar({
        id:'pbar3',
        width:270,
        renderTo:'progressbar'
    });
    
    
    pbar3.on('update', function(val){
        //You can handle this event at each progress interval if
        //needed to perform some other action
        //Ext.fly('p3text').dom.innerHTML += '.';
    });
    
    
    Ext.fly('p3text').update('Requete au serveur de connexion en cours...');
    
    pbar3.wait({
        interval:200,
        duration:120000,
        increment:15,
        fn:function(){
            btn3.dom.disabled = false;
            Ext.fly('p3text').update('Done');
        }
    });
    */
    //affichePoint();
    
    // Variables soumise en POST
    var varPosts = "P=C_AJAX_REPONSE";
    varPosts += "&action="+document.formconnexion.action.value;
    varPosts += "&agent_login="+document.formconnexion.agent_login.value;
    varPosts += "&agent_password="+document.formconnexion.agent_password.value;
    xmlhttp.send(varPosts);
    
    return false;
}

function loadUrl(urlACharger)
{
    window.location.href = urlACharger;
}

function affichePoint()
{
    setInfo('.', 1);
    timerPoint = setTimeout('affichePoint()', 200);
}

function setInfo(ch, add)
{
    if (add == 1)
    {
        ch = window.document.getElementById('info').innerHTML + ch;
    }
    window.document.getElementById('info').innerHTML = ch;
    window.document.getElementById('info').style.visibility = 'visible';
}

function setInfo2(ch, add)
{
    if (add == 1)
    {
        ch = window.document.getElementById('p3text').innerHTML + ch;
    }
    window.document.getElementById('p3text').innerHTML = ch;
    window.document.getElementById('p3text').style.visibility = 'visible';
}

function cacheInfo()
{
    window.document.getElementById('info').style.visibility = 'hidden';
}