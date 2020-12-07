<?php

namespace BSLCore\App\Models;

use Illuminate\Database\Eloquent\Model as DefaultModel;

class Model extends DefaultModel
{
    use ModelTrait; // Пришлось вынести все поля в трэйт, из-за Illuminate\Foundation\Auth\User
}
