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

function loginAndSignupSuccess($message, $tokenBody, $data = null)
{
    $response = array_merge([
        'status' => true,
        'status_code' => 200,
        'message' => $message,
    ], $tokenBody);

    if (isset($data)) {
        $response = array_merge($response, [
            'data' => $data,
        ]);
    }
    return response()->json($response);
}

if (!function_exists('imageUploader')) {
    function imageUploader($image, $filePath, $isUrl = false, $storeAs = null)
    {
        $path = public_path($filePath);
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        $imageName = $storeAs === null ? basename($path) . '_' . time() . '.' . $image->extension() : $storeAs;
        $imageName = $image->storeAs($filePath . '/' . $imageName, '', 'userPublic');
        return $isUrl ? url($imageName) : $imageName;
    }
}
if (!function_exists('unlinkFile')) {
    function unlinkFile($path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
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
                $setting = ($setting != "" && File::exists(public_path($setting))) ? asset($setting) : asset('assets/images/logo.png');
            }
        }
        return $setting;
    }
}
