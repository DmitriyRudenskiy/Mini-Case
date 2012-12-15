<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class plugin_Chess
{
    protected function _getMaskString($fileName, $alt = '')
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $fileName)) {
            $str = '<img src="http://' . $_SERVER['HTTP_HOST'] . '%s" alt="%s" />';
            return sprintf($str, $fileName, $alt);
        }
        
        return '';
    }
    
    public function getInfoImages()
    {

    }
    
    /**
     * {chess}1.e4 d5 2.Nc3 d4 3.Nd5 Nc6 4.Nf3 f5 5.Bb5 fxe4 6.Nxd4
     *  Qxd5 7.c3 Nf6 8.a4 Bd7 9.Qb3 a6 10.Qxd5 Nxd5 11.Nxc6 axb5
     *  12.Na5 Rxa5 13.b4 Rxa4 14.Rxa4 bxa4 15.Ke2 b5 *{/chess}
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

            return $text;
        }
    }

}
/* End of file application/plugin/Chess.php */
