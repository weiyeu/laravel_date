<?php 

namespace App\Http\Controllers;

class PagesController extends Controller
{
	public function home(){
		return view('home');
	}
    public function pageNotFound(){
//        return view('errors.503');
        abort(404);
    }
	
}