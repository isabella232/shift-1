<?php
namespace Tectonic\Shift\Modules\Localisation\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class Translation extends Model
{
    /**
     * The fillable elements of the record.
     *
     * @var array
     */
    public $fillable = ['language', 'foreignId', 'resource', 'field', 'value'];
}
