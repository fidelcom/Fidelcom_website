<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Success;
use App\Models\Testimonial;
use App\Models\WhyUs;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $about = About::first();
        $posts = Post::latest()->limit(3)->get();
        $projectCategories = ProjectCategory::with('project')->get();
        $projects = Project::latest()->get();
        $sliders = Slider::latest()->get();
        $testimonials = Testimonial::latest()->get();
        $services = Service::all();
        $contact  = Contact::first();
        $successes = Success::all();
        $brands = Partner::all();
        $whyUs = WhyUs::first();
        $whyChooseUs = WhyUs::all();
        $faqs = Faq::limit(5)->get();
        return view('index', compact('about', 'posts', 'projectCategories', 'projects', 'sliders', 'testimonials', 'services', 'contact', 'successes', 'brands', 'whyUs', 'whyChooseUs', 'faqs'));
    }
}
