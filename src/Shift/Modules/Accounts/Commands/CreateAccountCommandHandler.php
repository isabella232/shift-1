<?php
namespace Tectonic\Shift\Modules\Accounts\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;

class CreateAccountCommandHandler implements CommandHandlerInterface
{
    /**
     * @var LanguageRepositoryInterface
     */
    private $languageRepository;

    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    function __construct(
        EventDispatcher $dispatcher,
        AccountRepositoryInterface $accountRepository,
        LanguageRepositoryInterface $languageRepository
    )
    {
        $this->languageRepository = $languageRepository;
        $this->accountRepository = $accountRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Creates a new account record, assigns
     *
     * @param $command
     */
    public function handle($command)
    {
        // Create account
        $account = Account::create([]);

        $this->accountRepository->save($account);

        $language = $this->languageRepository->getByCode($command->defaultLanguageCode);

        $account->addLanguage($language);
        $account->addTranslation($language->code, 'name', $command->name);

        $account->addDomain($command->domain);

        $this->dispatcher->dispatch($account->releaseEvents());
    }
}
