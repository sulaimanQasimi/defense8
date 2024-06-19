<?php
namespace Translation;

use Illuminate\Support\Str;

#[\Attribute]
class ModelNameTranslation
{
    use Policies;
    use PersianPermissionTranslation;
    use CreateSpatiePermission;
    protected string $name;
    protected $equalent;

    public function __construct(private $model)
    {
        if (class_exists($model)) {
            $this->equalent = new $model();
        }
        $this->name = Str::afterLast($model, '\\');
    }


}
