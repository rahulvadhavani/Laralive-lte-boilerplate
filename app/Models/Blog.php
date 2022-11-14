<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','user_id','title','slug','subtitle','image_thumbnail','status','created_at'];

    // public function setTitleAttribute($name){
    //     $this->attributes['title']= $name;
    //     $this->attributes['slug'] = \Str::slug($this->name , "-");
    // }
    public function getImageThumbnailAttribute($value){
        return app()->environment('local') ? url('uploads/'.$value) : url('public/uploads/'.$value);
        // return url('public/uploads/'.$value);
    }
    
    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d ,F Y');
    }

    public function blogContent(){
        return $this->belongsTo(BlogContent::class,'id','blog_id');
    }
    public function Category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function User(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function comments(){
        return $this->hasMany(BlogComment::class);
    }
    public function likes(){
        return $this->hasMany(BlogLike::class);
    }

}
