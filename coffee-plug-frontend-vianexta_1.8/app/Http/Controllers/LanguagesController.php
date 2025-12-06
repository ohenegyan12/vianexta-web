<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public function index()
    {
        $languages = [
            ["code" => "ab", "name" => "Abkhaz", "nativeName" => "аҧсуа"],
            ["code" => "aa", "name" => "Afar", "nativeName" => "Afaraf"],
            ["code" => "af", "name" => "Afrikaans", "nativeName" => "Afrikaans"],
            ["code" => "ak", "name" => "Akan", "nativeName" => "Akan"],
            // Add more languages here
        ];

        return view('languages.index', compact('languages'));
    }

}
