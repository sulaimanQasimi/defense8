<?php

namespace App\Support\Mail;

class MailMessage
{
    /**
     * the model name 
     * @param string $model
     *
     * the Resource name 
     * @param string $name
     *
     * the Method name
     * Create, Update, Delete, Restore,Destroy
     *
     */
    public static function model_title(string $model, string $name, string $method)
    {
        return  __("$method Mail Model Title", ['model' => __($model), 'name' => $name]);
    }

    public static function model_message(string $model,  string $method)
    {
        return  __("$method Mail Model Message", ['model' => __($model)]);
    }
}
