<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pertes', function (Blueprint $table) {
            $table->timestamp('date_traitement')->nullable()->after('date_declaration');
        });
    }

    public function down()
    {
        Schema::table('pertes', function (Blueprint $table) {
            $table->dropColumn('date_traitement');
        });
    }
};
