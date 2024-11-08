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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug");
            $table->text("image");
            $table->string("telephone");
            $table->string("localisation");
            $table->string("storeID");
            $table->string("tokenApi");
            $table->text("Primary");
            $table->text("Secondary");
            $table->text("image1");
            $table->text("image2");
            $table->text("quartiers");
            $table->text("quartiers_Permitted");
            $table->boolean("visible")->default(true);
            $table->string("avis");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
