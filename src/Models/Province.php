<?php

namespace Dmn\PhAddress\Models;

use Dmn\PhAddress\Models\Region;
use Dmn\PhAddress\Models\Traits\ScopeName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Province extends Model
{
    use ScopeName;

    protected $table = 'provinces';

    protected $primaryKey = 'code';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * Region relationship
     *
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
