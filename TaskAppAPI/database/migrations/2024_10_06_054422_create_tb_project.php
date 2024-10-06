<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProject extends Migration
{
    public function up()
    {
        Schema::create('tb_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->boolean('is_complete')->default(false);
            $table->timestamps();
            $table->string('created_by', 255);
            $table->string('updated_by', 255);
            $table->integer('update_count');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_project');
    }
}
