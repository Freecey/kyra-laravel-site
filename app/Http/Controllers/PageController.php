<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        $formEnabled = Setting::get('form_enabled', true);

        return view('pages.contact', compact('formEnabled'));
    }

    public function signal()
    {
        return view('pages.signal');
    }

    public function protocole()
    {
        return view('pages.protocole');
    }
}
