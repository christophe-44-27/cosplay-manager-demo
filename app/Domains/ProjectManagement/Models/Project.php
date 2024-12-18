<?php

namespace App\Domains\ProjectManagement\Models;

use App\Domains\Community\Models\Group;
use App\Domains\Core\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use CanBeLiked;

    protected $table = 'projects';
    public $timestamps = true;
    protected $casts = [
        'estimated_end_date' => 'datetime',
        'is_private' => 'boolean',
    ];
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @return MorphMany
     */
    public function resources()
    {
        return $this->morphMany(ResourceProject::class, 'resource_projectable');
    }

    /**
     * @return HasMany
     */
    public function elements()
    {
        return $this->hasMany(ProjectElement::class);
    }

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return HasMany
     */
    public function slots(): HasMany
    {
        return $this->hasMany(TimeSheet::class);
    }

    /**
     * Get the project's timesheet.
     */
    public function timesheets(): MorphMany
    {
        return $this->morphMany(TimeSheet::class, 'timesheetable');
    }

    /**
     * @return Attribute
     */
    protected function progression(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (count($this->projectElements) > 0) {
                    $allProjectsElements = $this->projectElements;
                    $elements_done = $allProjectsElements->where('is_done', 1)->count();

                    return round($elements_done * 100 / $allProjectsElements->count(), 2);
                }
                return 0;
            }
        );
    }

    /**
     * @return Attribute
     */
    protected function isDone(): Attribute
    {
        return Attribute::make(
            get: function () {
                $projectElements = $this->hasMany(ProjectElement::class)
                    ->where('is_done', '=', 0)
                    ->count();

                if ($projectElements > 0) {
                    return false;
                }
                return true;
            }
        );
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
