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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->comment('Usuario responsable');
            $table->foreign('user_id')->on('users')->references('id');

            $table->string('title')->comment('Título');
            $table->text('description')->nullable()->comment('Descripción');
            $table->date('due_date')->comment('Fecha límite');
            $table->enum('status', ['Pendiente', 'En progreso', 'Completada'])->default('Pendiente')->comment('Estado');
            $table->enum('priority', ['Baja', 'Media', 'Alta'])->nullable()->comment('Prioridad');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
