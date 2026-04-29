<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (! Schema::hasColumn('settings', 'display_name')) {
                $table->string('display_name', 191)->nullable()->after('key');
            }

            if (! Schema::hasColumn('settings', 'details')) {
                $table->json('details')->nullable()->after('type');
            }

            if (! Schema::hasColumn('settings', 'order')) {
                $table->unsignedInteger('order')->default(0)->index()->after('details');
            }
        });

        DB::table('settings')
            ->orderBy('id')
            ->get()
            ->each(function (object $setting): void {
                $details = null;

                if (! empty($setting->description)) {
                    $details = json_encode(['help' => $setting->description], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }

                DB::table('settings')
                    ->where('id', $setting->id)
                    ->update([
                        'display_name' => $setting->display_name ?: $setting->label,
                        'details' => $setting->details ?: $details,
                        'order' => $setting->order ?? $setting->sort_order ?? 0,
                    ]);
            });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropUnique('settings_group_key_unique');
            $table->unique('key', 'settings_key_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropUnique('settings_key_unique');
            $table->unique(['group', 'key']);
            $table->dropColumn(['display_name', 'details', 'order']);
        });
    }
};
