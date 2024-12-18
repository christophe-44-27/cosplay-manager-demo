<?php

namespace App\Domains\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    public $timestamps = true;
    public $guarded = [];

    /**
     * Get the owning resourceable model.
     */
    public function resourceable()
    {
        return $this->morphTo();
    }
}
