<?php namespace Tectonic\Shift\Modules\Localisation\Entities;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;

/**
 * Class Locale
 *
 * @ORM\Entity
 * @ORM\Table(name="`account_locales`")
 * @ExclusionPolicy("None")
 */
class AccountLocale extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="`id`")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="integer", name="`locale_id`") **/
    protected $localeId;

    /** @ORM\Column(type="integer", name="`account_id`") **/
    protected $accountId;

    /**
     * @ORM\OneToOne(targetEntity="Tectonic\Shift\Modules\Localisation\Entities\Locale", mappedBy="localeId")
     */
    protected $locale;

    /**
     * @ORM\OneToOne(targetEntity="Tectonic\Shift\Modules\Accounts\Entities\Account", mappedBy="accountId")
     */
    protected $account;

}
