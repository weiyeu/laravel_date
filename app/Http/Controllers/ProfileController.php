<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display a user's profile
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfile()
    {

        return view('profile.profile');
    }

    /**
     * store a user's profile
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postProfile(Request $request)
    {
        $destinationPath = "C:\\xampp\\htdocs\\laravel_date\\public\\resource";
        $file_name = uniqid("upload");
        $path = 'path is not set';
        if ($request->hasFile('uploadImg')) {
            $imgFile = $request->file('uploadImg');
            // check image file or not
            if(getimagesize($imgFile->getPathname()) !== false){
                dd(getimagesize($imgFile->getPathname()));
            }else{
                dd(getimagesize($imgFile->getPathname()));
            }
            $path = $request->file('uploadImg')->move($destinationPath,$file_name);
        }
        return view('profile.profile')->with('path', $path);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
