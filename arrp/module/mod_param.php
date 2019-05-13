<?php
$BOUTTONS = array();
$BOUTTONS[] = array(
                    'ACTION' => "javascript:window.location='index.php?P=1';",
                    'TXT' => 'Retour',
                    'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-back.png',
                    'TITLE' => 'Retour',
                   );
$page->afficheHeader();
?>
<div class="row-fluid">
        
<div id="page-content" class="page-content">
    <section>
    <div class="row-fluid">
            
    <div class="span2">
    <?php include ('./module/mod_param_menu.php'); ?>
    </div>    
    
    <div class="span9">
        
         
            

    </div>
    </div>
    </section>
</div>
</div>
<?
$page->afficheFooter();
?>