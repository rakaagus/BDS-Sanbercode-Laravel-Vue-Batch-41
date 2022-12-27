<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait UseUuid{

    public function getKeyType()
    {
        return 'string';
    }

    public function getIncrementing()
    {
        return false;
    }

    public static function bootUseUuid(){
        static::creating( function ($model){
            if(empty($model->{$model->getKeyName()})){
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }

}










?>
