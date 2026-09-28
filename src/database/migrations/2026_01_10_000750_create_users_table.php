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
        Schema::create(table: 'users',
            callback: function (Blueprint $table): void {
                $table->uuid(column: 'id')->primary()->default(
                    value: DB::raw(value: 'uuidv7()')
                );

                $table->uuid(column: 'role_id');

                $table->string(column: 'first_name', length: 60);
                $table->string(column: 'last_name', length: 80);
                
                $table->string(column: 'avatar', length: 255)->nullable();

                $table->string(column: 'email', length: 244)->unique();
                $table->timestampTz(column: 'email_verified_at', precision: 6)->nullable();

                $table->string(column: 'phone', length: 20)->unique()->nullable();
                $table->timestampTz(column: 'phone_verified_at', precision: 6)->nullable();

                $table->string(column: 'bio', length: 255)->nullable();
                $table->boolean(column: 'is_active')->default(value: true);

                $table->string(column: 'password', length: 255);
                $table->timestampTz(column: 'password_changed_at', precision: 6)->nullable();

                $table->timestampTz(column: 'last_login_at', precision: 6)->nullable();
                $table->rememberToken();

                $table->timestamps(precision: 6);
                $table->softDeletes(precision: 6);
            }
        );

        Schema::table(table: 'users',
            callback: function (Blueprint $table): void {
                $table->comment(comment: 'Пользователи');

                $table->foreign(columns: 'role_id')
                    ->references(columns: 'id')
                    ->on(table: 'roles')
                    ->cascadeOnDelete();

                $table->index(columns: 'role_id');
                $table->index(columns: 'is_active');
                $table->index(columns: 'created_at');
                $table->index(columns: 'deleted_at');
            }
        );

        Schema::create(table: 'password_reset_tokens', 
            callback: function (Blueprint $table): void {
                $table->string(column: 'email', length: 244)->primary();
                $table->string(column: 'token', length: 255);
                $table->timestamp(column: 'created_at', precision: 6)->nullable();
            }
        );

        Schema::create(table: 'sessions', 
            callback: function (Blueprint $table): void {
                $table->uuid(column: 'id')->primary()->default(
                    DB::raw(value: 'uuidv7()')
                );
                $table->foreignUuid(column: 'user_id')->nullable()->index();
                $table->string(column: 'ip_address', length: 45)->nullable();
                $table->text(column: 'user_agent')->nullable();
                $table->longText(column: 'payload');
                $table->integer(column: 'last_activity')->index();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'users');
        Schema::dropIfExists(table: 'password_reset_tokens');
        Schema::dropIfExists(table: 'sessions');
    }
};
