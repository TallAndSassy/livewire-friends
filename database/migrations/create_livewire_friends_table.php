<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivewireFriendsTable extends Migration
{
    public function up()
    {
        Schema::create('livewire-friends', function (Blueprint $table) {
            $table->bigIncrements('id');

            // add fields
            $table->string('name')->comment("Name of Guy");//

            $table->timestamps();
        });
    }
}
