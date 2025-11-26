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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->nullable();
            $table->integer('employee_id');
            $table->integer('shift_id')->nullable();
            $table->date('attendance_date');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->time('working_hours')->nullable();
            $table->time('late_by')->nullable();
            $table->time('early_by')->nullable();
            $table->time('overtime')->nullable();
            $table->string('punch_records')->nullable();
            $table->enum('status', ['present', 'absent', 'leave'])->default('absent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
