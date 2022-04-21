<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('cliente_id');
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->text('notas')->nullable();
            $table->text('motivo_cancelacion')->nullable();
            $table->timestamps();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
