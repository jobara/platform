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
        Schema::table('regulated_organizations', function (Blueprint $table) {
            $table->string('preferred_contact_language')
                ->nullable()
                ->after('preferred_contact_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regulated_organizations', function (Blueprint $table) {
            $table->dropColumn('preferred_contact_language');
        });
    }
};
