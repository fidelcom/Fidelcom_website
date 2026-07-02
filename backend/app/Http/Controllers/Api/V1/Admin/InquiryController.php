<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\GetInTouch;
use App\Models\LetsTalk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InquiryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $contacts = GetInTouch::latest()->get()->map(fn ($m) => [
            'id'         => "contact-{$m->id}",
            'source'     => 'contact',
            'name'       => $m->name,
            'email'      => $m->email,
            'phone'      => $m->phone,
            'subject'    => $m->subject,
            'service'    => null,
            'message'    => $m->message,
            'status'     => $m->status,
            'created_at' => $m->created_at?->toISOString(),
        ]);

        $quotes = LetsTalk::latest()->get()->map(fn ($m) => [
            'id'         => "quote-{$m->id}",
            'source'     => 'quote',
            'name'       => $m->name,
            'email'      => $m->email,
            'phone'      => $m->phone,
            'subject'    => null,
            'service'    => $m->service,
            'message'    => null,
            'status'     => $m->status,
            'created_at' => $m->created_at?->toISOString(),
        ]);

        $all = $contacts->merge($quotes)->sortByDesc('created_at')->values();

        return response()->json(['data' => $all]);
    }

    public function updateStatus(Request $request, string $compositeId): JsonResponse
    {
        [$source, $id] = explode('-', $compositeId, 2);

        if ($source === 'contact') {
            $record = GetInTouch::findOrFail($id);
        } else {
            $record = LetsTalk::findOrFail($id);
        }

        $record->update(['status' => ! $record->status]);

        return response()->json(['data' => ['status' => $record->status]]);
    }

    public function destroy(string $compositeId): JsonResponse
    {
        [$source, $id] = explode('-', $compositeId, 2);

        if ($source === 'contact') {
            GetInTouch::findOrFail($id)->delete();
        } else {
            LetsTalk::findOrFail($id)->delete();
        }

        return response()->json(null, 204);
    }

    public function export(): Response
    {
        $contacts = GetInTouch::latest()->get();
        $quotes   = LetsTalk::latest()->get();

        $rows   = [];
        $rows[] = ['Source', 'Name', 'Email', 'Phone', 'Subject', 'Service', 'Message', 'Status', 'Received'];

        foreach ($contacts as $m) {
            $rows[] = ['Contact', $m->name, $m->email, $m->phone, $m->subject, '', $m->message, $m->status ? 'Read' : 'Unread', $m->created_at?->toDateTimeString()];
        }

        foreach ($quotes as $m) {
            $rows[] = ['Quote', $m->name, $m->email, $m->phone, '', $m->service, '', $m->status ? 'Read' : 'Unread', $m->created_at?->toDateTimeString()];
        }

        $csv = implode("\n", array_map(fn ($r) => implode(',', array_map(fn ($v) => '"' . str_replace('"', '""', (string) $v) . '"', $r)), $rows));

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inquiries-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
