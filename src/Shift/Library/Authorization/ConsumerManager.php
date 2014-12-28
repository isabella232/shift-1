<?php
namespace Tectonic\Shift\Library\Authorization;

use Authority\Authority;
use Illuminate\Support\Collection;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Localisation\Languages\Language;

/**
 * Class ConsumerManager
 *
 * When a user or api consumer authenticates against the system, a new AuthenticatedConsumer
 * object is created that will get passed to Authority.
 *
 * What may be confusing, is that the ConsumerManager class has a method called setConsumer. Let's explain
 * what this means and why.
 *
 * The term ConsumerManager is a general purpose term to describe any service or user that may consume
 * the API provided by Shift. However, there are different types of consumers: api, user, iphone.etc.
 *
 * As a result, when the setConsumer method is called, it's really asking for the TYPE of consumer
 * that is executing the request, whether it be an ApiConsumer or a UserConsumer.etc. This is necessary
 * because the various types of consumers have slightly different rules and ways of managing
 * their access.
 *
 * @package Tectonic\Shift\Library\Authorization
 */
final class ConsumerManager
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
        if (!$this->guest()) {
            return $this->consumer->language();
        }

        return CurrentAccount::get()->defaultLanguage();
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
