<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->string('course');
            $table->string('branch');
            $table->integer('semester');
            $table->string('academic_year');
            $table->decimal('tuition_fee', 10, 2)->default(0);
            $table->decimal('exam_fee',    10, 2)->default(0);
            $table->decimal('library_fee', 10, 2)->default(0);
            $table->decimal('lab_fee',     10, 2)->default(0);
            $table->decimal('hostel_fee',  10, 2)->default(0);
            $table->decimal('other_fee',   10, 2)->default(0);
            $table->decimal('total_fee',   10, 2)->default(0);
            $table->date('due_date');
            $table->timestamps();
            $table->unique(['course','branch','semester','academic_year']);
        });
    }
    public function down(): void { Schema::dropIfExists('fee_structures'); }
};
