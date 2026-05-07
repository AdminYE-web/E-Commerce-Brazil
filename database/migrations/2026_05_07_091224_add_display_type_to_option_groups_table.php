<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('option_groups', function (Blueprint $table) {
            $table->string('display_type')
                ->default('button')
                ->after('group_name');

            $table->boolean('is_required')
                ->default(true)
                ->after('display_type');

           
        });
    }

    public function down(): void
    {
        Schema::table('option_groups', function (Blueprint $table) {
            $table->dropColumn([
                'display_type',
                'is_required'
            ]);
        });
    }
};