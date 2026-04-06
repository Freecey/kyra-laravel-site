<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\MessageReply;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReplyController extends Controller
{
    public function store(Request $request, ContactMessage $message)
    {
        $data = $request->validate([
            'subject'       => ['required', 'string', 'max:255'],
            'body'          => ['required', 'string'],
            'attachments.*' => ['nullable', 'file', 'max:10240'], // 10 MB per file
        ]);

        // Persist reply
        $reply = $message->replies()->create([
            'subject' => $data['subject'],
            'body'    => $data['body'],
        ]);

        // Store attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store("replies/{$reply->id}", 'local');

                $reply->attachments()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path'          => $path,
                    'mime_type'     => $file->getMimeType(),
                    'size'          => $file->getSize(),
                ]);
            }
        }

        // Send email
        try {
            app(MailService::class)->sendReply($message, $reply);
            $reply->update(['sent_at' => now()]);
        } catch (\Throwable $e) {
            \Log::error('Reply email failed: ' . $e->getMessage());
            return redirect()->route('admin.messages.show', $message)
                ->with('warning', 'Réponse enregistrée mais l\'envoi a échoué : ' . $e->getMessage());
        }

        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Réponse envoyée et enregistrée.');
    }

    public function downloadAttachment(MessageReply $reply, int $attachmentId)
    {
        $attachment = $reply->attachments()->findOrFail($attachmentId);

        if (! Storage::disk('local')->exists($attachment->path)) {
            abort(404);
        }

        return Storage::disk('local')->download($attachment->path, $attachment->original_name);
    }
}
