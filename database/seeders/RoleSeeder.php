<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Owner',
                'slug' => Role::OWNER,
                'description' => 'Full system control',
            ],
            [
                'name' => 'Admin',
                'slug' => Role::ADMIN,
                'description' => 'Operational control',
            ],
            [
                'name' => 'Vendor Manager',
                'slug' => Role::VENDOR_MANAGER,
                'description' => null,
            ],
            [
                'name' => 'Finance Manager',
                'slug' => Role::FINANCE_MANAGER,
                'description' => null,
            ],
            [
                'name' => 'Support Executive',
                'slug' => Role::SUPPORT_EXECUTIVE,
                'description' => null,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
