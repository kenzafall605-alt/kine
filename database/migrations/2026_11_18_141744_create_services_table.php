
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_category_id')
                ->constrained('service_categories')
                ->restrictOnDelete();

            $table->string('nom');
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2);
            $table->unsignedSmallInteger('duree_minutes');
            $table->boolean('actif')->default(true);

            $table->timestamps();

            $table->unique(['service_category_id', 'nom']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
