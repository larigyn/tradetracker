<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    // set the attributes to lower case or you can use the ToLowerCase trait
    public function setAttribute($key, $value)
    {
        if (in_array($key, [
            'first_name',
            'last_name',
            'email'
        ])) {
            return $this->attributes[$key] = strtolower($value);
        }

        return parent::setAttribute($key, $value);
    }
}
