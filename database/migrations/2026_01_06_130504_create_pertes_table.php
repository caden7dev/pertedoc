<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pertes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('type_piece_id')->constrained('types_pieces')->onDelete('cascade');
            $table->string('numero_piece')->nullable(); // Numéro de la pièce perdue
            $table->date('date_perte'); // Date de la perte
            $table->string('lieu_perte'); // Lieu de la perte
            $table->text('description')->nullable(); // Circonstances de la perte
            $table->enum('statut', ['en_attente', 'validee', 'rejetee'])->default('en_attente');
            $table->text('motif_rejet')->nullable(); // Raison du rejet si rejetée
            $table->string('numero_declaration')->unique(); // Numéro unique de déclaration
            $table->timestamp('validated_at')->nullable(); // Date de validation/rejet
            $table->foreignId('validated_by')->nullable()->constrained('users'); // Agent qui a validé
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index('statut');
            $table->index('date_perte');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertes');
    }
};