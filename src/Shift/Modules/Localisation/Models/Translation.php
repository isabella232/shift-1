<?php
namespace Tectonic\Shift\Modules\Localisation\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class Translation extends Model
{
    /**
     * We don't really have any need for timestamp columns here.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The fillable elements of the record.
     *
     * @var array
     */
    public $fillable = ['language', 'foreignId', 'resource', 'field', 'value'];
}
