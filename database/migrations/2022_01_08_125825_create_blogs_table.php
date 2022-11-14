<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->index();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('title',255);
            $table->string('slug',255)->nullable();
            $table->text('subtitle')->nullable();
            $table->string('image_thumbnail',255)->nullable();
            $table->tinyInteger('status')->default('0')->comment('0 = pending, 1 = active, 2 = reject');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
