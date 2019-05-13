<?php
include("xmpp.php");
$conn = new XMPP('10.128.10.17', 5222, 'gpi', 'gpipassword', 'xmpphp', '10.128.10.17', $printlog=True, $loglevel=LOGGING_INFO);
$conn->connect();
$conn->processUntil('session_start');

$message =  'Bonjour Sandrine,'."\n"."\n".
            'Ceci est un message automatique afin de te prévenir prévenir d\'un évènement important...'."\n"."\n".
            'Laurent vient de t\'affecter une nouvelle intervention...'."\n"."\n".
            'Clique ici pour la consulter : '."\n".
            'http://gpi.prod.intranet/index.php?P=1400&action=modifier&intervention_id=3';

$conn->message('marinjc@10.128.10.17', utf8_encode($message));
//$conn->message('goulees@10.128.10.17', utf8_encode($message));
//
//$message =  'Bonjour Laurent,'."\n"."\n".
//            'Ceci est un message automatique afin de te prévenir prévenir d\'un évènement important...'."\n"."\n".
//            'Sandrine vient de t\'affecter une nouvelle intervention...'."\n"."\n".
//            'Clique ici pour la consulter : '."\n".
//            'http://gpi.prod.intranet/index.php?P=1400&action=modifier&intervention_id=3';
//            
//$conn->message('cattierl@10.128.10.17', utf8_encode($message));
//$conn->message('kempffe@10.128.10.17', utf8_encode($message));
$conn->presence('', 'available', 'marinjc');
//$conn->message('marinjc@10.128.10.17', 'nouve rzezrze');
//print_r($conn);
//sleep(10);
$conn->disconnect();

?>
