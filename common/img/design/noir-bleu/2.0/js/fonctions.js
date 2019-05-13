function checkOrUncheckAll(f, inputName)
{
    if (!inputName)
    {
        inputName = 'cb';
    }
	//var f = document.formName;
	var c = f.toggle.checked;
	
	
	var divs;
    var divCourant;
    var j=0;
    divs = document.getElementsByTagName('*');
    
    for ( var i=0; i < divs.length; i++ )
    {
        divCourant = divs[i];
        if ( divCourant.tagName == 'INPUT' && divCourant.getAttribute("name") && divCourant.getAttribute("name").indexOf(inputName) > -1)
        {
            divCourant.checked = c;
        }
    }
}