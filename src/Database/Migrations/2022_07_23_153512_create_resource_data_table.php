<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_data', function (Blueprint $table) {
            $table->id();
            $table->string('controller')->unique();
            $table->string('model')->unique();
            $table->string('request')->unique();
            $table->string('resource')->unique();
            $table->string('migration')->unique();
            $table->string('views')->unique();
            $table->foreignId('table_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_data');
    }
};
