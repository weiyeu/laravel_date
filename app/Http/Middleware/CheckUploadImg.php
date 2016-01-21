<?php

namespace App\Http\Middleware;

use Closure;
use App\Library\ImageProcessor;

class CheckUploadImg
{
    use ImageProcessor;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // ajax upload
        if ($request->ajax()) {
            // check upload image
            if (!$request->hasFile('uploadImg')) {
                // return json data with error message noImgUpload
                return response()->json(['error' => 'noUploadImg']);
            } else if (!$this->checkImage($request->file('uploadImg'))) {
                // return json data with error message wrongImgType
                return response()->json(['error' => 'wrongImgType']);
            }
        } // html form upload
        else {
            // check has uploadImg or not
            if ($request->hasFile('uploadImg')) {
                // check image content
                if (!$this->checkImage($request->file('uploadImg'))) {
                    // check fail, redirect back with errors
                    return back()
                        ->withInput($request->except('uploadImg'))
                        ->withErrors('小搗蛋 大頭貼只能選圖片唷:)');
                }
            }
        }

        // pass all check
        return $next($request);
    }
}
