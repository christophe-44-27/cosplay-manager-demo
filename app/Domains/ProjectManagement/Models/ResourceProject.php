<?php

namespace App\Domains\ProjectManagement\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceProject extends Model
{
    public $timestamps = true;
    public $guarded = [];

    /**
     * Get the owning resource_projectable model.
     */
    public function resource_projectable()
    {
        return $this->morphTo();
    }
}
