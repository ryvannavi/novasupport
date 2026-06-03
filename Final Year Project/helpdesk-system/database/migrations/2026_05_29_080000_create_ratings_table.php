<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('stars')->unsigned(); // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique('ticket_id'); // one rating per ticket
        });
    }
    public function down(): void {
        Schema::dropIfExists('ratings');
    }
};