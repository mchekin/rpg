<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const UNREAD = 1;
    const READ = 2;

    protected $fillable = [
        'from_id',
        'to_id',
        'content',
        'state',
    ];

    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'to_id');
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
}
