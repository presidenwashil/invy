<?php

declare(strict_types=1);

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

final class ShieldSeeder extends Seeder
{
    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_category","view_any_category","create_category","update_category","restore_category","restore_any_category","replicate_category","reorder_category","delete_category","delete_any_category","force_delete_category","force_delete_any_category","view_handover","view_any_handover","create_handover","update_handover","restore_handover","restore_any_handover","replicate_handover","reorder_handover","delete_handover","delete_any_handover","force_delete_handover","force_delete_any_handover","view_withdrawal","view_any_withdrawal","create_withdrawal","update_withdrawal","restore_withdrawal","restore_any_withdrawal","replicate_withdrawal","reorder_withdrawal","delete_withdrawal","delete_any_withdrawal","force_delete_withdrawal","force_delete_any_withdrawal","view_inventory","view_any_inventory","create_inventory","update_inventory","restore_inventory","restore_any_inventory","replicate_inventory","reorder_inventory","delete_inventory","delete_any_inventory","force_delete_inventory","force_delete_any_inventory","view_item","view_any_item","create_item","update_item","restore_item","restore_any_item","replicate_item","reorder_item","delete_item","delete_any_item","force_delete_item","force_delete_any_item","view_item::history","view_any_item::history","create_item::history","update_item::history","restore_item::history","restore_any_item::history","replicate_item::history","reorder_item::history","delete_item::history","delete_any_item::history","force_delete_item::history","force_delete_any_item::history","view_loan","view_any_loan","create_loan","update_loan","restore_loan","restore_any_loan","replicate_loan","reorder_loan","delete_loan","delete_any_loan","force_delete_loan","force_delete_any_loan","view_receiving","view_any_receiving","create_receiving","update_receiving","restore_receiving","restore_any_receiving","replicate_receiving","reorder_receiving","delete_receiving","delete_any_receiving","force_delete_receiving","force_delete_any_receiving","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_staff","view_any_staff","create_staff","update_staff","restore_staff","restore_any_staff","replicate_staff","reorder_staff","delete_staff","delete_any_staff","force_delete_staff","force_delete_any_staff","view_unit","view_any_unit","create_unit","update_unit","restore_unit","restore_any_unit","replicate_unit","reorder_unit","delete_unit","delete_any_unit","force_delete_unit","force_delete_any_unit","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","view_warehouse","view_any_warehouse","create_warehouse","update_warehouse","restore_warehouse","restore_any_warehouse","replicate_warehouse","reorder_warehouse","delete_warehouse","delete_any_warehouse","force_delete_warehouse","force_delete_any_warehouse","widget_StatsOverview","widget_ItemsChart"]}]';
        $directPermissions = '[]';

        self::makeRolesWithPermissions($rolesWithPermissions);
        self::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }
}
