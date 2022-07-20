<?php

use App\Models\Data;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Data::class, 'data_id')->nullable()->constrained('data')->nullOnDelete()->cascadeOnUpdate();
            $table->uuid('org_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('visibility')->nullable();
            $table->mediumText('slug')->nullable();
            $table->string('dataset_id')->nullable();
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('publikasi');
    }
}
