<?php
namespace Tectonic\Shift\Modules\Localisation\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class Localisation extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'localisations';

    /**
     * @var array
     */
    protected $fillable = ['localeId', 'foreignId', 'resource', 'field', 'value'];
}
