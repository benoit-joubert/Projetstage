<?
 /**
 * @package common
 */
 
 /**
  * Classe générant des erreurs afin qu'elles puissent être envoyées par email ou affichées
  * 
  */
class Erreur
{
    
    function getNiceHtml($ch)
    {
        $ch = str_replace("\n",'<br>',$ch);
        $ch = str_replace(" ",'&nbsp;',$ch);
        $ch = str_replace('Array', '<span class="t">Array</span>', $ch);
        $ch = str_replace('[', '[<span class="index">', $ch);
        $ch = str_replace(']', '</span>]', $ch);
        //$ch = str_replace('Array', '<span class="t">Array</span>', $ch);
        return $ch;
    }

    function __construct($titreErreur, $libErreur, $sendEmail = false)
    {
        $this->Erreur($titreErreur, $libErreur, $sendEmail);
    }

     /**
      * Constructeur de l'objet Erreur
      * 
      * @param string Titre de l'erreur
      * @param string Libellé de l'erreur
      * @param boolean indique si oui ou non on souhaite envoyer un mail au développeur du projet<br>
      * le mail est automatiquement envoyé quand on est en production
      */
    function Erreur($titreErreur, $libErreur, $sendEmail = false)
    {
        global $PROD, $_POST, $_GET, $_SESSION, $_SERVER;
        
        if (!(isset($_SERVER['WINDIR']) && $_SERVER['WINDIR'] != '')) // on est sur linux
            $titreErreur = utf8_decode($titreErreur);
        
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']:'inconnu';
        $post2 = $_POST;
        ob_start();
        if (isset($post2['agent_password']))
            $post2['agent_password'] = str_repeat('*', strlen($post2['agent_password']));
        if (isset($post2['utilisateur_password']))
            $post2['utilisateur_password'] = str_repeat('*', strlen($post2['utilisateur_password']));
        print_r($post2);
        $post = ob_get_contents();
        $postHTML = $this->getNiceHtml($post);
        ob_end_clean();
        
        ob_start();
        print_r($_GET);
        $get = ob_get_contents();
        $getHTML = $this->getNiceHtml($get);
        ob_end_clean();
        
        ob_start();
        print_r($_SESSION);
        $session = ob_get_contents();
        $sessionHTML = $this->getNiceHtml($session);
        ob_end_clean();
        
        ob_start();
        print_r($_FILES);
        $files = ob_get_contents();
        $filesHTML = $this->getNiceHtml($files);
        ob_end_clean();
        
        ob_start();
        print_r($_COOKIE);
        $cookies = ob_get_contents();
        $cookiesHTML = $this->getNiceHtml($cookies);
        ob_end_clean();
        
        ob_start();
        print_r($_SERVER);
        $servers = ob_get_contents();
        $serverHTML = $this->getNiceHtml($servers);
        ob_end_clean();
        
        $debugBacktrace = debug_backtrace();
        
        // Message HTML
        $mess = '<font face="verdana" size="1">Une erreur s\'est produite sur le projet <font color="#FF0000">'.PROJET_NAME.'</font>'.
                ' présent sur le serveur <font color="#FF0000">'.$_SERVER['SERVER_NAME'].'</font> '.
                'le <font color="#FF0000">' . date('d/m/Y à H:i:s',time()) . '</font><br><br>';
        $mess .= '<b>Détails sur l\'erreur</b> : <br><br>';
        $mess .= '- <font color="#FF0000">Message</font> : ' . $libErreur . '<br>';
        $mess .= '- <font color="#FF0000">IP</font> : ' . $_SERVER['REMOTE_ADDR'] . '<br>';
        $mess .= '- <font color="#FF0000">Hostname</font> : ' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . '<br>';
        $mess .= '- <font color="#FF0000">User Agent</font> : ' . $_SERVER['HTTP_USER_AGENT'] . '<br>';
        $mess .= '- <font color="#FF0000">Adresse référente</font> : ' . $referer . '<br>';
        $mess .= '- <font color="#FF0000">Requete</font> : ' . $_SERVER['REQUEST_URI'] . '<br>';
        
        $mess .= '- <font color="#FF0000">Variable(s) en POST</font> : ' . $postHTML . '<br>';
        $mess .= '- <font color="#FF0000">Variable(s) en GET</font> : ' . $getHTML . '<br>';
        $mess .= '- <font color="#FF0000">Variable(s) en SESSION</font> : ' . $sessionHTML . '<br>';
        $mess .= '- <font color="#FF0000">Variable(s) en FILES</font> : ' . $filesHTML . '<br>';
        
        $mess .= '</font>';
        
        // Message Texte
        $messTxt = 'Cet Email a été envoyé au format HTML. Afin de le visualiser, veuillez cliquer sur le menu Afficher (en haut), puis sur HTML.'."\n\n";
        
        $messTxt .= 'Une erreur s\'est produite sur le projet '.PROJET_NAME."\r\n".
                ' présent sur le serveur '.$_SERVER['SERVER_NAME'].' '.
                'le ' . date('d/m/Y à H:i:s',time()) . ''."\r\n"."\r\n";
        $messTxt .= '<b>Détails sur l\'erreur</b> : '."\r\n";
        $messTxt .= '- Message: ' . $libErreur . "\r\n";
        $messTxt .= '- IP: ' . $_SERVER['REMOTE_ADDR'] . "\r\n";
        $messTxt .= '- Hostname: ' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "\r\n";
        $messTxt .= '- User Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
        $messTxt .= '- Adresse référente: ' . $referer . "\r\n";
        $messTxt .= '- Requete: ' . $_SERVER['REQUEST_URI'] . "\r\n";
        
        $messTxt .= '- Variable(s) en POST: ' . $post . "\r\n";
        $messTxt .= '- Variable(s) en GET: ' . $get . "\r\n";
        $messTxt .= '- Variable(s) en SESSION: ' . $session . "\r\n";
        $messTxt .= '- Variable(s) en FILES: ' . $files . "\r\n";
        
        
        $messHTML =     '<html>'.
                        '<head>'.
                        '<style>'.
                        'A:visited {COLOR: #777777; TEXT-DECORATION: none}A:hover {COLOR: #FFA13E; TEXT-DECORATION: none}A {COLOR: #777777;TEXT-DECORATION: none}
                        body,td
                        {
                            FONT-FAMILY: Verdana, Arial, sans-serif, Geneva;
                            FONT-SIZE: 10px;
                            COLOR: #202020;
                        }
                        
                        body
                        {
                            background: url("http://design.prod.intranet/design/gradient.php?base=F1CEAB&height=1000&uid=1&mid=25&mode=web") repeat-x;
                            background-color:#F1CEAB;
                        }
                        table.tableau
                        {
                            border-spacing: 0;
                            border-collapse: collapse;
                        }
                        
                        table.tableau td
                        {
                            border: 1px solid black;
                            padding-left: 3px;
                            padding-right: 3px;
                        }
                        td.messageaction0
                        {
                            background: #FD5C31 url("http://design.prod.intranet/design/gradient.php?base=FD5C31&height=15") repeat-x;
                            border: 1px solid black;
                            padding-left: 3px;
                            padding-right: 3px;
                        }
                        td.messageaction1
                        {
                            background: #7171BD url("http://design.prod.intranet/design/gradient.php?base=7171BD&height=15") repeat-x;
                            border: 1px solid black;
                            padding-left: 3px;
                            padding-right: 3px;
                        }
                        td.messageaction2
                        {
                            background: #FDA931 url("http://design.prod.intranet/design/gradient.php?base=FDA931&height=15") repeat-x;
                            border: 1px solid black;
                            padding-left: 3px;
                            padding-right: 3px;
                        }
                        .s
                        {
                            FONT-FAMILY: Verdana, Arial, sans-serif, Geneva;
                            FONT-SIZE: 10px;
                            COLOR: #FF7301;
                            font-weight: bold;
                        }
                        .t
                        {
                            FONT-FAMILY: Verdana, Arial, sans-serif, Geneva;
                            FONT-SIZE: 10px;
                            COLOR: #364AAE;
                            font-weight: bold;
                        }
                        .index
                        {
                            FONT-FAMILY: Verdana, Arial, sans-serif, Geneva;
                            FONT-SIZE: 10px;
                            COLOR: #B21D04;
                        }'.
                        '</style>'.
                        '</head>'.
                        '<body>'.
                        '<table class="tableau">
                        <tr>
                            <td class="messageaction0" align="center" bgcolor="#f1cc67">
                                <font face="Verdana, Arial, sans-serif, Geneva" size="1"><strong>.: '.$titreErreur.' :.</strong></font>
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="left">
                        <p align="justify"><br>'.
                        '<strong>B</strong>onjour,<br><br><strong>U</strong>ne erreur s\'est produite sur le projet <span class="t">'.PROJET_NAME.'</span>'.
                        ' présent sur le serveur <span class="t">'.$_SERVER['SERVER_NAME'].'</span>.<br><br>'.
                        'Date de l\'erreur : <span class="t">' . date('d/m/Y', time()) .'</span> à <span class="t">'. date('H\Hi',time()) . '</span> et <span class="t">'. date('s',time()) . '</span> secondes.<br><br>'.
                        '</p>
                    </td>
                </tr>
            </table>
            <br>
            <table class="tableau" width="800">
                        <tr>
                            <td class="messageaction1" align="center" colspan="2" bgcolor="#f1cc67">
                                <font face="Verdana, Arial, sans-serif, Geneva" size="1"><strong>.: Informations sur le client & sur l\'erreur :.</strong></font>
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="right"><span class="t">Message :</span></td>
                            <td align="left">'. $titreErreur .'</td>
                        </tr>
                        <tr bgcolor="#FFFFCC">
                            <td align="right"><span class="t">Détails :</span></td>
                            <td align="left">'. $libErreur .'</td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="right"><span class="t">IP :</span></td>
                            <td align="left">'. $_SERVER['REMOTE_ADDR'] .'</td>
                        </tr>
                        <tr bgcolor="#FFFFCC">
                            <td align="right"><span class="t">Machine :</span></td>
                            <td align="left">'. gethostbyaddr($_SERVER['REMOTE_ADDR']) .'</td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="right"><span class="t">User Agent :</span></td>
                            <td align="left">'. $_SERVER['HTTP_USER_AGENT'] .'</td>
                        </tr>
                        <tr bgcolor="#FFFFCC">
                            <td align="right"><span class="t">Adresse référente :</span></td>
                            <td align="left">'. $referer .'</td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="right"><span class="t">Requete :</span></td>
                            <td align="left">'. $_SERVER['REQUEST_URI'] .'</td>
                        </tr>
                    </table>
                    <br>
                    <table class="tableau">
                        <tr>
                            <td class="messageaction2" align="center" bgcolor="#f1cc67">
                                <font face="Verdana, Arial, sans-serif, Geneva" size="1"><strong>.: Variables en _GET :.</strong></font>
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="left">
                            '.$getHTML.'
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="tableau">
                        <tr>
                            <td class="messageaction2" align="center" bgcolor="#f1cc67">
                                <font face="Verdana, Arial, sans-serif, Geneva" size="1"><strong>.: Variables en _POST :.</strong></font>
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="left">
                            '.$postHTML.'
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="tableau">
                        <tr>
                            <td class="messageaction2" align="center" bgcolor="#f1cc67">
                                <font face="Verdana, Arial, sans-serif, Geneva" size="1"><strong>.: Variables en _FILES :.</strong></font>
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="left">
                            '.($filesHTML == '' ? 'Aucun fichier uploadé':$filesHTML).'
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="tableau">
                        <tr>
                            <td class="messageaction2" align="center" bgcolor="#f1cc67">
                                <font face="Verdana, Arial, sans-serif, Geneva" size="1"><strong>.: Variables en _COOKIES :.</strong></font>
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="left">
                            '.($cookiesHTML == '' ? 'Aucun cookies':$cookiesHTML).'
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="tableau">
                        <tr>
                            <td class="messageaction2" align="center" bgcolor="#f1cc67">
                                <font face="Verdana, Arial, sans-serif, Geneva" size="1"><strong>.: Variables en _SESSION :.</strong></font>
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="left">
                            '.($sessionHTML == '' ? 'Aucune info en session':$sessionHTML).'
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="tableau" width="800">
                        <tr>
                            <td class="messageaction2" align="center" bgcolor="#f1cc67">
                                <font face="Verdana, Arial, sans-serif, Geneva" size="1"><strong>.: Variables en _SERVER :.</strong></font>
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="left">
                            '.($serverHTML == '' ? 'Aucune info...':$serverHTML).'
                            </td>
                        </tr>
                    </table>
                    <br>';
    
    if (is_array($debugBacktrace)
        && count($debugBacktrace) > 0)
    {
        foreach ($debugBacktrace as $i => $appel) {
            if ($i == 0) {
                continue;
            }
            
            if (isset($appel['function']) == true) {
                $function = $appel['function'];
            } else {
                $function = '';
            }
            
            if (isset($appel['line']) == true) {
                $line = $appel['line'];
            } else {
                $line = '';
            }
            
            if (isset($appel['file']) == true) {
                $file = $appel['file'];   
            } else {
                $file = '';
            }
            
            if (isset($appel['class']) == true) {
                $class = $appel['class'];
            } else {
                $class = '';
            }
            
            if (isset($appel['object']) == true) {
                $object = print_r($appel['object'], 1);
            } else {
                $object = '';
            }
            
            if (isset($appel['type']) == true) {
                $type = print_r($appel['type'], 1);
            } else {
                $type = '';
            }
            
            if (isset($appel['args']) == true) {
                $args = $appel['args'];
            } else {
                $args = '';
            }
            
            $messHTML .= '<table class="tableau" width="800" style="border-bottom: 1px solid #000000;">
                        <tr>
                            <td class="messageaction1" align="center" colspan="2" bgcolor="#f1cc67">
                                <font face="Verdana, Arial, sans-serif, Geneva" size="1"><strong>.: Appel de fonction / fichier no : '.($i).' :.</strong></font>
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="right"><span class="t">Fonction :</span></td>
                            <td align="left">'. $function .'</td>
                        </tr>
                        <tr bgcolor="#FFFFCC">
                            <td align="right"><span class="t">Ligne :</span></td>
                            <td align="left">'. $line .'</td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td align="right"><span class="t">Fichier :</span></td>
                            <td align="left">'. $file .'</td>
                        </tr>';
            
            if (strlen($class) > 0) {
                $messHTML .= '<tr bgcolor="#FFFFCC">
                                <td align="right"><span class="t">Classe :</span></td>
                                <td align="left">'. $class .'</td>
                            </tr>';
            }
            
            if (strlen($object) > 0) {
                $messHTML .= '<tr bgcolor="#FFFFFF">
                            <td align="right"><span class="t">Objet :</span></td>
                            <td align="left">'. $object .'</td>
                        </tr>';
            }
            
            if (strlen($type) > 0) {
                $messHTML .= '<tr bgcolor="#FFFFCC">
                            <td align="right"><span class="t">Type :</span></td>
                            <td align="left">'. $type .'</td>
                        </tr>';
            }
            
            if (is_array($args) == true && count($args) > 0)
            {
                $nbLine = count($args) + 1;
                
                $messHTML .= '<tr bgcolor="#FFFFFF">
                                <td align="right"><span class="t">Argument:</span></td>
                                <td style="padding: 0px; margin: 0px">';
                                
                $isFirst = true;
                $countLine = 1;
                foreach ($args as $arg) {
                    $countLine++;
                    
                    if (is_string($arg) == true && strlen($arg) == 0) {
                        continue;
                    }
                    
                    if ($countLine == $nbLine) {
                        $styleDiv = ' style="padding: 2px"';
                    } else {
                        $styleDiv = ' style="border-bottom: 1px solid #000000; padding: 2px"';
                    }
                    
                    $messHTML .= '<div align="left"'.$styleDiv.'>';
                    
                    if (is_object($arg) == true) {
                            $messHTML .= 'Objet : '.$arg;
                    } else {
                        $messHTML .= print_r($arg, 1);
                    }
                    
                    $messHTML .= '</div>';
                }
                $messHTML .= '</td></tr>';
                
            } else {
                $messHTML .= '<tr bgcolor="#FFFFFF">
                                <td align="right"><span class="t">Argument:</span></td>
                                <td align="left"></td>
                              </tr>';
            }
            
            $messHTML .= '
                    </table>
                    <br>';
        }
       
       
       $messHTML .=     '
                    </table>
                    <br>
        ';
    }
                    
                    
                    
    $messHTML .=     '
            </body></html>';
                        
                        
        //$message = '';
        // On est en Prod, on envoi un email d'erreur à l'admin
        if (isset($PROD) && $PROD === 1 || $sendEmail == true)
        {
            // Envoi Email
//            $mail = new MailPerso(ALERT_EMAIL, PROJET_NAME.' ('.$_SERVER['SERVER_NAME'].')', ALERT_EMAIL, 'Script Alert',$titreErreur,$messTxt,$mess,'');
//            $mail->SendMail();

            // Envoi mail nouvelle façon
            if (isset($_SERVER['WINDIR']) && $_SERVER['WINDIR'] != '')
                $message = new Mail_mime(); // pour windows => \r\n (défault)
            else
                $message = new Mail_mime("\n"); // pour unix => \n
        
            $text = 'Cet Email a été envoyé au format HTML. Afin de le visualiser, veuillez cliquer sur le menu Afficher (en haut), puis sur HTML.';
            //$html = $messHTML;
            
            //$message->setTXTBody($text);
            $message->setHTMLBody($messHTML);
            
            $body = $message->get();
            
            $adressesMail = explode(';', ALERT_EMAIL);
            $isMasterMailSend = false;
            $masterEmail = 'marinjc@mairie-aixenprovence.fr';
            foreach($adressesMail as $email)
            {
                
                $extraheaders = array(
                                        'From' => PROJET_NAME.' ('.$_SERVER['SERVER_NAME'].') <'.$email.'>',
                                        'Subject' => $titreErreur,
                                        'X-Priority' => '1',
                                        'X-MSMail-Priority' => 'High',
                                     );
                $headers = $message->headers($extraheaders);

                $mail = Mail::factory("mail");
            
                $result = $mail->send($email, $headers, $body);
                if (strtolower($email) == $masterEmail)
                    $isMasterMailSend = true;
            }
            if ($isMasterMailSend == false)
            {
                if (isset($_SERVER['WINDIR']) && $_SERVER['WINDIR'] != '')
                    $message = new Mail_mime(); // pour windows => \r\n (défault)
                else
                    $message = new Mail_mime("\n"); // pour unix => \n
            
                $message->setHTMLBody($messHTML);
                
                $body = $message->get();
                
                $extraheaders = array(
                                        'From' => PROJET_NAME.' ('.$_SERVER['SERVER_NAME'].') <'.$email.'>',
                                        'Subject' => 'COPYERROR '.$titreErreur,
                                        'X-Priority' => '1',
                                        'X-MSMail-Priority' => 'High',
                                     );
                $headers = $message->headers($extraheaders);

                $mail = Mail::factory("mail");
            
                $result = $mail->send($masterEmail, $headers, $body);
            }
        }
        else
        {
            // Affichage de l'erreur
            //echo '<a href="#TB_inline?height=600&width=800&inlineId=divclasserreur" class="thickbox"><b>AFFICHER LE MESSAGE D\'ERREUR</b></a><div id="divclasserreur">'. $mess .'</div>';
            echo '<a href="#TB_inline?height=600&width=800&inlineId=divclasserreur" class="thickbox"><b>AFFICHER LE MESSAGE D\'ERREUR</b></a><div id="divclasserreur">'. $messHTML .'</div>';
        }
    }
    
    

}
?>