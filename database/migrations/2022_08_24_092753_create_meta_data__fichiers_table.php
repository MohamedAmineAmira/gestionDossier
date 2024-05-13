<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaDataFichiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_data__fichiers', function (Blueprint $table) {
            $table->id();
            $table->date('date_ech');
            $table->string('nom_fichier');
            $table->string('nom_type_fichier');
            $table->string('lien');
            $table->foreignId('dossier_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('meta_data__fichiers');
    }
}
