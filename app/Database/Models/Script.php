<?php

namespace Rcs\Bot\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Script
 *
 * @package Rcs\Bot\Database\Models
 *
 * @property-read \Illuminate\Database\Eloquent\Collection $messages
 */
class Script extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    /**
     * @return BelongsToMany
     */
    public function messages()
    {
        return $this->belongsToMany(Message::class)->withPivot(['offset']);
    }
}
