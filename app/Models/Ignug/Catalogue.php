<?php

namespace App\Models\Ignug;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Catalogue extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql-ignug';
    protected $fillable = [
        'code',
        'parent_code_id',
        'name',
        'type',
        'icon'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
