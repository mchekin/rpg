<?php

namespace App\Contracts\Models;

interface MessageInterface
{
    /**
     * Get the number of new messages related to this conversation
     *
     * @param $query
     * @return mixed
     */
    public function scopeUnread($query);

    /**
     * Read the selected Messages
     *
     * @param $query
     * @return mixed
     */
    public function scopeMarkAsRead($query);

    /**
     * Set the user's first name.
     *
     * @param  string $value
     * @return string
     */
    public function setContentAttribute($value);
}