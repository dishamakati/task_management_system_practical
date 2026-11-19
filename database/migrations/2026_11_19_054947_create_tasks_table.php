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
            $table->string('title', 191);
            $table->text('description')->nullable();

            $table->unsignedBigInteger('assigned_by');
            $table->unsignedBigInteger('assigned_to');

            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();

            $table->unsignedTinyInteger('priority')
                  ->default(2)
                  ->comment('1 = Low, 2 = Medium, 3 = High, 4 = Urgent');

            $table->unsignedTinyInteger('status')
                  ->default(0)
                  ->comment('0 = Pending, 1 = In Progress, 2 = Completed, 3 = Cancelled');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assigned_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('assigned_to')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->index('assigned_to');
            $table->index('assigned_by');
            $table->index('status');
            $table->index('due_date');
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
