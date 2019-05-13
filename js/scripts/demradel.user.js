// ==UserScript==
// @name            DEMRADEL
// @namespace       http://smerope.intranet:8280/delib/
// @description     Amelioration du rendu DEMRADEL en affichant les types des rapports en dessous de l'image R du rapport.
// @version         1.3
// @date            2010-09-29
// @include         http://smerope.intranet:8*80/delib/*
// ==/UserScript==

(function ()
{
    GM_log('Lancement Script DEMRADEL');
    
    GM_log('['+window.location.href+']');
    
    var allLinks, thisLink, newElement, typ, typText;
    
    allLinks = document.evaluate(
    "//a[@target='main']",
    document,
    null,
    XPathResult.UNORDERED_NODE_SNAPSHOT_TYPE,
    null);
    
    GM_log(allLinks.snapshotLength + ' liens trouvées');
    
    for (var i = 0; i < allLinks.snapshotLength; i++)
    {
        thisLink = allLinks.snapshotItem(i);
        
//        if (thisLink.href.indexOf ('http://smerope.intranet:8280/delib/servlet/FramesReportServlet?seanceId=') == -1)
//        {
//            if (thisLink.href.indexOf ('http://smerope.intranet:8180/delib/servlet/FramesReportServlet?seanceId=') == -1)
//                continue;
//        }

        typ = thisLink.href.match(/reportAction=MODIFY&reportType=(.*)&selectUserReport/i);
        
        if (!typ)
        {
            typ = thisLink.href.match(/reportAction=MODIFY&reportType=(.*)&taskId=/i);
            
            if (!typ)
                continue;
        }
        
        typText = unescape(String(typ[1]).replace(/\+/g, " "));
        
        if (typText == 'normal') continue;
        
        GM_log(thisLink.href);
        
        newElementSpan = document.createElement('span');
        if (typText == 'Rapport pour info')
            newElementSpan.style.color = "#708090"; // Bleu clair
        else if (typText == 'urgent')
            newElementSpan.style.color = "#FF0000"; // Rouge
        else
            newElementSpan.style.color = "#933B15"; // Marron foncé
        newElementSpan.style.fontWeight = "bold";
        
        newElement = document.createElement('small');
        newElement.appendChild (document.createElement('br'));
        newElement.appendChild (document.createTextNode('['+typText+']'));
        
        newElementSpan.appendChild (newElement);
        
        thisLink.parentNode.insertBefore(newElementSpan, thisLink.nextSibling);
    }
}
)();