<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use CreateUuid, SoftDeletes, Notifiable;
}
