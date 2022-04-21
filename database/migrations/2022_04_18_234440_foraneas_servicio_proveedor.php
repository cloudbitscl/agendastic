<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForaneasServicioProveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicios_proveedores',function(Blueprint $table){
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicios_proveedores',function(Blueprint $table){
            $table->dropForeign(['servicio_id']);
            $table->dropForeign(['proveedor_id']);
        });
    }
}
