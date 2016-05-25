<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-04-28
 * Time: 11:24
 */

namespace gel\Escape;


use Anax\Exception;

class CEscape implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;




    protected $encoding = "utf-8";
    protected $htmlEscapeMap = [
        34 => 'qout',   // "
        38 => 'amp',    // &
        60 => 'lt',     // <
        62 => 'gt'      // >
    ];

    protected $htmlQuoteType = 3;
    protected $enclist = array(
        'UTF-8', 'ASCII',
        'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5',
        'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10',
        'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16',
        'Windows-1251', 'Windows-1252', 'Windows-1254',
    );


    /**
     * Set the encoding that will be used by the escaper
     * @param string $encoding
     *
     */

    public function setEncoding($encoding) {

        $this->encoding = $encoding;
    }

    public function getEncoding(){

        return $this->encoding;
    }


    public function setHtmlQuoteType($quoteType){

        $this->htmlQuoteType = $quoteType;

    }


    public function detectEncoding($str)
    {

        $charset = gettype($str);
        if ($charset == 'string') {

            return $charset;
        }

        if (!function_exists('mb_detect_encoding')) {

            return null;
        }

        foreach ($this->enclist as $item) {
            if(mb_detect_encoding($str, $item, true))
                return $item;
        }


        return mb_detect_encoding($str);

    }


    public function normalizeEncoding($str){


        if (!function_exists("mb_convert_encoding")) {
			throw new Exception("Extension 'mbstring' is required");
         }

        return mb_convert_encoding($str, "UTF-32", $this->detectEncoding($str));
    }


    public function escapeHTML($str) {

        return htmlspecialchars($str, $this->htmlQuoteType, $this->encoding);
    }


    public function escapeHtmlAttr($atr) {

        return htmlspecialchars($atr, ENT_QUOTES);
    }

    /**
     * @param string $string
     * @return string
     */

    public function escapeUrl($string)
    {
        return rawurlencode($string);
    }


}