<?php

namespace App\Http\Controllers;
use App\Models\User;

class HomeController extends Controller
{
   
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Dashboard';
        $total_user_count = User::count();
        return view('admin.dashboard',compact('title'))->with('user_count',$total_user_count);
    }
    public function ckImageUpload()
    {
        $url=  imageUploader(request()->upload,'uploads/ck-images',$isUrl = true);
        $CKEditorFuncNum = request()->input('CKEditorFuncNum');
        return response()->json(['fileName' => basename($url), 'uploaded'=> 1, 'url' => $url]);
    }

}

