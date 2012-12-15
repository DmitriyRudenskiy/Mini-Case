<?php

/**
 * Название
 *
 * Описание
 *
 * @package		miniCase
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @version		0.91
 */

class plugins_Image
{
    protected function _getMaskString($fileName, $alt = '')
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $fileName)) {
        	
        	$str = '<a href="http://' . $_SERVER['HTTP_HOST'] . '%s"class="fancybox_img">
        	<img src="http://' . $_SERVER['HTTP_HOST'] . '%s" alt="%s" />
        	</a>';
            return sprintf($str, str_replace('_m', '_b', $fileName), $fileName, $alt);
        }
        
        return '';
    }
    
    public function getInfoImages()
    {

    }
    
    /**
     * {image}1,2{/image}
     */
    public function find($text)
    {
        $n = preg_match_all('/{image}(.*?){\/image}/s', $text, $tmp);

        if ($n > 0) {
            for ($i = 0; $i < $n; $i++) {
                $imageList = explode(',', $tmp[1][$i]);

                $x = sizeof($imageList);
                $content = '';

                for ($j = 0; $j < $x; $j++) {
                    $file = '/public/gallery/' . $imageList[$j] . '_m.jpg';
                    $content .= $this->_getMaskString($file, 123);
                }

                $text = str_replace($tmp[0][$i], $content, $text);
            }
        }
        
        return $text;
    }

}
/* End of file application/plugin/Image.php */
