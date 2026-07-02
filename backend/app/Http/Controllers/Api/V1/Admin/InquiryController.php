<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InquiryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->get('per_page', 50), 200);

        $inquiries = Inquiry::query()
            ->when($request->get('type'), fn ($q, $type) => $q->where('source', $type))
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'data' => $inquiries->items(),
            'meta' => [
                'current_page' => $inquiries->currentPage(),
                'last_page'    => $inquiries->lastPage(),
                'per_page'     => $inquiries->perPage(),
                'total'        => $inquiries->total(),
            ],
        ]);
    }

    public function updateStatus(Request $request, Inquiry $inquiry): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,in_progress,resolved'],
        ]);

        $inquiry->update(['status' => $data['status']]);

        return response()->json(['data' => ['status' => $inquiry->status]]);
    }

    public function destroy(Inquiry $inquiry): JsonResponse
    {
        $inquiry->delete();

        return response()->json(null, 204);
    }

    public function export(): Response
    {
        $rows   = [];
        $rows[] = ['Source', 'Name', 'Email', 'Phone', 'Subject', 'Service', 'Message', 'Status', 'Received'];

        Inquiry::latest()->each(function (Inquiry $m) use (&$rows) {
            $rows[] = [
                ucfirst($m->source),
                $m->name,
                $m->email,
                $m->phone ?? '',
                $m->subject ?? '',
                $m->service ?? '',
                $m->message ?? '',
                $m->status,
                $m->created_at?->toDateTimeString(),
            ];
        });

        $csv = implode("\n", array_map(
            fn ($r) => implode(',', array_map(fn ($v) => '"' . str_replace('"', '""', (string) $v) . '"', $r)),
            $rows
        ));

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inquiries-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
