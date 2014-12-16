<?php
namespace Tectonic\Shift\Library\Authorization;

use Authority\Authority;
use Illuminate\Support\Collection;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Localisation\Languages\Language;

/**
 * Class Consumer
 *
 * When a user or api consumer authenticates against the system, a new AuthenticatedConsumer
 * object is created that will get passed to Authority.
 *
 * What may be confusing, is that the Consumer class has a method called setConsumer. Let's explain
 * what this means and why.
 *
 * The term Consumer is a general purpose term to describe any service or user that may consume
 * the API provided by Shift. However, there are different types of consumers: api, user, iphone.etc.
 *
 * As a result, when the setConsumer method is called, it's really asking for the TYPE of consumer
 * that is executing the request, whether it be an ApiConsumer or a UserConsumer.etc. This is necessary
 * because the various types of consumers have slightly different rules and ways of managing
 * their access.
 *
 * @package Tectonic\Shift\Library\Authorization
 */
final class Consumer
{
    /**
     * A collection of accounts that this consumer has access to.
     *
     * @var Collection
     */
    private $accounts;

    /**
     * The language that the consumer will use.
     *
     * @var string
     */
    private $language;

    /**
     * Returns the accounts that this consumer can safely manage and work with.
     *
     * @return Collection
     */
    public function accounts()
    {
        return $this->accounts;
    }

    /**
     * Defines the accounts that the consumer has access to.
     *
     * @var Collection $accounts
     */
    public function setAccounts(Collection $accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * Returns the language used by the consumer.
     *
     * @return Language
     */
    public function language()
    {
        return $this->language;
    }

    /**
     * Sets the language that the consumer will use as its default.
     *
     * @param string $language
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;
    }

    /**
     * Sets the type of consumer we're dealing with - user, or api?
     *
     * @param ConsumerType $type
     */
    public function setType(ConsumerType $type)
    {
        $this->type = $type;
    }
}
