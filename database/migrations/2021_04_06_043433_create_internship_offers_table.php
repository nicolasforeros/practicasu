<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\InternshipOffer;

class CreateInternshipOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_offers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained();

            $table->string('position',100);
            $table->integer('duration_months');
            $table->string('type',50)->default(InternshipOffer::TYPES[0]);
            $table->string('schedule',50);
            $table->string('contact_phone',50);
            $table->string('contact_email',100);
            $table->integer('vacancies');
            $table->string('description',500);

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
        Schema::dropIfExists('internship_offers');
    }
}
