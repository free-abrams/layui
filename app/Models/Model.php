<?php
/**
 * Created by PhpStorm.
 * User: addd
 * Date: 2020/10/10
 * Time: 17:02
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
