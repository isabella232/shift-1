<?php
namespace Tectonic\Shift\Modules\Accounts\Contracts;

use Tectonic\Shift\Modules\Localisation\Contracts\LanguageInterface;

interface SupportedLanguageRepositoryInterface
{
    /**
     * Adds a new supported language.
     *
     * @param LanguageInterface $language
     * @return mixed
     */
    public function add(LanguageInterface $language);
}
