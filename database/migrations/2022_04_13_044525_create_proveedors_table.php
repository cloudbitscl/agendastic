<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('razon_social')->nullable();
            $table->string('identificador')->nullable();
            $table->string('email_privado')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono_privado')->nullable();
            $table->string('telefono')->nullable();
            $table->string('descripcion_corta')->nullable();
            $table->text('descripcion')->nullable();
            $table->json('disponibilidad')->nullable();
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
        Schema::dropIfExists('proveedores');
    }
}
