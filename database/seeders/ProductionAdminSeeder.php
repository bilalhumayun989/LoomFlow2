<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class ProductionAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = trim((string) config('app.initial_admin.name'));
        $email = trim((string) config('app.initial_admin.email'));
        $password = (string) config('app.initial_admin.password');

        if ($name === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false || strlen($password) < 12) {
            throw new RuntimeException('Set LOOMFLOW_INITIAL_ADMIN_NAME, LOOMFLOW_INITIAL_ADMIN_EMAIL, and a password of at least 12 characters in .env before running this seeder.');
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        if ($user->wasRecentlyCreated) {
            $this->command?->info("Initial administrator created: {$email}");

            return;
        }

        if ($user->role !== 'admin') {
            throw new RuntimeException("The email {$email} already belongs to a non-admin account. Choose another initial admin email.");
        }

        $this->command?->info("Administrator account already exists: {$email}");
    }
}
