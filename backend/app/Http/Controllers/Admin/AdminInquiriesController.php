<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GetInTouch;
use App\Models\LetsTalk;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminInquiriesController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $contacts = GetInTouch::latest()->get()->map(fn ($item) => [
            'id'         => $item->id,
            'source'     => 'contact_us',
            'name'       => $item->name,
            'email'      => $item->email,
            'phone'      => $item->phone,
            'subject'    => $item->subject,
            'service'    => null,
            'message'    => $item->message,
            'status'     => $item->status,
            'created_at' => $item->created_at,
        ]);

        $letsTalks = LetsTalk::latest()->get()->map(fn ($item) => [
            'id'         => $item->id,
            'source'     => 'lets_talk',
            'name'       => $item->name,
            'email'      => $item->email,
            'phone'      => $item->phone,
            'subject'    => null,
            'service'    => $item->service,
            'message'    => null,
            'status'     => $item->status,
            'created_at' => $item->created_at,
        ]);

        $inquiries = $contacts->concat($letsTalks)->sortByDesc('created_at')->values();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function export(): StreamedResponse
    {
        $contacts = GetInTouch::latest()->get()->map(fn ($item) => [
            'Source'     => 'Contact Us',
            'Name'       => $item->name,
            'Email'      => $item->email,
            'Phone'      => $item->phone,
            'Subject'    => $item->subject,
            'Service'    => '',
            'Message'    => strip_tags($item->message),
            'Status'     => $item->status ? 'Read' : 'Unread',
            'Received'   => $item->created_at->format('Y-m-d H:i'),
        ]);

        $letsTalks = LetsTalk::latest()->get()->map(fn ($item) => [
            'Source'     => "Let's Talk",
            'Name'       => $item->name,
            'Email'      => $item->email,
            'Phone'      => $item->phone,
            'Subject'    => '',
            'Service'    => $item->service,
            'Message'    => '',
            'Status'     => $item->status ? 'Read' : 'Unread',
            'Received'   => $item->created_at->format('Y-m-d H:i'),
        ]);

        $rows = $contacts->concat($letsTalks)->sortByDesc('Received')->values();

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            if ($rows->isNotEmpty()) {
                fputcsv($handle, array_keys($rows->first()));
            }
            foreach ($rows as $row) {
                fputcsv($handle, array_values($row));
            }
            fclose($handle);
        }, 'inquiries-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
