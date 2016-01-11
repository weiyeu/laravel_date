<?php

namespace App\Library;

use Illuminate\Http\Request;

trait ImageProcessor
{
    /**
     * upload image to server
     *
     * @param  Request $request
     * @return string
     */
    public function UploadImage(Request $request)
    {
        //-- check image is uploaded or not --
        if ($request->hasFile('uploadImg')) {

            // get image file
            $imgFile = $request->file('uploadImg');

            // get image path name
            $imgPathname = $imgFile->getPathname();

            // check image file
            if (!$this->checkImage($imgPathname)) {
                return false;
            }
        } else {
            return null;
        }

        //-- move image to resource folder --
        // generate unique file name
        $file_name = date('Y-m-d-H-i-s') . uniqid("upload") . '.jpg';

        // move image file to destination
        $destinationPath = $this->imgBasePath.$this->imgDestination;

        $movedImgFile = $request->file('uploadImg')->move($destinationPath, $file_name);

        $movedImgPathname = $movedImgFile->getPathname();

        $movedImgUrl = url('resource/'.$this->imgDestination.'/'.$file_name);

        return $movedImgUrl;

    }
    /**
     * Check the image is real image file or not.
     *
     * @param  string  $imgPathname
     * @return bool
     */
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