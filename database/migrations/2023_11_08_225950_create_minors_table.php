<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('minors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('university_id');
            $table->string("city")->nullable(false);
            $table->text('specifics')->comment('Additional data for the specifics of the programme')->nullable(true);
            // TODO: Redo the accommodation in possibly another table
            $table->text('accommodation')->nullable(true);
            $table->date('semester_start')->comment('Approximate date that the semester starts')->nullable(true);
            $table->date('semester_end')->comment('Approximate date that the semester ends')->nullable(true);
            $table->decimal('lower_living_expense', 9, 3)->nullable(true);
            $table->decimal('higher_living_expense', 9, 3)->nullable(true);
            $table->text('prerequisites')->nullable(true);

            $table->foreign('university_id')->references('id')->on('universities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minors');
    }
};
