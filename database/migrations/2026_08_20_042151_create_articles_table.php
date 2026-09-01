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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255);
            $table->string('titre', 255);
            $table->text('description');
            $table->longText('content')->nullable();
            $table->string('status', 255);
            $table->timestamp('datedecreation')->useCurrent();
            $table->string('image', 255)->nullable();
            $table->boolean('alaune')->default(false);
            $table->string('categorie', 100)->nullable()->change();
            $table->foreignId('categorie_principale_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};