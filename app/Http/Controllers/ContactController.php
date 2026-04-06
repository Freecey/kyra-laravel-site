<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use App\Services\MailService;
use GrantHolle\Altcha\Rules\ValidAltcha;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(private MailService $mailService) {}

    public function submit(Request $request): JsonResponse
    {
        // Check if form is enabled
        if (!Setting::get('form_enabled', true)) {
            return response()->json(['success' => false, 'message' => 'Le formulaire est temporairement désactivé.'], 503);
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
            'altcha'  => ['required', new ValidAltcha],
        ]);

        // Save to database
        $contact = ContactMessage::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'subject'    => $validated['subject'],
            'message'    => $validated['message'],
            'ip_address' => $request->ip(),
        ]);

        // Send email notification
        $mailSent = false;

        try {
            $this->mailService->sendContactNotification($contact);
            $mailSent = true;
            $contact->update(['mail_sent' => true]);
        } catch (\Throwable $e) {
            \Log::error('ContactController: mail failed', ['id' => $contact->id, 'error' => $e->getMessage()]);
        }

        \Log::info('Contact message received', ['id' => $contact->id, 'mail_sent' => $mailSent]);

        $successMessage = Setting::get('form_success_message', 'Message envoyé ! Je vous répondrai dès que possible.');

        return response()->json(['success' => true, 'message' => $successMessage]);
    }
}
