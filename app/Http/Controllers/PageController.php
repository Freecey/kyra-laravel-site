<?php

namespace App\Http\Controllers;

use App\Models\Manifeste;
use App\Models\Setting;

class PageController extends Controller
{
    public function home()
    {
        $manifestes = Manifeste::active()->ordered()->limit(6)->get();

        return view('pages.home', compact('manifestes'));
    }

    public function manifestes()
    {
        $manifestes = Manifeste::active()->ordered()->get();

        return view('pages.manifestes', compact('manifestes'));
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
