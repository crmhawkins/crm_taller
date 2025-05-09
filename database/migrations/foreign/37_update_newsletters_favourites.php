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
        Schema::table('newsletters_favourites', function (Blueprint $table) {
 
            $table->foreign('user_id')->references('id')->on('admin_user');
            $table->foreign('newsletter_id')->references('id')->on('newsletters');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
