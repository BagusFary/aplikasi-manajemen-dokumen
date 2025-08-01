<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropColumn(['tokenable_id', 'tokenable_type']);
        });

        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->uuidMorphs('tokenable');
        });
    }

    public function down()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropColumn(['tokenable_id', 'tokenable_type']);
        });

        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->morphs('tokenable');
        });
    }
};
