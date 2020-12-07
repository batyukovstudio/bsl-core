<?php

namespace BSLCore\App\Models\Users;

use BSLCore\App\Models\Authenticatable;
use BSLCore\App\Traits\Common\ContactsTrait;

class User extends Authenticatable
{
    use ContactsTrait;

    protected $table = 'users';

    /**
     * @var int
     */
    protected $perPage = 40;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'l_name',
        'f_name',
        'm_name',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
