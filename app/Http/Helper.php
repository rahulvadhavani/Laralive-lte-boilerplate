<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

if (!function_exists('success')) {
    function success($message = "Success", $data = [])
    {
        $res = [
            'status' => true,
            'status_code' => 200,
            'message' => $message
        ];
        if (!empty($data)) {
            $res = [
                'status' => true,
                'status_code' => 200,
                'message' => $message,
                'data' => $data
            ];
        }
        return $res;
    }
}

if (!function_exists('error')) {
    function error($message = "Something went wrong!!", $data = [])
    {
        $res = [
            'status' => false,
            'status_code' => 400,
            'message' => $message,
            "data" => $data
        ];
        return $res;
    }
}

if (!function_exists('authError')) {
    function authError($message = "Unauthenticated")
    {
        $res = [
            'status' => false,
            'status_code' => 401,
            'message' => $message,
        ];
        return $res;
    }
}


function validatorError($validate)
{
    return response()->json(
        [
            'status' => false,
            'status_code' => 422,
            'message' => $validate->messages()->first(),
            'errors' => $validate->errors(),
        ],
        200
    );
}

function loginAndSignupSuccess($message, $tokenBody, $data = null) {
    $response = array_merge([
        'status' => true,
        'status_code' => 200,
        'message' => $message,
    ],$tokenBody);

    if (isset($data)) {
        $response = array_merge($response, [
            'data' =>$data,
        ]);
    }
    return response()->json($response);
}

if (!function_exists('imageUploader')) {
    function imageUploader($image, $filePath, $isUrl = false)
    {
        $path = public_path($filePath);
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        $imageName = basename($path) . '_' . time() . '.' . $image->extension();
        $image->move($path, $imageName);
        return $isUrl ? url($filePath, $imageName) : $filePath . $imageName;
    }
}

if (!function_exists('getSettings')) {
    function getSettings($key = "")
    {
        if (Cache::has('app_setting')) {
            $setting = Cache::get('app_setting');
        } else {
            $setting = Cache::rememberForever('app_setting', function () {
                return collect(Setting::get());
            });
        }
        if ($key != "") {
            $setting = $setting->where('key', $key)->first()->value ?? "";
            if ($key == 'logo_image') {
                $setting = $setting != "" ? asset('uploads/' . $setting) : asset('assets/images/logo.png');
            }
        }
        return $setting;
    }
}
