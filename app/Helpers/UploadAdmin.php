<?php

namespace App\Helpers;

class UploadAdmin
{
    public function image($image, $path)
    {
        $fileName = '';
        try {
            list($ext, $data)   = explode(';', $image);
            list(, $data)       = explode(',', $data);
            $data = base64_decode($data);
            $fileName = mt_rand() . time() . '.jpg';
            file_put_contents('uploads/images/' . $path . '/' . $fileName, $data);
            return 'uploads/images/' . $path . '/' . $fileName;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
