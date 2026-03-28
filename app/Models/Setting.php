<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
    'key', 'value', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption'
];
}
