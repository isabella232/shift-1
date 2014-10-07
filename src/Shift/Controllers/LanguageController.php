<?php namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;

class LanguageController extends Controller
{

    public function getIndex()
    {

    }

    public function getSupportedLanguages()
    {
        return json_encode([['id' => 1, 'locale' => 'English (en_GB)', 'code' => 'en_GB']]);
    }
}