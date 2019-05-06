<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class Upload
{
    private $imageExtension = ['jpg', 'jpeg', 'png', 'gif'];
    private $audioExtension = ['mp3', 'ogg', 'mpga'];
    private $videoExtension = ['mp4', 'mpeg'];

    /**
     * file Upload
     *
     * @return string
     */
    public function File($request, $path)
    {
        $maxSize = (int)ini_get('upload_max_filesize') * 1024;
        $allExtension = implode(',', $this->allExtensions());
        $validator = Validator::make(
            $request->all(),
            ['file' => 'required|file|mimes:' . $allExtension . '|max:' . $maxSize],
            [
                'file.required' => config('constants.error.file.required'),
                'file.mimes' => config('constants.error.file.mime'),
                'file.max' => config('constants.error.file.size'),
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->errors();
            $message = $messages->first();
            return response()->json(["status" => false, "error_code" => $message]);
        }
        
        $file = $request->file('file');
        $size = $file->getSize();
        $ext = $file->getClientOriginalExtension();
        $type = $this->getType($ext);
        $destinationPath = $type . '/'  . $path . '/';
        $storage = Storage::disk('public')->put($destinationPath, $file);
        if (!$storage) {
            return response()->json(["status" => false]);
        }
        $name = md5(time() . uniqid()) . '.' . strtolower($ext);
        Storage::disk('public')->move($storage, $destinationPath . $name);
        $path = 'uploads/' . $destinationPath . $name;
        return ["status" => true, "path" => $path, 'type' => $type, 'size' => $size];
    }

    /**
     * Get type by extension
     * @param  string $ext Specific extension
     * @return string      Type
     */
    private function getType($ext)
    {
        if (in_array($ext, $this->imageExtension)) {
            return 'images';
        }

        if (in_array($ext, $this->audioExtension)) {
            return 'audios';
        }

        if (in_array($ext, $this->videoExtension)) {
            return 'videos';
        }
    }

    /**
     * Get all extensions
     * @return array Extensions of all file types
     */
    public function allExtensions()
    {
        return array_merge($this->imageExtension, $this->audioExtension, $this->videoExtension);
    }
}
