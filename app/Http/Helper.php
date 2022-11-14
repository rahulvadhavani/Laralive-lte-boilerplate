<?php

use App\Models\Setting;
use Illuminate\Support\Facades\File;

if(!function_exists('success')){
    function success($message = "Success",$data= [])
    {
        $res = ['status' => true,  'message' => $message, 'code' => 200];
        if(!empty($data)){
            $res = ['status' => true,  'message' => $message,'data' => $data, 'code' => 200];
        }
        return $res;
    }
}
if(!function_exists('error')){
    function error($message = "Something went wrong!!",$data=[])
    {
        $res = ['status' => false,  'message' => $message,"data"=>$data, 'code' => 400];
        return $res;
    }
}
if(!function_exists('authError')){
    function authError($message = "Unauthenticated")
    {
        $res = ['status' => false,  'message' => $message, 'code' => 401];
        return $res;
    }
}


if(!function_exists('imageUploader')){
    function imageUploader($image,$filePath,$isUrl = false)
    {
        $path = public_path($filePath);
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        $imageName = basename($path).'_'.time().'.'.$image->extension();
        $image->move($path, $imageName);
        return $isUrl ? url($filePath,$imageName) : $filePath.$imageName;
    }
}

if(!function_exists('getSettings')){
    function getSettings($key ="")
    {
        $value = "";
        if($key == ""){
            return $value;
        }
        $Settings =  Setting::where('key',$key)->first();
        $value = $Settings->value;
        if($key == 'logo_image'){
            $value = asset('uploads/'.$Settings->value);
        }
        return $value;
    }
}
?>