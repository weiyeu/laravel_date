<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Image;
use App\Library\ImageProcessor;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Library\ImageManipulator;
use Symfony\Component\HttpFoundation\File\File;

class ImageController extends Controller
{
    use ImageProcessor;
    /**
     * @var File
     */
    protected $imgFile;

    /**
     * @var String
     */
    protected $imgPathname;

    /**
     * @var ImageManipulator
     */
    protected $imageManipulator;

    /**
     * @var String
     */
    protected $basePath = "C:\\xampp\\htdocs\\laravel_date\\public\\resource\\";

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        // image check
        $this->middleware('image');
    }

    public function ajaxUploadImage(Request $request)
    {
        //-- move image to resource folder --
        $imgPathArr = $this->moveImage($request->file('uploadImg'),'article_image');

        //-- write record into images table --
        Image::create([
            'path' => $imgPathArr['imgPathname'],
        ]);

        //-- return response --
        return response()->json([
            'imgSrc' => $imgPathArr['imgUrl']
        ]);
    }

    public function ajaxUploadCropImage(Request $request)
    {

    }
}
