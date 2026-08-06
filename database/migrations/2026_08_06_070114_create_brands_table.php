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
        Schema::create('brands', function (Blueprint $table) {

            $table->id();

            $table->string('name', 150);

            $table->string('slug', 180)
                ->unique();

            $table->text('description')
                ->nullable();

            $table->string('logo')
                ->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->integer('sort_order')
                ->default(0);

            // SEO
            $table->string('seo_title')
                ->nullable();

            $table->text('seo_description')
                ->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
