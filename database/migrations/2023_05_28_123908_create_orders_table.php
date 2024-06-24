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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("num");
            $table->string("nom");
            $table->string("prenom");
            $table->string("email");
            $table->string("adress");
            $table->string("telephone");
            $table->string("status")->default("waiting");
            $table->string("payed")->default("non");
            $table->text("notes");
            $table->string("delivery_type");
            $table->string("region");
            $table->boolean("use_whatsapp")->default(false);
            $table->decimal("total")->nullable();
            $table->string("restau");
            $table->foreignId("user_id")->nullable()->constrained();
            $table->foreignId("restau_id")->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
