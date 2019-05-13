
<?php
if(isset($_POST['P']))
    $P = $_POST['P'];
elseif(isset($_GET['P']))
    $P = $_GET['P'];
else
    $P = '0';

$TAB = array(
                '801'  =>  array(
                                    'PARAM' =>  'type=INTERLOCUTEUR',
                                    'LIB'   => 'Interlocuteurs',
                                    'IMG'   =>  'user_headset_32.png',
                                ),
                '802'  =>  array(
                                    'PARAM' =>  'type=ATTESTANT',
                                    'LIB'   => 'Attestants',
                                    'IMG'   =>  'user1_32.png',
                                ),
                '803'  =>  array(
                                    'PARAM' =>  'type=SIGNATAIRE',
                                    'LIB'   => 'Signataires',
                                    'IMG'   =>  'pen_blue_32.png',
                                ),
                '804'  =>  array(
                                    'PARAM' =>  '',
                                    'LIB'   => 'Courrier entête',
                                    'IMG'   =>  'document_new_32.png',
                                ),
                /*
                '805'  =>  array(
                                    'PARAM' =>  '',
                                    'LIB'   => 'Courrier NOTA',
                                    'IMG'   =>  'gear.png',
                                ),
                '806'  =>  array(
                                    'PARAM' =>  '',
                                    'LIB'   => 'Courrier bas de page',
                                    'IMG'   =>  'gear.png',
                                ),
                */
             );

echo '<div class="toolbar-list">';
    echo '<ul>';
        foreach ($TAB as $k => $v){
            echo '<li class="button"><a tiptitle="' . $v['LIB'] . '" href="./index.php?P=' . $k . '&' . $v['PARAM'] . '" ><span style="background-image: url(' . $GENERAL_URL . '/images/' . $v['IMG'] . ');"></span>' . $v['LIB'] . '</a></li>';
        }
    echo '</ul>';
echo '</div>';