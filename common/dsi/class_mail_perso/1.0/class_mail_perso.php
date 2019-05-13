<?php
/**
 * @package common
 */
 
/**
 * Classe permettant d'envoyer des mails<br>
 * 
 * Exemple d'utilisation de la classe:
 * <code>
 * <?php
 * $mail = new MailPerso('expediteur@mairie-aixenprovence.fr', 'Nom Expéditeur', 'destinataire@mairie-aixenprovence.fr', 'Nom Destinataire', 'Objet du mail','contenu du mail au format TEXTE','contenu du mail au format HTML','', 'Normal');
 * $res = $mail->SendMail();
 * if ($res)
 *     echo 'Mail envoyé avec succès';
 * else
 *     echo 'Erreur lors de l\'envoi du mail';
 * ?>
 * </code>
 */
class MailPerso
{
    var $mailFrom;
    var $mailFromName;
    var $mailTo;
    var $mailToName;
    var $mailSubject;
    var $mailText;
    var $mailHtml;
    var $mailAttmFiles;
    var $mailImgFiles;
    var $mailPriority;
    
    function __construct($From,$FromName,$To,$ToName,$Subject,$Text,$Html = '',$AttmFiles, $Priority = 'High', $ImgFiles = array())
    {
        $this->MailPerso($From,$FromName,$To,$ToName,$Subject,$Text,$Html,$AttmFiles, $Priority, $ImgFiles);
    }

    /**
     * @param string Adresse E-mail de l'expéditeur
     * @param string Nom de l'expéditeur
     * @param string Adresse E-mail du destinataire
     * @param string Nom du destinataire
     * @param string Objet
     * @param string Mail au format Texte
     * @param string Mail au format HTML
     * @param array lien vers les fichiers à joindre au mail
     * @param string Priorité du mail (Normal, High)
     * @param array lien vers les images à joindre au mail (dans le corps du mail)
     */
    function MailPerso($From,$FromName,$To,$ToName,$Subject,$Text,$Html = '',$AttmFiles, $Priority = 'High', $ImgFiles = array())
    {
        $this->mailFrom         = $From;
        $this->mailFromName     = $FromName;
        $this->mailTo           = $To;
        $this->mailToName       = $ToName;
        $this->mailSubject      = $Subject;
        $this->mailText         = $Text;
        $this->mailHtml         = $Html;
        $this->mailAttmFiles    = $AttmFiles;
        $this->mailImgFiles     = $ImgFiles;
        $this->mailPriority     = $Priority;
    }
    
    /**
     * Envoi le mail
     * @return boolean Renvoi true ou false suivant si le mail est bien parti ou non.
     */
    function SendMail()
    {
        $From       = $this->mailFrom;
        $FromName   = $this->mailFromName;
        $To         = $this->mailTo;
        $ToName     = $this->mailToName;
        $Subject    = $this->mailSubject;
        $Text       = $this->mailText;
        $Html       = $this->mailHtml;
        $AttmFiles  = $this->mailAttmFiles;
        $Priority   = $this->mailPriority;
        
        $OB="----=_OuterBoundary_000";
        $IB="----=_InnerBoundery_001";
        $Html = $Html ? $Html:preg_replace("/\n/","{br}",$Text) or die("neither text nor html part present.");
        $Text = $Text ? $Text:"Cet Email a été envoyé au format HTML. Afin de le visualiser, veuillez cliquer sur le menu Afficher (en haut), puis sur HTML.";
        $From or die("Class MailPerso : adresse expéditeur manquante");
        $To or die("Class MailPerso : adresse destinataire manquante");
        
        if (strlen($Html)>0)
        {
            $Html =   '<html>'.
                    '<head>'.
                    '<style>'.
                    'A:visited {COLOR: #777777; TEXT-DECORATION: none}'.
                    'A:hover {COLOR: #FFA13E; TEXT-DECORATION: none}'.
                    'A {COLOR: #777777;TEXT-DECORATION: none}'.
                    'BODY,TD {FONT-FAMILY: Verdana, Arial, sans-serif, Geneva; FONT-SIZE: 10px; COLOR: #202020;}'.
                    '.s {FONT-FAMILY: Verdana, Arial, sans-serif, Geneva; FONT-SIZE: 10px; COLOR: #FF7301;}'.
                    '</style>'.
                    '</head>'.
                    '<body>'.
                    $Html.
                    '</body>'.
                    '</html>';
        }
        
        $headers ="MIME-Version: 1.0\r\n"; 
        $headers.="From: ".$FromName." <".$From.">\n"; 
        $headers.="To: ".$ToName." <".$To.">\n"; 
        $headers.="Reply-To: ".$FromName." <".$From.">\n";
        if ($Priority == 'High')
            $headers.="X-Priority: 1\n";
        else
            $headers.="X-Priority: 0\n";
        $headers.="X-MSMail-Priority: ". $Priority ."\n"; 
        $headers.="X-Mailer: My PHP Mailer\n"; 
        $headers.="Content-Type: multipart/mixed;\n\tboundary=\"".$OB."\"\n";
        
        //Messages start with text/html alternatives in OB
        $Msg ="This is a multi-part message in MIME format.\n";
        $Msg.="\n--".$OB."\n";
        $Msg.="Content-Type: multipart/alternative;\n\tboundary=\"".$IB."\"\n\n";
        
        //plaintext section 
        $Msg.="\n--".$IB."\n";
        $Msg.="Content-Type: text/plain;\n\tcharset=\"iso-8859-1\"\n";
        $Msg.="Content-Transfer-Encoding: quoted-printable\n\n";
        // plaintext goes here
        $Msg.=$Text."\n\n";
        
        // html section 
        $Msg.="\n--".$IB."\n";
        $Msg.="Content-Type: text/html;\n\tcharset=\"iso-8859-1\"\n";
        $Msg.="Content-Transfer-Encoding: base64\n\n";
        // html goes here 
        $Msg.=chunk_split(base64_encode($Html))."\n\n";
        
        // end of IB
        $Msg.="\n--".$IB."--\n";
        
        // attachments
        if($AttmFiles)
        {
            foreach($AttmFiles as $AttmFile)
            {
                $patharray = explode ("/", $AttmFile); 
                $FileName=$patharray[count($patharray)-1];
                $Msg.= "\n--".$OB."\n";
                $Msg.="Content-Type: application/octetstream;\n\tname=\"".$FileName."\"\n";
                $Msg.="Content-Transfer-Encoding: base64\n";
                $Msg.="Content-Disposition: attachment;\n\tfilename=\"".$FileName."\"\n\n";
                       
                //file goes here
                $fd=fopen ($AttmFile, "r");
                $FileContent=fread($fd,filesize($AttmFile));
                fclose ($fd);
                $FileContent=chunk_split(base64_encode($FileContent));
                $Msg.=$FileContent;
                $Msg.="\n\n";
            }
        }

        //message ends
        $Msg.="\n--".$OB."--\n";
        if(!mail($To,$Subject,$Msg,$headers))
            return false;
        return true;
    }
    
    /**
     * Envoi le mail avec la possibilité de mettre des images en pièce jointe directement dans le corps du mail
     * @return boolean Renvoi true ou false suivant si le mail est bien parti ou non.
     */
    function sendMailWithImageAttachment() 
    {
        $from_email     = $this->mailFrom;
        $from_name      = $this->mailFromName;
        $to_email       = $this->mailTo;
        $to_name        = $this->mailToName;
        $subject        = $this->mailSubject;
        $text_message   = $this->mailText;
        $html_message   = $this->mailHtml;
        $attachmentImg  = $this->mailImgFiles;
        $AttmFiles      = $this->mailAttmFiles;
        $Priority       = $this->mailPriority;

        $from = "$from_name <$from_email>"; 
        $to   = "$to_name <$to_email>"; 

        $main_boundary = "----=_NextPart_".md5(rand()); 
        $text_boundary = "----=_NextPart_".md5(rand()); 
        $html_boundary = "----=_NextPart_".md5(rand()); 
        $headers  = "From: $from\n";
        $headers .= "Reply-To: $from\n";
        //$headers .= "X-Mailer: Hermawan Haryanto (http://hermawan.com)\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/mixed;\n\tboundary=".$main_boundary."\n";
        $message = "\n--$main_boundary\n";
        $message .= "Content-Type: multipart/alternative;\n\tboundary=".$text_boundary."\n";
        $message .= "\n--$text_boundary\n";
        $message .= "Content-Type: text/plain; charset='ISO-8859-1'\n";
        $message .= "Content-Transfer-Encoding: 7bit\n\n";
        $message .= ($text_message!="") ? $text_message:"Cet Email a été envoyé au format HTML. Afin de le visualiser, veuillez cliquer sur le menu Afficher (en haut), puis sur HTML."; 
        $message .= "\n--$text_boundary\n";
        $message .= "Content-Type: multipart/related;\n\tboundary=".$html_boundary."\n";
        $message .= "\n--$html_boundary\n";
        $message .= "Content-Type: text/html; charset='ISO-8859-1'\n";
        $message .= "Content-Transfer-Encoding: quoted-printable\n\n";
        //$message .= str_replace ("=", "=3D", $html_message)."\n";
        $message .= $html_message."\n";
        
        // inclusion des images à attacher au mail
        if (isset ($attachmentImg) && $attachmentImg != "" && count ($attachmentImg) >= 1) 
        {
            for ($i=0; $i<count ($attachmentImg); $i++)
            {
                $attfile = $attachmentImg[$i];
                $file_name = basename ($attfile);
                $fp = fopen ($attfile, "r");
                $fcontent = "";
                while (!feof ($fp))
                {
                    $fcontent .= fgets ($fp, 1024);
                }
                $fcontent = chunk_split (base64_encode($fcontent));
                @fclose ($fp);
                $message .= "\n--$html_boundary\n";
                $message .= "Content-Type: application/octetstream\n";
                $message .= "Content-Transfer-Encoding: base64\n";
                $message .= "Content-Disposition: inline; filename=".$file_name."\n";
                $message .= "Content-ID: <$file_name>\n\n";
                $message .= $fcontent;
            }
        }
        
        // inclusion des fichiers à attacher au mail
        if (isset ($AttmFiles) && $AttmFiles != "" && count ($AttmFiles) >= 1) 
        {
            foreach($AttmFiles as $AttmFile)
            {
                $patharray = explode ("/", $AttmFile); 
                $FileName=$patharray[count($patharray)-1];
                $message .= "\n--$html_boundary\n";
                //$Msg.= "\n--".$OB."\n";
                $message .= "Content-Type: application/octetstream;\n\tname=\"".$FileName."\"\n";
                $message .= "Content-Transfer-Encoding: base64\n";
                $message .= "Content-Disposition: attachment;\n\tfilename=\"".$FileName."\"\n\n";
                       
                //file goes here
                $fd = fopen ($AttmFile, "r");
                $FileContent = fread($fd,filesize($AttmFile));
                fclose ($fd);
                $FileContent = chunk_split(base64_encode($FileContent));
                $message .= $FileContent;
                $message .= "\n\n";
            }
        }
        
        $message .= "\n--$html_boundary--\n";
        $message .= "\n--$text_boundary--\n";
        $message .= "\n--$main_boundary--\n";

        if (mail($to_email, $subject, $message, $headers)) {
            return true;
        } else {
        	return false;
        }
    }
}
?>