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
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('declaration_id'); // lien avec déclaration
    $table->string('nom_fichier'); // nom original
    $table->string('chemin_fichier'); // chemin stockage
    $table->timestamps();

    $table->foreign('declaration_id')->references('id')->on('declarations')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
