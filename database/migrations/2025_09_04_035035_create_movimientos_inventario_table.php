<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_inventario'); 
            $table->unsignedBigInteger('item_id');
            $table->string('tipo_movimiento'); 
            $table->integer('cantidad');
            $table->decimal('valor_unitario', 8, 2)->nullable();
            $table->decimal('valor_total', 8, 2)->nullable();
            $table->string('motivo')->nullable();
            $table->timestamp('fecha_movimiento')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};