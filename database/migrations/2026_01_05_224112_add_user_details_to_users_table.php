<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserDetailsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('last_name')->after('name');
        $table->string('first_name')->after('last_name');
        $table->string('contact')->nullable()->after('email');
        $table->string('address')->nullable()->after('contact');
        $table->date('birth_date')->nullable()->after('address');
        $table->enum('gender', ['male', 'female'])->nullable()->after('birth_date');
        $table->string('nationality')->nullable()->after('gender');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn([
            'last_name', 
            'first_name', 
            'contact', 
            'address', 
            'birth_date', 
            'gender', 
            'nationality'
        ]);
        });
    }
}
