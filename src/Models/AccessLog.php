<?php

namespace Maize\AccessLogs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Maize\AccessLogs\Events\NewAccess;
use Maize\AccessLogs\HasAccessLogs;

/**
 * @property string $user_type
 * @property int $user_id
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
        'user_type',
        'user_id',
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
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => NewAccess::class,
    ];

    public function user(): MorphTo
    {
        return $this->morphTo();
    }

    public static function registerAccess(
        Model&HasAccessLogs $user
    ): self {
        return static::query()
            ->whereToday('accessed_at')
            ->firstOrCreate([
                'user_id' => $user->getKey(),
                'user_type' => $user->getMorphClass(),
            ], [
                'accessed_at' => now(),
            ]);
    }

    public static function lastAccess(
        Model&HasAccessLogs $user
    ): ?self {
        return static::query()
            ->where('user_id', $user->getKey())
            ->where('user_type', $user->getMorphClass())
            ->latest('accessed_at')
            ->first();
    }
}
