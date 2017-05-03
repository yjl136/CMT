<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/5/2
 * Time: 14:11
 */

namespace App\Http\Service;

define('CFG_DEFAULT_LANG', "zh");
class Trans
{
    /**
     *
     *
     * @var Zend_Translate_Adapter
     */
    protected $locale = null;

    private static $myInstance;

    private function __construct($locale=null) {
        if ($locale == '') {
            $local = ini_get('intl.default_locale');
        }
        if ($locale == '') {
            $locale = CFG_DEFAULT_LANG;
        }
        $this->setLocale($locale);
    }

    /**
     *
     * Enter description here ...
     * @return Translator
     */
    public static function instance($locale=null) {
        if (self::$myInstance == null) {
            self::$myInstance = new self();
        }
      /*
        if ($locale == '' && @$_GET['lang'] != '') {
            $locale = $_GET['lang'];
        }
        if ($locale == '' && @$_COOKIE['lang'] != '') {
            $locale = $_COOKIE['lang'];
        }
        if ($locale == '' && @$_SESSION['lang'] != '') {
            $locale = $_SESSION['lang'];
        }*/
        if ($locale) {
            self::$myInstance->setLocale($locale);
        }
        return self::$myInstance;
    }

    /**
     * @param null $locale
     * @return string
     * 根据相关的语言获取相关的语言js文件
     */
    public static function getLinkJS($locale=null) {
        $localeJsFile = "";
        $myInstance = self::instance($locale);
        $locale = $myInstance->getLocale();
        $localeParts = explode("_", $locale);
        for ($i=count($localeParts); $i>=1; $i--) {
            $localeJsFileTemp = "./lang/".implode("_", $localeParts).".js";
            if (is_file($localeJsFileTemp)) {
                $localeJsFile = $localeJsFileTemp;
                break;
            }
            array_pop($localeParts);
        }
        $output = "";
        if($localeJsFile) {
            $output = asset("$localeJsFile");
        }else {
            //如果找不到则为默认中文
            $output = asset("/lang/zh_CN.js");
        }
        return $output;
    }

    /**
     *
     * linkCssTag
     * @param $src
     * @param $attributes
     */
    public static function linkCss($src, $attributes='type="text/css" rel="stylesheet"') {
        $output = "";
        $output .= "<link href=\"$src\" $attributes/>\r\n";
        $addonCss = self::instance()->translate($src);
        if($addonCss != $src) {
            $output .= "<link href=\"$addonCss\" $attributes/>\r\n";
        }
        return $output;
    }

    public static function linkJs($src, $attributes=' type="text/javascript" '){
        $src = self::instance()->translate($src);
        $output = "<script $attributes src=\"$src\"></script>\r\n";
        return $output;
    }


    /**
     *
     * change filepath to cureent locale
     */
    public static  function file($path) {
        return self::t($path);
    }



    /**
     * translate a msg
     * eg: $t->_('I have %1$d %2$s. %%1$d', 2, 'apples'); //I have 2 apples. %1$d.
     *
     * @param $msg
     * @param $arg1
     * @param $arg2
     * @param $arg_
     */
    public function translate($msg, $arg1=null, $arg2=null, $arg_=null) {
        $args = func_get_args();
        $tranlated = $args[0] = $this->translator->translate($msg);
        $tranlated = call_user_func_array(array($this, 'safeSprintf'), $args);
        if($tranlated === false) {
            $tranlated = $args[0];
        }
        return $tranlated;
    }
    public function setLocale($locale) {
        if (!in_array($locale,config('app.suoportlocale'))) {
            //如果不存在则默认为中文
            $locale='zh_CN';
        }
        $this->locale = $locale;
        return true;
    }

    public function getLocale() {
        return $this->locale;
    }

    public function getEnableLocales() {
        return $this->enableLocales;
    }

    /**
     * safeSprintf
     * $t->safeSprintf('%, I have %1$d %2$s. %%1$d %1$d', 2, 'apples'); //%, I have 2 apples. %1$d 2.
     * @param $formatString
     * @param $arg1
     * @param $arg2
     * @param $arg_
     */
    public function safeSprintf($formatString, $arg1=null, $arg2=null, $arg_=null) {
        $args = func_get_args();
        //hidden all args
        $doublueFlag = '[@doublue^Flagggg&]';
        $formatString = str_replace("%%", $doublueFlag, $formatString);
        $formatString = str_replace("%", "%%", $formatString);

        //recovery safe args
        //$formatString = preg_replace("%%([])\$", "%\\1\\$", $formatString);
        for($i=1, $c=count($args); $i<$c; $i++) {
            $formatString = str_replace("%%$i\$", "%$i\$", $formatString);
        }
        $formatString = str_replace($doublueFlag, "%%", $formatString);

        $args[0] = $formatString;
        $formatString = @call_user_func_array('sprintf', $args);
        return $formatString;
    }
}