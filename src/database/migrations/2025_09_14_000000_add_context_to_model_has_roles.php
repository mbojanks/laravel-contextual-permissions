<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table(config('permission.table_names.model_has_roles'), function (Blueprint $table) {
            $table->string('context_type')->nullable()->after('model_id');
            $table->unsignedBigInteger('context_id')->nullable()->after('context_type');

            $table->index(['context_type', 'context_id'], 'model_has_roles_context_index');
        });
    }

    public function down(): void
    {
        Schema::table(config('permission.table_names.model_has_roles'), function (Blueprint $table) {
            $table->dropColumn(['context_type', 'context_id']);
        });
    }
};
