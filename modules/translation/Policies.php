<?php
namespace Translation;

use Illuminate\Support\Str;

#[\Attribute]
trait Policies
{
    public function viewAny_policy(): string
    {
        return "ViewAny $this->name";
    }
    public function view_policy(): string
    {
        return "View $this->name";
    }
    public function create_policy(): string
    {
        return "Create $this->name";
    }
    public function update_policy(): string
    {
        return "Update $this->name";
    }
    public function delete_policy(): string
    {
        return "Delete $this->name";
    }
    public function restore_policy(): string
    {
        return "Restore $this->name";
    }
    public function destroy_policy(): string
    {
        return "Destroy $this->name";
    }
}
