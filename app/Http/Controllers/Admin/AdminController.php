<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GetInTouch;
use App\Models\LetsTalk;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'posts'           => Post::count(),
            'projects'        => Project::count(),
            'services'        => Service::count(),
            'team'            => Team::count(),
            'testimonials'    => Testimonial::count(),
            'new_inquiries'   => GetInTouch::where('status', 0)->count() + LetsTalk::where('status', 0)->count(),
        ];

        // Last 5 inquiries from both sources combined
        $contactRecent = GetInTouch::latest()->limit(5)->get()->map(fn ($i) => [
            'source'     => 'Contact Us',
            'name'       => $i->name,
            'email'      => $i->email,
            'subject'    => $i->subject,
            'status'     => $i->status,
            'created_at' => $i->created_at,
        ]);

        $letsTalkRecent = LetsTalk::latest()->limit(5)->get()->map(fn ($i) => [
            'source'     => "Let's Talk",
            'name'       => $i->name,
            'email'      => $i->email,
            'subject'    => $i->service,
            'status'     => $i->status,
            'created_at' => $i->created_at,
        ]);

        $recentInquiries = $contactRecent->concat($letsTalkRecent)
            ->sortByDesc('created_at')
            ->take(8)
            ->values();

        return view('admin.index', compact('stats', 'recentInquiries'));
    }
}
