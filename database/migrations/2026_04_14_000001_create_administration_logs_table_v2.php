<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministrationLogsTableV2 extends Migration
{
    /**
     * Run the migrations.
     * Replaces the earlier administration_logs migration with a richer schema.
     * Categories: User, Group, Workflow, Report
     * Actions: Create, Update, Delete, Search, Export, View, Login, Logout
     *
     * @return void
     */
    public function up()
    {
        // Drop old table if it exists from the earlier migration
        if (!Schema::hasColumn('administration_logs', 'ip_address')) {
            Schema::table('administration_logs', function (Blueprint $table) {
                $table->string('section')->nullable()->after('category');  // Report, User, Group, Workflow
                $table->string('ip_address', 45)->nullable()->after('details');
                $table->string('user_agent')->nullable()->after('ip_address');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('administration_logs', function (Blueprint $table) {
            $table->dropColumn(['section', 'ip_address', 'user_agent']);
        });
    }
}
