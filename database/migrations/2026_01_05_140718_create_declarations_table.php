<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up(): void
{
    Schema::create('declarations', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // lien avec l'utilisateur
        $table->string('type_piece');
        $table->string('numero_piece')->nullable();
        $table->string('nom_piece');
        $table->string('prenom_piece');
        $table->date('date_delivrance')->nullable();
        $table->string('lieu_delivrance')->nullable();
        $table->string('autorite_delivrance')->nullable();
        $table->date('date_perte');
        $table->string('lieu_perte');
        $table->text('circonstances');
        $table->string('type_perte')->nullable(); // vol / perte / destruction
        $table->string('statut')->default('En attente'); // En attente / Validée / Rejetée
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('declarations');
    }
}
