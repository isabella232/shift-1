<?php
namespace Tectonic\Shift\Modules\Configuration\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Configuration\Contracts\SettingInterface;

class Setting extends Model implements SettingInterface
{
    public $fillable = ['key', 'value'];

    public $timestamps = false;

    /**
     * Stores the available settings that users can modify. This is a
     * register of all available user-modifiable settings within the system.
     *
     * @var array
     */
    public static $registry = [];

    /**
     * Retrieves settings from the database.
     * You can pass a string for a single setting, an array for multpiple
     * or pass no value for all settings.
     *
     * @param null|string|array $key
     * @param mixed $default You can provide a default value if the record is not found.
     *
     * @return array
     */
    public static function get( $key = null, $default = null )
    {
        if ( $key === null )
        {
            $settings = Setting::all();
        }
        else
        {
            if ( !is_array( $key ) ) $key = [ $key ];

            $settings = static::whereIn( 'key' , $key )->get();
        }

        $return = [];

        foreach ( $settings as $s )
        {
            $return[ $s->key ] = $s->value;
        }

        // If it's just a single object, then return only that value. Saves us having to do things like:
        //
        // $setting = Setting::get( 'some.key.setting' );
        // $setting[ 'some.key.setting' ];
        if ( count( $return ) == 1 )
        {
            return array_pop( $return );
        }

        return empty( $return ) ? $default : $return;
    }

    /**
     * Registers a new setting that is modifiable in some way by a user.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function register( $key, $value )
    {
        $defined = static::available( $key );

        if ( !is_null( $defined ) )
        {
            $value = array_merge_recursive( $defined, $value );
        }

        array_set( static::$registry, $key, $value );
    }

    /**
     * Returns all registered settings available to the system.
     *
     * @param  string $key
     * @return mixed If key is provided, will return the data for that particular setting, otherwise it will return all registered settings.
     */
    public static function available( $key = null )
    {
        if ( !is_null( $key ) )
        {
            return array_get( static::$registry, $key );
        }
        else
        {
            return static::$registry;
        }

        return null;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $key
     *
     * @return void
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
