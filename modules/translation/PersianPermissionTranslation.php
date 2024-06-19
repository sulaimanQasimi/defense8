<?php

namespace Translation;

trait PersianPermissionTranslation
{
    public function persian_viewAny_policy(): string
    {
        return "قابلیت دیدن همه " . trans($this->name);
    }
    public function persian_view_policy(): string
    {
        return "قابلیت دیدن " . trans($this->name);
    }
    public function persian_create_policy(): string
    {
        return "قابلیت ایجاد " . trans($this->name);
    }
    public function persian_update_policy(): string
    {
        return "قابلیت ویرایش " . trans($this->name);
    }
    public function persian_delete_policy(): string
    {
        return "قابلیت حذف " . trans($this->name);
    }
    public function persian_restore_policy(): string
    {
        return "قابلیت بازګرداندن " . trans($this->name);
    }
    public function persian_destroy_policy(): string
    {
        return "قابلیت حذف کلی " . trans($this->name);
    }
}
