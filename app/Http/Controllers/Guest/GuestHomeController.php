<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class GuestHomeController extends Controller
{
  public function index() 
  {
    $published_projects = Project::where('is_published', 1)->orderBy('updated_at', 'DESC')->limit(6)->get();
    return view('guest.guestHome', compact('published_projects'));
  }
}