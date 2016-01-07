<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Library\ImageManipulator;
use Symfony\Component\HttpFoundation\File\File;

class ImageController extends Controller
{
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

    public function ajaxUploadImage(Request $request)
    {
        // check image is uploaded or not
        if ($request->hasFile('uploadImg')) {
            // get image file
            $this->imgFile = $request->file('uploadImg');
            // get image path name
            $this->imgPathname = $this->imgFile->getPathname();
            // instance imageManiPulator
            $this->$imageManipulator = new ImageManipulator($this->imgPathname);
        } else {
            return false;
        }

    }

    public function ajaxUploadCropImage(Request $request)
    {

    }

    protected function checkImage(String $imgPathname)
    {

    }
}
