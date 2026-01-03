<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Contact;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(4);
        $categories = BlogCategory::orderBy('name', 'ASC')->get();
        $latest = Post::latest()->limit(4)->get();
        $contact = Contact::first();
        return view('blog.index', compact('posts', 'categories', 'latest', 'contact'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $categories = BlogCategory::orderBy('name', 'ASC')->get();
        $latest = Post::latest()->limit(4)->get();
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
