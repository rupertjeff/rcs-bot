<?php

namespace Rcs\Bot\Database\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Command
 *
 * @package Rcs\Bot\Database\Models
 *
 * @property-read string $command
 * @property-read string $action
 * @property-read bool   $reply
 * 
 * @method static \Illuminate\Database\Eloquent\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Command extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['command', 'action', 'reply'];

    /**
     * @return bool
     */
    public function replyToUser(): bool
    {
        return (bool)$this->getAttribute('reply');
    }
}
