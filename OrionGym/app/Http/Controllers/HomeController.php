<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }
    
    public function aboutUs()
    {
        return view('home.about-us');
    }
    public function blogDetails()
    {
        return view('home.blog-details');
    }
    public function blog()
    {
        return view('home.blog');
    }
    public function bmi()
    {
        return view('home.bmi-calculator');
    }
    public function classDetails()
    {
        return view('home.class-details');
    }
    public function classTimetable()
    {
        return view('home.class-timetable');
    }
    public function contact()
    {
        return view('home.contact');
    }
    public function gallery()
    {
        return view('home.gallery');
    }
    public function main()
    {
        return view('home.main');
    }
    public function services()
    {
        return view('home.services');
    }
    public function team()
    {
        return view('home.team');
    }

}
