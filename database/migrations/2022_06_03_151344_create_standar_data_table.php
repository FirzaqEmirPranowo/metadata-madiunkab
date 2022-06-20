<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandarDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standar_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Data::class, 'data_id')->constrained('data')->cascadeOnUpdate()->cascadeOnDelete();
            $table->longText('konsep')->nullable();
            $table->longText('definisi')->nullable();
            $table->longText('klasifikasi')->nullable();
            $table->longText('ukuran')->nullable();
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
        Schema::dropIfExists('standar_data');
    }
}
