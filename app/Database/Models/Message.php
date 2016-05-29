<?php

namespace Rcs\Bot\Database\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 *
 * @package Rcs\Bot\Database\Models
 */
class Message extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['content'];

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->getAttribute('content');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function scripts()
    {
        return $this->belongsToMany(Script::class);
    }
}
