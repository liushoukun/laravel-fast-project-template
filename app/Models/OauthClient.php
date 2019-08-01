<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class OauthClient extends Authenticatable
{
    //

    use Notifiable;


    protected $table = 'oauth_clients';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];


}
