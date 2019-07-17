<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('documents', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_extension');
            $table->string('file_mime_type');
            $table->string('file_size');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('documents');
    }
}
