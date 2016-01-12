<?php

namespace App\Library;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Exception;

trait ImageProcessor
{
    /**
     * crop image
     *
     * @param  string $imagePathname
     * @param  string $prefix
     * @param  array $selection
     * @return array
     */
    protected function cropImage($imagePathname, $prefix, $selection)
    {
        // $destinationPath
        $destinationPath = public_path('resource\\' . $prefix);
        // checkImage and get type
        $type = $this->checkImage($imagePathname);
        // generate image name
        $imageName = $this->generateImageName($prefix, $type);
        // create image resource
        $imageResource = $this->createImageResource($imagePathname, $type);
        // crop image resource
        $imageCroppedResource = imagecrop($imageResource, $selection);
        // save image to destination
        imagejpeg($imageCroppedResource, "$destinationPath\\" . $imageName);
        // image url
        $imageUrl = url('resource/' . "$prefix/" . $imageName);

        return [
            'imgPathname' => $destinationPath . $imageName,
            'imgUrl' => $imageUrl
        ];
    }

    /**
     * generate image name
     *
     * @param  UploadedFile $imageFile
     * @param  string $prefix
     * @return array
     */
    protected function moveImage($imageFile, $prefix)
    {
        // destinationName
        $destinationPath = public_path('resource\\' . $prefix);
        // checkImage and get type
        $type = $this->checkImage($imageFile->getPathname());
        // generate image name
        $imageName = $this->generateImageName($prefix, $type);
        // move image to destination
        $movedImageFile = $imageFile->move($destinationPath, $imageName);
        // get movedImageFilePathname
        $movedImagePathname = $movedImageFile->getPathname();
        // url
        $movedImageUrl = url('resource/' . "$prefix/" . $imageName);

        return [
            'imgPathname' => $movedImagePathname,
            'imgUrl' => $movedImageUrl
        ];
    }

    /**
     * generate image name
     *
     * @param  string $prefix
     * @param  int $type
     * @return string
     * @throws Exception
     */
    protected function generateImageName($prefix, $type)
    {
        // extension
        $extension = null;

        // mux out image type
        switch ($type) {
            case IMAGETYPE_GIF  :
                $extension = 'gif';
                break;
            case IMAGETYPE_JPEG :
                $extension = 'jpg';
                break;
            case IMAGETYPE_PNG  :
                $extension = 'png';
                break;
            default             :
                throw new Exception("Image type $type not supported");
        }

        return $file_name = date('Y-m-d-H-i-s') . uniqid($prefix) . ".$extension";
    }

    /**
     * Check the image is real image file or not.
     *
     * @param  string $imgPathname
     * @return bool|int
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
        return $type;
    }

    /**
     * create image resource
     *
     * @param  string $imgPathname
     * @param  int $type
     * @return resource
     * @throws Exception
     */
    protected function createImageResource($imgPathname, $type)
    {
        // imageResource
        $imageResource = null;

        // create image resource
        switch ($type) {
            case IMAGETYPE_GIF  :
                $imageResource = imagecreatefromgif($imgPathname);
                break;
            case IMAGETYPE_JPEG :
                $imageResource = imagecreatefromjpeg($imgPathname);
                break;
            case IMAGETYPE_PNG  :
                $imageResource = imagecreatefrompng($imgPathname);
                break;
            default             :
                throw new Exception("Image type $type not supported");
        }

        // return resource
        return $imageResource;
    }
}