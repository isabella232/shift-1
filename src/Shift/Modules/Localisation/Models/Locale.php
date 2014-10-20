<?php namespace Tectonic\Shift\Modules\Localisation\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class Locale extends Model
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

    public function localisations()
    {
        return $this->hasMany(Localisation::class);
    }
}
