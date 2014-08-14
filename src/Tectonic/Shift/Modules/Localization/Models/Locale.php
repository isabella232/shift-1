<?php namespace Tectonic\Shift\Modules\Localization\Models;

use Tectonic\Shift\Library\Support\BaseModel;

class Locale extends BaseModel
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'locales';

    /**
     * @var array
     */
    protected $fillable = ['locale', 'code'];
}
