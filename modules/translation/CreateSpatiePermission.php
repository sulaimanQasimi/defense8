<?php
namespace Translation;

use Spatie\Permission\Models\Permission;

trait CreateSpatiePermission
{
    public function create_permission()
    {
        // create permissions for each collection item
        Permission::create(['name' => $this->viewAny_policy(), 'fa_name' => $this->persian_viewAny_policy(), 'group' => $this->name]);
        Permission::create(['name' => $this->view_policy(), 'fa_name' => $this->persian_view_policy(), 'group' => $this->name]);
        Permission::create(['name' => $this->create_policy(), 'fa_name' => $this->persian_create_policy(), 'group' => $this->name]);
        Permission::create(['name' => $this->delete_policy(), 'fa_name' => $this->persian_update_policy(), 'group' => $this->name]);
        Permission::create(['name' => $this->update_policy(), 'fa_name' => $this->persian_delete_policy(), 'group' => $this->name]);
        Permission::create(['name' => $this->restore_policy(), 'fa_name' => $this->persian_restore_policy(), 'group' => $this->name]);
        Permission::create(['name' => $this->destroy_policy(), 'fa_name' => $this->persian_destroy_policy(), 'group' => $this->name]);
    }
}
