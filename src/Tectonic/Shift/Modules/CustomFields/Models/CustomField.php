<?php namespace Tectonic\Shift\Modules\CustomFields\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class CustomField extends Model
{

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string
     */
    protected $table = 'custom_fields';

    /**
     * @var array
     */
    protected $fillable = [
        'group', 'resource', 'type', 'field_title',
        'field_code', 'label', 'options', 'validation',
        'settings', 'required', 'registration', 'order'
    ];
}
