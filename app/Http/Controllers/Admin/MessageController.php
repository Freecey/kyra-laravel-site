<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        if ($request->filled('filter')) {
            match ($request->filter) {
                'unread' => $query->where('is_read', false),
                'read'   => $query->where('is_read', true),
                default  => null,
            };
        }

        $messages = $query->paginate(20)->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'Message marqué comme lu.');
    }

    public function markUnread(ContactMessage $message)
    {
        $message->update(['is_read' => false]);
        return back()->with('success', 'Message marqué comme non lu.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message supprimé.');
    }
}
