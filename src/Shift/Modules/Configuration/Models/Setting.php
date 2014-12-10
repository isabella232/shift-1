<?php
namespace Tectonic\Shift\Modules\Configuration\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class Setting extends Model
{
    public $fillable = ['key', 'value'];

    public $timestamps = false;
}
