<?php namespace Tectonic\Shift\Modules\Localisation\Models;

use Tectonic\Shift\Library\Support\BaseModel;

class Localisation extends BaseModel
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
    protected $fillable = ['locale_id', 'foreign_id', 'resource', 'field', 'value'];
}
