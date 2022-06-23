<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Create permissions.
     * @author   Herbert Santos<herbert.aga@gmail.com>
     * @return void
     */
    public function run()
    {
        $permissionsAvailable = array(
            array(
                'name'       => 'account.balance.list',
                'guard_name' => 'api',
                'group'      => 'account',
                'action'     => 'list',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
                'role'       => 2,
            ),
            array(
                'name'       => 'account.balance.deposit',
                'guard_name' => 'api',
                'group'      => 'account',
                'action'     => 'deposit',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
                'role'       => 2,
            ),
            array(
                'name'       => 'account.buy',
                'guard_name' => 'api',
                'group'      => 'account',
                'action'     => 'buy',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
                'role'       => 2,
            ),
            array(
                'name'       => 'account.balance.approve',
                'guard_name' => 'api',
                'group'      => 'account',
                'action'     => 'approve',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
                'role'       => 1,
            ),
            array(
                'name'       => 'account.balance.decline',
                'guard_name' => 'api',
                'group'      => 'account',
                'action'     => 'decline',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
                'role'       => 1,
            ),
        );

        foreach($permissionsAvailable as $permission){
            $role = Role::findById($permission['role'],'api');
            unset($permission['role']);
            $permissionObj = Permission::findOrCreate($permission['name'],'api');
            $permissionObj->assignRole($role);

        }

    }
}
