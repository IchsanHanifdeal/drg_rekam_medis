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
        Schema::table('tindakan', function (Blueprint $table) {
            if (!Schema::hasColumn('tindakan', 'tooth_number')) {
                $table->string('tooth_number')->nullable()->after('biaya');
            }
            $table->string('tensi_darah')->nullable()->change();
            $table->string('berat_badan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tindakan', function (Blueprint $table) {
            if (Schema::hasColumn('tindakan', 'tooth_number')) {
                $table->dropColumn('tooth_number');
            }
            $table->string('tensi_darah')->nullable(false)->change();
            $table->string('berat_badan')->nullable(false)->change();
        });
    }
};
