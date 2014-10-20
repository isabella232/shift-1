<?php
namespace Tectonic\Shift\Modules\Security\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Only the name can be safely filled. Account details, default roles.etc. all must
     * be programmatically set on the role object.
     *
     * @var array
     */
    public $fillable = ['name', 'default'];

    /**
     * A role can have many permissions, of both denied and allowed types.
     *
     * @return mixed
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
