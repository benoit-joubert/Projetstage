<?php
/*
 voir le site d'exemple pour un exemple de code.
*/
class Rss
{
    // propriétés du channel (OBLIGATOIRE)
    var $channelTitle       = '';
    var $channelLink        = '';
    var $channelDescription = '';
    
    // propriétés du channel (OPTIONNEL)
    var $channelImage       = array();
    
    // items
    var $items = array();
    
    function __construct($title, $link, $description)
    {
        $this->Rss($title, $link, $description);
    }
    
    function Rss($title, $link, $description)
    {
        $this->channelTitle         = $title;
        $this->channelLink          = $link;
        $this->channelDescription   = $description;
    }
    
    function setChannelTitle($val)
    {
        $this->channelTitle = $val;
    }
    
    function setChannelLink($val)
    {
        $this->channelLink = $val;
    }
    
    function setChannelDescription($val)
    {
        $this->channelDescription = $val;
    }
    
    function setChannelImage($url, $width = '', $height = '')
    {
        if ($width != '' && $height != '')
        {
            $this->channelImage = array(
                                        'url' => $url,
                                        'link' => $this->channelLink,
                                        'title' => $this->channelTitle,
                                        'width' => $width,
                                        'height' => $height,
                                        );
        }
        else
        {
            $this->channelImage = array(
                                        'url' => $url,
                                        'link' => $this->channelLink,
                                        'title' => $this->channelTitle,
                                        );
        }
    }
    
    function addChannelItem($title, $description = '', $pubdate = '', $link = '', $fichier = '', $tailleFichier = '')
    {
        $tab = array();
        $tab['title']       = utf8_encode($title);

        if ($link != '')
            $tab['link'] = $link;

        if ($description != '')
            $tab['description'] = utf8_encode($description);
        
        if ($pubdate != '')
            $tab['pubDate']     = date('D, d M Y H:i:s +0100', $pubdate);
        
        if ($fichier != '')
        {
            $extension = strtolower(substr($fichier, -3));
            if (in_array($extension, array('gif', 'png')))
                $type = 'image/'.$extension;
            else if (in_array($extension, array('jpg')))
                $type = 'image/jpeg';
            else if (in_array($extension, array('pdf')))
                $type = 'application/pdf';
            else
                $type = 'application/'.$extension;
            
            
            //$length = filesize($fichier);
            
            $tab['enclosure']['_attributes']['url'] = $fichier;
            if ($tailleFichier != '')
                $tab['enclosure']['_attributes']['length'] = $tailleFichier;
            
            $tab['enclosure']['_attributes']['type'] = $type;
//            $tab['enclosure'] = array(
//                                        '_attributes' => array(
//                                                                'url' => $fichier,
//                                                                'type' => $type,
//                                                              ),
//                                     );
        }
        
        $this->items[] = $tab;
    }
    
    function getXml()
    {
        $serializer_options = array (
                                       'indent' => '    ',
                                       'linebreak' => "\n",
                                       'typeHints' => false,
                                       'addDecl' => true,
                                       'encoding' => 'UTF-8',//'ISO-8859-15',
                                       'rootName' => 'rss',
                                       'rootAttributes'  => array(
                                                                    'version' => '2.0',
                                                                    'xmlns:atom' => 'http://www.w3.org/2005/Atom',
                                                                 ),
                                       'defaultTagName' => 'item',
                                       'attributesArray' => '_attributes'
                                    );

        $Serializer = new XML_Serializer($serializer_options); 
        
        $tab = array(
                    'channel' => array(
                                        'title' => utf8_encode($this->channelTitle),
                                        'link' => $this->channelLink,
                                        'description' => utf8_encode($this->channelDescription),
                                      ),
                    );
        if (count($this->channelImage) > 0)
            $tab['channel']['image'] = $this->channelImage;
        foreach($this->items as $t)
        {
            $tab['channel'][] = $t;
        }

        $status = $Serializer->serialize($tab);
        
        if (PEAR::isError($status))
        {
            die($status->getMessage());
        }
        
        return $Serializer->getSerializedData();
    }
    
    function genereRss()
    {
        header('Content-type: text/xml');
        echo $this->getXml();
    }
    
}

?>