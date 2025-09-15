<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $entities = [
            'user',
            'role',
            'permission',
            'client',
            'invoice',
            'estimate',
            'payment',
            'expense',
            'product',
            'setting',
            'report',
            'invoice-setting',
            'estimate-setting',
            'expense-category',
            'product-category',
            'payment-method',
            'payment-gateway',
            'tax-setting',
            'template',
            'currency',
            'email-setting',
            'number-setting',
            'language-manager',
            'profile',
            'locale'
        ];
        $permissionAction = [
            'view-all',
            'view',
            'create',
            'edit',
            'delete'
        ];
        $permissionDescription = [
            'view-all' => 'Allow user to view all ',
            'view' => 'Allow user to view ',
            'create' => 'Allow user to create ',
            'edit' => 'Allow user to edit ',
            'delete' => 'Allow user to delete '
        ];
        $additionalPermissions = [
            ['name'=>'invoice.download','description'=>'Allow user to download invoice'],
            ['name'=>'estimate.download','description'=>'Allow user to download estimate'],
            ['name'=>'estimate.make-invoice','description'=>'Allow user to make invoice from estimate'],
            ['name'=>'permission.assign','description'=>'Allow user to assign permission to role']
        ];
        //DB::table('permission_role')->delete();
        //DB::table('permissions')->delete();
        foreach ($entities as $entity) {
            foreach ($permissionAction as $action) {
                Permission::firstOrCreate(
                    ['name' => $entity.'.'.$action],
                    ['description' => $permissionDescription[$action].$entity]
                );
            }
            foreach ($additionalPermissions as $permission){
                Permission::firstOrCreate(
                    ['name' => $permission['name']],
                    ['description' => $permission['description']]
                );
            }
        }
    }
}