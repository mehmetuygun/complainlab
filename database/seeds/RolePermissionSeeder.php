<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->delete();
        DB::table('role_user')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();

        //Add a admin role
        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = 'Administrator';
        $admin->save();

        //Add a staff role
        $staff = new Role();
        $staff->name = 'staff';
        $staff->display_name = 'Staff';
        $staff->save();

        //Add a permission view tickets
        $canViewTickets = new Permission();
        $canViewTickets->name = 'view-tickets';
        $canViewTickets->display_name = 'View tickets';
        $canViewTickets->save();

        //Add a permission edit tickets
        $canEditTickets = new Permission();
        $canEditTickets->name = 'edit-tickets';
        $canEditTickets->display_name = 'Edit tickets';
        $canEditTickets->save();

        //Add a permission delete tickets
        $canDeleteTickets = new Permission();
        $canDeleteTickets->name = 'delete-tickets';
        $canDeleteTickets->display_name = 'Delete tickets';
        $canDeleteTickets->save();

        //Add a permission add new tickets
        $canAddTickets = new Permission();
        $canAddTickets->name = 'add-ticket';
        $canAddTickets->display_name = 'Add tickets';
        $canAddTickets->save();

        //Add a permission view user
        $canViewUser = new Permission();
        $canViewUser->name = 'view-user';
        $canViewUser->display_name = 'View user';
        $canViewUser->save();

        //Add a permission edit user
        $canEditUser = new Permission();
        $canEditUser->name = 'edit-user';
        $canEditUser->display_name = 'Edit user';
        $canEditUser->save();

        //Add a permission delete user
        $canDeleteUser = new Permission();
        $canDeleteUser->name = 'delete-user';
        $canDeleteUser->display_name = 'Delete user';
        $canDeleteUser->save();

        //Add a permission add new user
        $canAddUser = new Permission();
        $canAddUser->name = 'add-user';
        $canAddUser->display_name = 'Add user';
        $canAddUser->save();

        //Attach to admin a permissions
        $admin->attachPermission($canViewTickets);
        $admin->attachPermission($canAddTickets);
        $admin->attachPermission($canDeleteTickets);
        $admin->attachPermission($canEditTickets);

        //Attach to admin a permissions 
        $admin->attachPermission($canViewUser);
        $admin->attachPermission($canAddUser);
        $admin->attachPermission($canDeleteUser);
        $admin->attachPermission($canEditUser);

        //Attach to staff a permissions
        $staff->attachPermission($canViewTickets);
        $staff->attachPermission($canAddTickets);
        $staff->attachPermission($canDeleteTickets);
        $staff->attachPermission($canEditTickets);

    }
}
