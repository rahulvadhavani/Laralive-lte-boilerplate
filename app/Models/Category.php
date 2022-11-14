<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','alias','status'];

    public function setNameAttribute($name){
        $this->attributes['name']= $name;
        $this->attributes['alias'] = \Str::slug($this->name , "-");
    }

    public static function getCategories(){
        return self::where('status',1)->get()->toArray();
    }
    
    public function blog(){
        return $this->belongsTo(Blog::class,'id','blog_id');
    }
}
