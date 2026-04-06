<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings'                          => 'required|array',
            'settings.mail_mailer'              => 'required|in:smtp,sendmail,log',
            'settings.mail_host'                => 'required|string|max:255',
            'settings.mail_port'                => 'required|integer|min:1|max:65535',
            'settings.mail_username'            => 'nullable|string|max:255',
            'settings.mail_password'            => 'nullable|string|max:255',
            'settings.mail_encryption'          => 'nullable|in:tls,ssl,',
            'settings.mail_from_address'        => 'required|email|max:255',
            'settings.mail_from_name'           => 'required|string|max:255',
            'settings.mail_to'                  => 'required|email|max:255',
            'settings.mail_cc'                  => 'nullable|email|max:255',
            'settings.notification_subject'     => 'required|string|max:255',
            'settings.form_success_message'     => 'required|string|max:500',
        ]);

        $data = $request->input('settings');

        // Checkboxes: absent from POST = unchecked = 0
        $data['form_enabled']    = isset($data['form_enabled'])    ? '1' : '0';
        $data['mail_verify_ssl'] = isset($data['mail_verify_ssl']) ? '1' : '0';

        foreach ($data as $key => $value) {
            // Never overwrite password with empty string — keep existing value
            if ($key === 'mail_password' && ($value === null || $value === '')) {
                continue;
            }
            if (Setting::where('key', $key)->exists()) {
                Setting::set($key, $value ?? '');
            }
        }

        return back()->with('success', 'Paramètres sauvegardés.');
    }
}
