<?php

namespace Dmn\PhAddress\Models;

use Dmn\PhAddress\Models\Traits\ScopeName;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use ScopeName;

    protected $table = 'barangays';

    protected $primaryKey = 'code';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;
}
