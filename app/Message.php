<?php

namespace App;

use App\Traits\UsesStringId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int state
 * @property string from_id
 * @property string to_id
 * @property string content
 * @property string id
 */
class Message extends Model
{
    use UsesStringId;

    const UNREAD = 1;
    const READ = 2;

    const CONTENT_LIMIT = 500;

    protected $guarded = [];

    public $timestamps = true;

    /**
     * @return BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(Character::class, 'from_id');
    }

    /**
     * @return BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(Character::class, 'to_id');
    }

    /**
     * Get the number of new messages related to this conversation
     *
     * @param $query
     * @return mixed
     */
    public function scopeUnread($query)
    {
        return $query->where('state', Message::UNREAD);
    }

    /**
     * Read the selected Messages
     *
     * @param $query
     * @return mixed
     */
    public function scopeMarkAsRead($query)
    {
        return $query->update(['state' => Message::READ]);
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setContentAttribute($value)
    {
        $value = str_replace("\r\n", "\n", $value);

        $limitedString = str_limit($value, self::CONTENT_LIMIT, '');

        $this->attributes['content'] = nl2br(e($limitedString));
    }

    public function unseenByRecipient(): bool
    {
        return (int)$this->getOriginal('state') === self::UNREAD;
    }
}
