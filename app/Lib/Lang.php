<?php
/**
 * @author: kel <gnefaijuw@gmail.com>
 * @version: 1.0
 * @datetime: 2018/7/9 上午11:21
 */
namespace App\Lib;

class Lang
{
    private $supportedLangArr = []; //['en', 'zh-Hans', ...]
    private $defaultLang = '';
    private $currentLang = '';

    protected $configKey = 'lang';

    public function __construct()
    {
        $this->currentLang = env('LANG');
        $this->defaultLang = 'zh-Hans';
    }

    public function getLangPack($lang){
        return config("error_lang.{$lang}") ?? [];
    }

    public function show($langCode, $args = [], $lang = '')
    {
        if (!$lang) {
            if ($this->currentLang) {
                $lang = $this->currentLang;
            } else {
                $lang = $this->defaultLang;
            }
        }
        $langConfig = $this->getLangPack($lang);
        $content = '';
        if ($langConfig && isset($langConfig[$langCode])) {
            $content = (string)$langConfig[$langCode];
            if ($content && $args) {
                array_unshift($args, $content);
                $content = call_user_func_array('sprintf', $args);
            }
        }
        return $content;
    }

    public function setCurrentLang($lang)
    {
        if (in_array($lang, $this->supportedLangArr)) {
            $this->currentLang = $lang;
        }
    }

    public function getCurrentLang()
    {
        return $this->currentLang ? $this->currentLang : $this->defaultLang;
    }

    public function getSupportedLangArr()
    {
        return $this->supportedLangArr;
    }

    public function setSupportedLangArr(array $langArr)
    {
        $this->supportedLangArr = $langArr;
    }

    public function addSupportedLang($lang)
    {
        if (!$this->supportedLangArr) {
            $this->supportedLangArr[] = $lang;
        } elseif (!in_array($lang, $this->supportedLangArr)) {
            $this->supportedLangArr[] = $lang;
        }
    }

    public function setDefaultLang($lang)
    {
        if (!in_array($lang, $this->supportedLangArr)) {
            return false;
        }
        $this->defaultLang = $lang;
        return true;
    }

    public function convertSupportedLang($language)
    {
        //lang语言标识采用iOS系统的语言标识,即简体中文为zh-Hans,繁体中文为zh-Hant
        $lang = '';
        $segments = explode('_', $language, 2);
        $language = isset($segments[0]) ? $segments[0] : '';
        $locale = isset($segments[1]) ? $segments[1] : '';

        //中文简体、中文繁体进行特殊处理
        if (in_array($language, ['zh', 'zh-Hans', 'zh-Hant'])) {
            if (!$locale) {
                $language = $language == 'zh-Hant' ? 'zh-Hant' : 'zh-Hans';
            } else {
                //台湾、香港、澳门三个地区采用繁体中文,其余地区认为采用简体中文
                $language = in_array($locale, ['TW', 'HK', 'MO']) ? 'zh-Hant' : 'zh-Hans';
            }
        }

        if ($locale && in_array($language . '_' . $locale, $this->supportedLangArr)) {
            $lang = $language . '_' . $locale;
        } elseif (in_array($language, $this->supportedLangArr)) {
            $lang = $language;
        }

        return $lang;
    }
}
