<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateMoviesTable extends Migration
{


    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->integer('show_id');
            $table->string('type');
            $table->string('title');
            $table->string('director')->nullable();
            $table->text('cast')->nullable();
            $table->string('country')->nullable();
            $table->date('date_added')->nullable(); // تأكد من أن النوع هو DATE
            $table->integer('release_year');
            $table->string('rating');
            $table->string('duration');
            $table->string('listed_in');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
