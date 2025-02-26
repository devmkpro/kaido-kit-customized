<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    /**
     * Lista dos modelos para os quais as permissões padrão serão geradas.
     */
    private array $models = ['User'];

    /**
     * Definição das roles com:
     * - 'models': modelos para os quais gerar as permissões padrão. Use ['all'] para todos.
     * - 'custom_permissions': permissões adicionais necessárias.
     */
    private array $roles = [
        'super_admin' => [
            'models'            => ['all'], // Recebe todas as permissões dos modelos em $models
            'custom_permissions'=> [
                'view_role',
                'view_any_role',
                'create_role',
                'update_role',
                'delete_role',
                'delete_any_role',
                'view_token',
                'view_any_token',
                'create_token',
                'update_token',
                'restore_token',
                'restore_any_token',
                'replicate_token',
                'reorder_token',
                'delete_token',
                'delete_any_token',
                'force_delete_token',
                'force_delete_any_token',
                'view_user',
                'view_any_user',
                'create_user',
                'update_user',
                'restore_user',
                'restore_any_user',
                'replicate_user',
                'reorder_user',
                'delete_user',
                'delete_any_user',
                'force_delete_user',
                'force_delete_any_user',
                'page_ManageSetting',
                'page_MyProfilePage',
            ],
        ],
        
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $this->createRolesAndPermissions();
    }

    /**
     * Cria roles e associa as permissões (dinâmicas e customizadas).
     */
    protected function createRolesAndPermissions(): void
    {
        $roleModel       = Utils::getRoleModel();
        $permissionModel = Utils::getPermissionModel();

        foreach ($this->roles as $roleName => $data) {
            // Define os modelos: se for ['all'], pega todos os modelos da propriedade
            $models = ($data['models'] === ['all']) ? $this->models : $data['models'];

            // Gera permissões padrão para os modelos
            $dynamicPermissions = $this->generatePermissions($models);

            // Mescla com as permissões customizadas definidas para a role
            $allPermissions = array_merge($dynamicPermissions, $data['custom_permissions']);

            // Cria (ou pega) a role
            $role = $roleModel::firstOrCreate([
                'name'       => $roleName,
                'guard_name' => 'web',
            ]);

            // Cria (ou pega) as permissões e associa à role
            $permissionModels = collect($allPermissions)->map(function ($permission) use ($permissionModel) {
                return $permissionModel::firstOrCreate([
                    'name'       => $permission,
                    'guard_name' => 'web',
                ]);
            })->all();

            $role->syncPermissions($permissionModels);
        }
    }

    /**
     * Gera as permissões padrão para os modelos informados.
     */
    private function generatePermissions(array $models): array
    {
        $actions = [
            'view', 'view_any', 'create', 'update',
            'restore', 'restore_any', 'replicate', 'reorder',
            'delete', 'delete_any', 'force_delete', 'force_delete_any'
        ];
    
        return collect($models)->flatMap(function ($model) use ($actions) {
            $modelName = strtolower($model);
            return collect($actions)->map(function ($action) use ($modelName) {
                return "{$action}_{$modelName}";
            });
        })->toArray();
    }
    
}
