<?php
namespace Tectonic\Shift\Library\Authorization;

use Authority\Authority;
use Illuminate\Support\Collection;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Localisation\Languages\Language;

/**
 * Class ConsumerManager
 *
 * @package Tectonic\Shift\Library\Authorization
 */
class ConsumerManager
{
    /**
     * Stores the actual consumer object of the application/api.
     *
     * @var ConsumerInterface
     */
    private $consumer;

    /**
     * Set the consumer of the application.
     *
     * @param ConsumerInterface $consumer
     */
    public function set(ConsumerInterface $consumer)
    {
        $this->consumer = $consumer;
    }

    /**
     * Determines whether the consumer is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return is_null($this->get());
    }

    /**
     * Return the consumer of the application.
     *
     * @return ConsumerInterface
     */
    public function get()
    {
        return $this->consumer;
    }

    /**
     * Returns the language object that the consumer has preferred, otherwise,
     * the default language. This can be used even if the consumer is not currently
     * logged-in yet.
     *
     * @return Language
     */
    public function language()
    {
        if ($this->guest()) {
            return CurrentAccount::get()->defaultLanguage();
        }

        return $this->consumer->language();
    }

    /**
     * Sets the type of consumer we're dealing with - user, or api?
     *
     * @return ConsumerType
     */
    public function type()
    {
        if ($this->guest()) {
            return new ConsumerType('guest');
        }

        return $this->consumer->type();
    }
}
