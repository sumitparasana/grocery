<?php

namespace App\Helpers;

class Helper {

    public static function fileUploadApi($path,$file)
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $imageName = time().'.'.$file->getClientOriginalExtension();
        $file->move(base_path().'/public/'.$path,$imageName);

        $data = [
            'url' => url('/').'/'.$path.'/'.$imageName,
            'image_name' => $imageName
        ];
        return $data;
    }

    public static function getEmployeeStatus($id=0){

    }
}
