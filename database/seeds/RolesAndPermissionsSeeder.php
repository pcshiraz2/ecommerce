<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'admin', 'title' => 'دسترسی به مدیریت سیستم']);
        Permission::create(['name' => 'pages', 'title' => 'دسترسی به مدیریت صفحات']);
        Permission::create(['name' => 'articles', 'title' => 'دسترسی به مدیریت مقالات']);
        Permission::create(['name' => 'slides', 'title' => 'دسترسی به مدیریت اسلایدها']);
        Permission::create(['name' => 'discussions', 'title' => 'دسترسی به مدیریت انجمن']);
        Permission::create(['name' => 'products', 'title' => 'دسترسی به مدیریت کالاها']);
        Permission::create(['name' => 'categories', 'title' => 'دسترسی به مدیریت دسته ها']);
        Permission::create(['name' => 'invoices', 'title' => 'دسترسی به مدیریت فاکتورها']);
        Permission::create(['name' => 'transactions', 'title' => 'دسترسی به مدیریت تراکنش ها']);
        Permission::create(['name' => 'users', 'title' => 'دسترسی به مدیریت کاربرها']);
        Permission::create(['name' => 'accounts', 'title' => 'دسترسی به مدیریت حساب ها']);
        Permission::create(['name' => 'settings', 'title' => 'دسترسی به تنظیمات']);
        Permission::create(['name' => 'support', 'title' => 'دسترسی به پشتیبانی']);

        //Shop Keeper
        $role = Role::create(['name' => 'shopkeeper', 'title' => 'فروشنده']);
        $role->givePermissionTo(['invoices', 'products']);

        //Accounting
        $role = Role::create(['name' => 'accounting', 'title' => 'حسابدار']);
        $role->givePermissionTo(['transactions', 'accounts']);

        //Support
        $role = Role::create(['name' => 'support', 'title' => 'پشتیبان']);
        $role->givePermissionTo(['support']);

        //Content Manager
        $role = Role::create(['name' => 'content', 'title' => 'تولید محتوا']);
        $role->givePermissionTo(['pages', 'articles', 'slides', 'discussions']);


        //Administrator
        $role = Role::create(['name' => 'admin', 'title' => 'مدیر ارشد']);
        $role->givePermissionTo(Permission::all());

        //Give access to administrator
        $user = User::findOrFail(1);
        $user->assignRole('admin');
    }
}
