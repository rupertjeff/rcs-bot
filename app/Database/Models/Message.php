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
}
