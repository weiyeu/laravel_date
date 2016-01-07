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

            // check image file
            if (!$this->checkImage($this->imgPathname)) {
                return response()->json(['error' => 'wrongImgType']);
            }

            // instance imageManipulator
            $this->$imageManipulator = new ImageManipulator($this->imgPathname);
        } else {
            return response()->json(['error' => 'noUploadImg']);
        }

        // move image to resource folder

        // write record into images table

        // return response

    }

    public function ajaxUploadCropImage(Request $request)
    {

    }

    protected function checkImage($imgPathname)
    {
        // check readable of not
        if (!(is_readable($imgPathname) && is_file($imgPathname))) {
            return false;
        }

        // check image size
        if (getimagesize($imgPathname) == false) {
            return false;
        }

        // list image data
        list ($this->width, $this->height, $type) = getimagesize($imgPathname);

        // image type array
        $imgTypes = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];

        // check image type
        if (!in_array($type, $imgTypes)) {
            return false;
        }

        // pass all checks
        return true;
    }
}
