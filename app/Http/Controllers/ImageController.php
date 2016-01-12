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


    public function ajaxUploadImage(Request $request)
    {
        //-- check image is uploaded or not --
        if ($request->hasFile('uploadImg')) {

            // get image file
            $this->imgFile = $request->file('uploadImg');

            // get image path name
            $this->imgPathname = $this->imgFile->getPathname();

            // check image file
            if (!$this->checkImage($this->imgPathname)) {
                return response()->json(['error' => 'wrongImgType']);
            }
        } else {
            return response()->json(['error' => 'noUploadImg']);
        }

        //-- move image to resource folder --
        // generate unique file name
        $file_name = date('Y-m-d-H-i-s') . uniqid("upload") . '.jpg';

        // get image destination
        $destination = $request->input('destination');

        // move image file to destination
        $destinationPath = $this->basePath.$destination;

        $movedImgFile = $request->file('uploadImg')->move($destinationPath, $file_name);

        $movedImgPathname = $movedImgFile->getPathname();

        $movedImgUrl = url('resource/'.$destination.'/'.$file_name);

        //-- write record into images table --
        Image::create([
            'path' => $movedImgPathname,
        ]);

        //-- return response --
        return response()->json([
            'imgSrc' => $movedImgUrl
        ]);

    }

    public function ajaxUploadCropImage(Request $request)
    {

    }
}
