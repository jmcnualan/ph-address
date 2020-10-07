<?php

namespace Dmn\PhAddress\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $table = 'barangays';

    protected $primaryKey = 'code';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;
}
