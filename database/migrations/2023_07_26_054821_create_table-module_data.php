<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_data', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('module_title', 200);
            $table->json('params');
            $table->json('values');
            $table->tinyInteger('hidden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('module_data');
    }
};
