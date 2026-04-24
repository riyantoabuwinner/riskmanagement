<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UnitTypesTableSeeder::class,
            UnitsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RoleHasPermissionsTableSeeder::class,
            UsersTableSeeder::class,
            ModelHasRolesTableSeeder::class,
            RiskCategoriesTableSeeder::class,
            PerformanceIndicatorsTableSeeder::class,
            RisksTableSeeder::class,
            MitigationsTableSeeder::class,
            RiskMonitoringTableSeeder::class,
        ]);
    }
}
