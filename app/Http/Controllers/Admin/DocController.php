<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DocController extends Controller
{
    public function api()
    {
        return view('admin.doc.api');
    }
}
