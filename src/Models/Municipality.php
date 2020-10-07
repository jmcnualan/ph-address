<?php

namespace Dmn\PhAddress\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $table = 'municipalities';

    protected $primaryKey = 'code';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;
}
