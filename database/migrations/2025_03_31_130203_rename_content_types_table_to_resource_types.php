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
        Schema::rename('content_types', 'resource_types');
        Schema::table('resources', function (Blueprint $table) {
            $table->renameColumn('content_type_id', 'resource_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('resource_types', 'content_types');
        Schema::table('resources', function (Blueprint $table) {
            $table->renameColumn('resource_type_id', 'content_type_id');
        });
    }
};
