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
        Schema::create('cloture_caisses', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("restau");
            $table->string("date");
            $table->string("time");
            $table->string("responsable");
            $table->float("montant");
            $table->float("montantE");
            $table->float("cartebancaire");
            $table->float("cartebancaireLivraison");
            $table->float("virement");
            $table->float("cheque");
            $table->float("compensation");
            $table->float("familleAcc");
            $table->float("erreurPizza");
            $table->float("erreurCuisine");
            $table->float("erreurServeur");
            $table->float("erreurCaisse");
            $table->float("giveawayPizza");
            $table->float("giveawayPasta");
            $table->float("glovoC");
            $table->float("glovoE");
            $table->float("appE");
            $table->float("appC");
            $table->float("shooting");
            $table->float("ComGlovo");
            $table->float("ComLivraison");
            $table->string("signature");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloture_caisses');
    }
};
