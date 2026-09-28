<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table: 'notifications',
            callback: function (Blueprint $table): void {
                $table->uuid(column: 'id')->primary()->default(
                    value: DB::raw(value: 'uuidv7()')
                );

                $table->string(column: 'type');
                $table->uuidMorphs(name: 'notifiable');
                $table->jsonb(column: 'data');
                $table->timestampTz(column: 'read_at', precision: 6)->nullable();
                $table->timestampsTz(precision: 6);
            }
        );

        Schema::table(table: 'notifications',
            callback: function (Blueprint $table): void {
                $table->comment(comment: 'Уведомления');
                $table->index(columns: 'read_at');
                $table->index(columns: 'created_at');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'notifications');
    }
};
