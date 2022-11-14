<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    use HasFactory;
    public $fillable = ['slug','title','content_data'];
    const PAGES = ['about-us' => "About-Us",'terms-condition' =>'Terms & Condition','privacy-policy' =>'Privacy-Policy'];
}
