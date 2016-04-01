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
 * @property-read bool   $deletable
 *
 * @method static Command first()
 * @method static \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Command extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['command', 'action', 'reply', 'deletable'];

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->getAttribute('command');
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->getAttribute('action');
    }

    /**
     * @return bool
     */
    public function replyToUser(): bool
    {
        return (bool)$this->getAttribute('reply');
    }

    /**
     * @return bool
     */
    public function isDeletable(): bool
    {
        return (bool)$this->getAttribute('deletable');
    }
}
