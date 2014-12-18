<?php
namespace Tectonic\Shift\Library\Localisation;

use Illuminate\Translation\FileLoader;
use Illuminate\Translation\LoaderInterface;
use Tectonic\Localisation\Contracts\TranslationRepositoryInterface;

/**
 * Class TranslationLoader
 *
 * @package Tectonic\Shift\Library\Localisation
 */
class TranslationLoader implements LoaderInterface
{
    /**
     * @var FileLoader
     */
    private $fileLoader;

    /**
     * @var TranslationRepositoryInterface
     */
    private $translationRepository;

    /**
     * @param FileLoader $fileLoader
     * @param TranslationRepositoryInterface $translationRepository
     */
    public function __construct(FileLoader $fileLoader, TranslationRepositoryInterface $translationRepository)
    {
        $this->fileLoader = $fileLoader;
        $this->translationRepository = $translationRepository;
    }

    /**
     * Load the messages for the given locale.
     *
     * @param  string $locale
     * @param  string $group
     * @param  string $namespace
     * @return array
     */
    public function load($locale, $group, $namespace = null)
    {
        // First we load from configuration
        $fileTranslations = $this->fileLoader->load($locale, $group, $namespace);

        // Then we load from database. In this instance the group refers to a top-level field setting. Such as roles.*
        $dbTranslations = $this->translationRepository->getByGroup($locale, 'ui', $group)->toArray();

        // Merge the two and do any refactoring
        $translations = array_merge_recursive($fileTranslations, $dbTranslations);

        return $translations;
    }

    /**
     * Add a new namespace to the loader.
     *
     * @param  string $namespace
     * @param  string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        return $this->fileLoader->addNamespace($namespace, $hint);
    }
}
