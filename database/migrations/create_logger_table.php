<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('logger_table', function (Blueprint $table) {
            $table->id();
            $table->text('message')->nullable();
            $table->string('channel')->nullable();
            $table->enum('level', ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'])->index();
            $table->longText('context')->nullable();
            $table->text('extra')->nullable();
            $table->dateTime('logged_at')->nullable();
            $table->timestamps();
        });
    }

        /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logger_table');
      
    }
};
