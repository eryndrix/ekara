<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds for roles table.
     */
    public function run(): void
    {
        $role = DB::table(table: 'roles')
            ->where(column: 'slug', operator: '=', value: 'admin')
            ->first();

         if (!$role) {
            throw new \RuntimeException(
                message: 'Role "admin" not found.'
            );
        }

        $now = Carbon::now();

        DB::table(table: 'users')->insert(values: [
            'role_id' => $role->id,
            'avatar' => null,
            'first_name' => 'Test',
            'last_name' => 'Admin',
            'email' => 'admin@mail.ru',
            'email_verified_at' => $now,
            'phone' => '+79990000000',
            'phone_verified_at' => $now,
            'password' => Hash::make(value: '0>pzX;|3&CRoN8*U_'),
            'password_changed_at' => $now,
            'remember_token' => Str::random(length: 60),
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
