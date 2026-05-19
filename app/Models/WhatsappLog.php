<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappLog extends Model
{
    //
    protected $fillable = [
        'target',
        'recipient_name',
        'message',
        'status',
        'reason',
    ];
}
