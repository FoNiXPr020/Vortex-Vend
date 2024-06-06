<?php

namespace Core;

class Translator
{
    protected static $translations = [];

    public function __construct()
    {
        // Load translations based on the selected language stored in the session
        $selectedLanguage = $this->getSelectedLanguage();
        self::loadTranslations($selectedLanguage);
    }

    private static function loadTranslations($selectedLanguage)
    {
        $file = BASE_PATH . 'App/Translations/' . $selectedLanguage . '.php';

        if (file_exists($file)) {
            include($file);
            if (isset($translations) && is_array($translations)) {
                self::$translations = $translations;
            } else {
                return self::redirectToDefaultLanguage();
            }
        } else {
            return self::redirectToDefaultLanguage();
            exit();
        }
    }

    private static function redirectToDefaultLanguage()
    {
        header('Location: ?lang='. $_ENV['APP_LANG']); // Redirect to default language
        exit();
    }

    public static function Translate($text)
    {
        if (isset(self::$translations[$text])) {
            return self::$translations[$text];
        } else {
            // Translation not found, return the original text
            return $text;
        }
    }

    public static function getSelectedLanguage()
    {
        return $_GET['lang'] ?? Session::get('lang') ?? $_ENV['APP_LANG'] ?? 'en';
    }

    public function setSelectedLanguage()
    {
        $selectedLanguage = self::getSelectedLanguage();
        //$_SESSION['lang'] = $selectedLanguage;
        Session::put('lang', $selectedLanguage);
        // Reload translations for the newly selected language
        self::loadTranslations($selectedLanguage);
    }

    public static function AvailableLanguages()
    {
        return array(
            'en' => array('English', 'fi fi-us'),
            'fr' => array('French', 'fi fi-fr'),
            'ar' => array('Arabic', 'fi fi-ae'),
            'es' => array('Spanish', 'fi fi-es')
        );
    }
}