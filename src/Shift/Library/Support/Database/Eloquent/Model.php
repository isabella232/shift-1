<?php
namespace Tectonic\Shift\Library\Support\Database\Eloquent;

use Eloquence\Database\Traits\CamelCaseModel;

class Model extends \Illuminate\Database\Eloquent\Model
{
    // Ensure that fields are always approached with camel-casing
    use CamelCaseModel;

    /**
     * Return the cache key for the model. Taken from basecamp/rails.
     *
     * @return string
     */
    public function cacheKey()
    {
        if ($this->exists) {
            return class_basename($this).'-'.$this->id.'-'.$this->updatedAt;
        }
        else {
            return class_basename($this).'-new';
        }
    }
}
