<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;
use Modules\Medical\Entities\Appointment;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('patient_id');
            $table->string('visit_type');
            $table->date('date');
            $table->time('time')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', Appointment::$statuses);
            $table->string('canceled_log')->nullable();
            $table->enum('type_of_payment', Appointment::$paymentTypes)->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->float('discount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
