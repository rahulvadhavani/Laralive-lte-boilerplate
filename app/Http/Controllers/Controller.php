<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function FileUploadHelper($file,$folder) {
        if ($file) {
          $fileName = rand(1000000,9999999).time().uniqid().'.'.$file->extension();  
          if (!is_dir(public_path($folder))) {
            mkdir(public_path($folder),0755,true);
          }
          $file->move(public_path($folder), $fileName);
          return $folder.'/'.$fileName;
      }
  }

  function destroyFileHelper($image_path)
  {
      if(file_exists($image_path)){
          File::delete($image_path);
      }
  }
}
