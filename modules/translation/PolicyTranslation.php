<?php
namespace Translation;

class PolicyTranslation
{
    #[ModelNameTranslation("App\\Models\\Department")]
    private $model;
    public function model(): ModelNameTranslation
    {
        return (new \ReflectionClass(self::class))->getProperty('model')->getAttributes()[0]->newInstance();
    }
}
