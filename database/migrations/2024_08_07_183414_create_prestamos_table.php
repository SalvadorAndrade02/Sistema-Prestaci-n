<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('area', 100);
            $table->string('nombreRecibe', 100);
            $table->string('articulo', 100);
            $table->integer('cantidadPresta');
            $table->date('fechaSalida');
            $table->date('fechaRegreso');
            $table->string('observacion', 200);
            $table->string('uso', 100);
            $table->timestamps();
        });

        // Resetear el auto-incremento
        DB::statement('ALTER TABLE prestamos AUTO_INCREMENT = 1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
?>