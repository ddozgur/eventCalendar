<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->unsignedBigInteger('user_id');
            $table->string('rating');
            $table->timestamp('start');
            $table->timestamp('end');
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
