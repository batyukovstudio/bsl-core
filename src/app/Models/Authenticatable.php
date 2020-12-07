<?php


namespace BSLCore\App\Models;

use Illuminate\Foundation\Auth\User as DefaultAuthenticatable;

class Authenticatable extends DefaultAuthenticatable
{
    // Пришлось вынести все функции и поля в трэйт ModelTrait, из-за Illuminate\Foundation\Auth\User
    use ModelTrait;
}
