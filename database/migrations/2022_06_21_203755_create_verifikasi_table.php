<?php

use App\Models\Data;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Data::class, 'data_id')->constrained('data')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('field');
            $table->boolean('accepted')->default(1);
            $table->string('category')->nullable();
            $table->longText('comment')->nullable();
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
        Schema::dropIfExists('verifikasi');
    }
}
