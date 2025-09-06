<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('materias_primas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('costo_unitario', 8, 2);
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_minimo')->default(0);
            $table->string('unidad_medida')->default('kg');
            $table->date('fecha_vencimiento')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materias_primas');
    }
};