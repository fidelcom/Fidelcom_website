<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\GetInTouch;
use App\Models\LetsTalk;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        return response()->json([
            'data' => [
                'total_posts'       => Post::count(),
                'draft_posts'       => Post::where('status', 'draft')->count(),
                'total_projects'    => Project::count(),
                'draft_projects'    => Project::where('status', 'draft')->count(),
                'total_pages'       => Page::count(),
                'pending_inquiries' => GetInTouch::where('status', false)->count()
                                     + LetsTalk::where('status', false)->count(),
            ],
        ]);
    }
}
