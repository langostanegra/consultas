<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_credentials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cedula');
            $table->string('nombre', 80);
            $table->string('correo_institucional')->unique();
            $table->string('usuario_medellin')->unique();            
            $table->string('password_medellin', 80);
            $table->integer('estado');
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
        Schema::dropIfExists('check_credentials');
    }
}
