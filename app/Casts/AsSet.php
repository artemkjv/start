<?php


namespace App\Casts;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AsSet implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        return explode(',', $value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if(is_array($value)){
            $value = array_filter($value);
            return implode(',', $value);
        }
        return $value;
    }
}
