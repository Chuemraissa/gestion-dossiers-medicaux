<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * Langues disponibles : un dossier dans lang/ = une langue.
     * Pour ajouter une langue, il suffit d'ajouter son dossier (avec messages.php).
     * Retourne [code => nom affiché], ex. ['fr' => 'Français'].
     */
    public static function langues(): array
    {
        $langues = [];

        foreach (File::directories(lang_path()) as $dossier) {
            $code = basename($dossier);
            $langues[$code] = trans('messages.nom_langue', [], $code);
        }

        return $langues;
    }

    public function setLocale($lang)
    {
        if (array_key_exists($lang, self::langues())) {
            App::setLocale($lang);
            Session::put('locale', $lang);
        }

        return back();
    }
}
