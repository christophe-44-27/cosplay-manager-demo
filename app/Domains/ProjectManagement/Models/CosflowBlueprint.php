<?php

namespace App\Domains\ProjectManagement\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CosflowBlueprint extends Model
{
    use HasFactory;

    /**
     * Get the project's timesheet.
     */
    public function cosflowResources(): MorphMany
    {
        return $this->morphMany(CosflowResource::class, 'resourceable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
