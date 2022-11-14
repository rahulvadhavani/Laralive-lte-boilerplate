<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_contents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blog_id')->unsigned()->index();
            $table->string('seo_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('blog_body')->nullable();
            $table->text('tags')->nullable();
            $table->timestamps();
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_contents');
    }
}
