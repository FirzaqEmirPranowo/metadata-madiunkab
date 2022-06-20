<?php

use App\Models\Data;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetadataIndikatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata_indikator', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Data::class, 'data_id')->constrained('data')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nama');
            $table->longText('konsep')->nullable();
            $table->longText('definisi')->nullable();
            $table->longText('interpretasi')->nullable();
            $table->longText('metode')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('satuan')->nullable();
            $table->longText('klasifikasi_penyajian')->nullable();
            $table->boolean('komposit')->default(0);
            $table->longText('publikasi_indikator_pembangun')->nullable();
            $table->string('nama_indikator_pembangun')->nullable();
            $table->string('kegiatan_variabel_pembangun')->nullable();
            $table->string('kode_kegiatan_variabel_pembangun')->nullable();
            $table->string('nama_variabel_pembangun')->nullable();
            $table->string('level_estimasi')->nullable();
            $table->boolean('umum')->default(1);
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
        Schema::dropIfExists('metadata_indikator');
    }
}
