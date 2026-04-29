<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE `settings` MODIFY `label` VARCHAR(191) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')
            ->whereNull('label')
            ->update(['label' => '']);

        DB::statement('ALTER TABLE `settings` MODIFY `label` VARCHAR(191) NOT NULL');
    }
};
