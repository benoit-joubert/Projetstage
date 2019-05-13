$(function(){
    // control-mode. control for top and side mode (fixed or normal), you can remove it if you want..
    var control_panel_right = '<div class="control-panel-right" id="control-panel-right">'
    +'    <div class="navigate-mode"><a href="#" class="grd-purple-dark corner-left"><i id="btn-control-panel-right" class="typicn-left color-white"></i></a></div>'
    +'    <ul class="choice-mode grd-black corner-bl hide">'
    +'        <li>aaa</li>'
    +'        <li>bbb</li>'
    +'    </ul>'
    +'</div>';
    //+'    <div class="navigate-mode"><a href="#" class="grd-teal corner-bottom"><i class="typicn-cog"></i></a></div>'
    
    $('body').append(control_panel_right);
    
    if(sessionStorage.panelRight == undefined)
    {
        sessionStorage.panelRight = 'close';
    }
    
    
    $('#control-panel-right > .navigate-mode').click(function(e)
    {
//        $('#control-panel-right > .choice-mode').slideToggle(); // toggle slide hide
        $('#panel-right-content').slideToggle(); // toggle slide hide
        
        //alert($('#panel-right-content').attr('class'));
        
        if ($('#panel-right-content').attr('class') == 'span2')
        {
        	$('#content-contenair').removeClass('span9');
        	$('#panel-right-content').removeClass('span2');
        	$('#content-contenair').addClass('span11');
        	$('#btn-control-panel-right').removeClass('typicn-right');
        	$('#btn-control-panel-right').addClass('typicn-left');
        	sessionStorage.panelRight = 'close';
        	
        }
        else if ($('#panel-right-content').attr('class') == 'span2 hide')
        {
        	$('#content-contenair').removeClass('span11');
        	$('#content-contenair').addClass('span9');
        	$('#panel-right-content').addClass('span2');
        	$('#panel-right-content').removeClass('hide');
        	$('#btn-control-panel-right').removeClass('typicn-left');
        	$('#btn-control-panel-right').addClass('typicn-right');
        	sessionStorage.panelRight = 'open';
        	
        }
        else
        {
        	
        	$('#content-contenair').removeClass('span11');
        	$('#content-contenair').addClass('span9');
        	$('#panel-right-content').addClass('span2');
        	$('#btn-control-panel-right').removeClass('typicn-left');
        	$('#btn-control-panel-right').addClass('typicn-right');
        	sessionStorage.panelRight = 'open';
        	
        }
        return false;
    });
    
    if(sessionStorage.panelRight)
    {
        if(sessionStorage.panelRight == 'open')
        {
        	$('#content-contenair').removeClass('span11');
        	$('#content-contenair').addClass('span9');
        	$('#panel-right-content').addClass('span2');
        	$('#panel-right-content').removeClass('hide');
        	$('#btn-control-panel-right').removeClass('typicn-left');
        	$('#btn-control-panel-right').addClass('typicn-right');
        }
    }
});
