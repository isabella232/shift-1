<?php
namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface LanguageRepositoryInterface
{
    /**
     * Return all of the languages available on the system.
     *
     * @return array
     */
    public function getAll();

    /**
     * Retrieves a language based on its language code.
     *
     * @param string $code
     * @return mixed
     */
    public function getByCode($code);
}
