<?php

namespace Dmn\PhAddress\Models;

use Dmn\PhAddress\Models\Traits\Address;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use Address;

    protected $table = 'countries';

    protected $primaryKey = 'code';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;
}
