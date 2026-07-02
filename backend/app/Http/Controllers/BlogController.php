<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Contact;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');

        $posts = Post::with('blog_category')
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_desc', 'like', "%{$search}%")
                  ->orWhere('long_desc', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(4)
            ->withQueryString();

        $categories = BlogCategory::orderBy('name', 'ASC')->get();
        $latest = Post::with('blog_category')->latest()->limit(4)->get();
        $contact = Contact::first();

        return view('blog.index', compact('posts', 'categories', 'latest', 'contact', 'search'));
    }

    public function show(Post $post)
    {
        $post->load(['blog_category', 'comment']);
        $categories = BlogCategory::orderBy('name', 'ASC')->get();
        $latest = Post::with('blog_category')->latest()->limit(4)->get();
        $contact = Contact::first();
        return view('blog.show', compact('post', 'categories', 'latest', 'contact'));
    }

    public function category($id)
    {
        $posts = Post::where('blog_category_id', $id)->get();
        $categories = BlogCategory::orderBy('name', 'ASC')->get();
        $ct = BlogCategory::findOrFail($id);
        $latest = Post::latest()->limit(4)->get();
        $contact = Contact::first();
        return view('blog.category_post', compact('posts', 'categories', 'ct', 'latest', 'contact'));
    }
}
