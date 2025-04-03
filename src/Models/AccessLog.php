<?php

namespace Maize\AccessLogs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Maize\AccessLogs\Events\LoggedIn;

/**
 * @property string $model_type
 * @property int $model_id
 * @property Carbon $accessed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AccessLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'accessed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'accessed_at' => 'datetime',
    ];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Elo§quent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => LoggedIn::class,
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
