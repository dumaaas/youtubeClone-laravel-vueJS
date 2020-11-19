<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('channel_id');
            $table->bigInteger('views')->default(0);
            $table->string('thumbnail')->nullable();
            $table->integer('percentage')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
