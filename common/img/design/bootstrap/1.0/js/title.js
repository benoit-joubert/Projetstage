// gradual highlight from dynamic drive 
var baseopacity = 30;

function slowhigh(which2)
{
	imgobj = which2;
	browserdetect = typeof(which2.style.MozOpacity == 'string') ? 'mozilla' : '';
	instantset(baseopacity);
	highlighting = setInterval('gradualfade(imgobj)', 50);
}

function slowlow(which2)
{
	cleartimer();
	instantset(baseopacity);
}

function instantset(degree)
{
	if (browserdetect == 'mozilla')
	{
		imgobj.style.MozOpacity = degree/100;
	}
}

function cleartimer()
{
	if (window.highlighting)
	{
		clearInterval(highlighting);
	}
}

function gradualfade(cur2)
{
	if (browserdetect == 'mozilla' && cur2.style.MozOpacity < 1)
	{
		cur2.style.MozOpacity = Math.min(parseFloat(cur2.style.MozOpacity)+0.1, 0.99);
	}
	else if (window.highlighting)
	{
		clearInterval(highlighting);
	}
}

// Coded by Travis Beckham
// Heavily modified by Craig Erskine
// extended to TagName img & input by reddog (and little personal tip)
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
    this.getScrollX();  this.getScrollY();
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

	// extended to img TagName by reddog
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

			// ensure gradual shine compliancy (reddog)
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
	
	// extended to img TagName by MarinJC
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

			// ensure gradual shine compliancy (reddog)
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
	
	// extended to div TagName by MarinJC
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

			// ensure gradual shine compliancy (reddog)
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


	// extended to input TagName by reddog
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