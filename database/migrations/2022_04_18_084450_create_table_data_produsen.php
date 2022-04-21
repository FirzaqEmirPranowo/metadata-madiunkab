<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDataProdusen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_produsen', function (Blueprint $table) {
            $table->id();
            $table->integer('opd_id');
            $table->text('nama_data');
            $table->string('jenis_data', 255);
            $table->string('sumber_data', 255);
            $table->boolean('prioritas');
            $table->string('status', 255);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_data_produsen');
    }
}
