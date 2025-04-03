<?php

namespace Maize\AccessLogs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Maize\AccessLogs\Events\NewAccess;
use Maize\AccessLogs\HasAccessLogs;

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
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => NewAccess::class,
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public static function registerAccess(
        Authenticatable&HasAccessLogs $user
    ): self {
        return static::query()
            ->whereDate('accessed_at', now())
            ->firstOrCreate([
                'model_id' => $user->getKey(),
                'model_type' => $user->getMorphClass(),
            ], [
                'accessed_at' => now(),
            ]);
    }

    public static function lastAccess(
        Authenticatable&HasAccessLogs $user
    ): ?self {
        return static::query()
            ->where('model_id', $user->getKey())
            ->where('model_type', $user->getMorphClass())
            ->latest('accessed_at')
            ->first();
    }
}
