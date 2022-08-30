<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function setLang(Request $request)
    {
        $locale = $request->lang;
        app()->setLocale($locale);
        session()->put('locale', $locale);

//        App::setLocale($locale);
//        $a = Session(["locale", $locale]);
        return redirect()->back();
//        return $locale."     ".$a;
    }
}
