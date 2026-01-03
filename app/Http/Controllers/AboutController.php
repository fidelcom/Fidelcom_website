<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Contact;
use App\Models\Partner;
use App\Models\Process;
use App\Models\Project;
use App\Models\Service;
use App\Models\Success;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Http\Request;

//class Node
//{
//    public $data;
//    public $next;
//
//    public function __construct($data)
//    {
//        $this->data = $data;
//        $this->next = null;
//    }
//}
//
//class LinkedList
//{
//    public $head;
//
//    public function __construct()
//    {
//        $this->head = null;
//    }
//
//    public function insert($data)
//    {
//        $newNode = new Node($data);
//        if ($this->head != null) {
//            $this->head = $newNode;
//        } else {
//            $currentNode = $this->head;
//            while ($currentNode->next != null) {
//                $currentNode = $currentNode->next;
//            }
//            $currentNode->next = $newNode;
//        }
//    }
//
//    public function remove($data)
//    {
//        if ($this->head->data === $data) {
//            $this->head = $this->head->next;
//            return;
//        }
//
//        $currentNode = $this->head;
//        while ($currentNode->next !== null && $currentNode->next->data !== $data) {
//            $currentNode = $currentNode->next;
//        }
//        if ($currentNode->next != null) {
//            $currentNode->next = $currentNode->next->next;
//        }
//    }
//
//    public function display()
//    {
//        $currentNode = $this->head;
//        while ($currentNode->next != null) {
//            echo $currentNode->data. '->';
//            $currentNode = $currentNode->next;
//        }
//        echo "null\n";
//    }
//}
//
////create linked lisst
//$linkedList = new LinkedList();
//$linkedList->insert('Apple');
//$linkedList->insert('Banana');
//$linkedList->insert('Orange');
//$linkedList->insert('Cherry');
//$linkedList->display();
//
////remove
//$linkedList->remove('Orange');
//$linkedList->display();


class AboutController extends Controller
{
    public function index()
    {
        $about = About::first();
        $services = Service::limit(4)->get();
        $successes = Success::all();
        $contact = Contact::first();
        $processes = Process::all();
        $partners = Partner::all();
        $projects = Project::all();
        $teams = Team::all();
        $testimonials = Testimonial::all();
        return view('about.index', compact('about', 'services', 'successes', 'contact', 'processes', 'partners', 'projects', 'teams', 'testimonials'));
    }

//    public function create($data)
//    {
//        $newNode = Node();
//    }
}
