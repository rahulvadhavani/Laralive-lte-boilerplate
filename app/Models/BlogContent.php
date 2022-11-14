<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogContent extends Model
{
    use HasFactory;

    protected $fillable = ['blog_id','seo_title','meta_description','blog_body','tags'];

    public function blog(){
        return $this->hasOne(Blog::class);
    }

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode(explode(',',$value));
    }
    public function getTagsAttribute($value)
    {
        return json_decode($value,true);
    }
}
