<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 65);
            $table->string('email');
            $table->string('telefone', 10);
            $table->string('cargo', 255);
            $table->integer('escolaridade');
            $table->text('observacoes')->nullable();
            $table->string('arquivo');
            $table->dateTime('data_envio');
            $table->ipAddress();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
