<?php
namespace Tectonic\Shift\Modules\Configuration;

use App;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Configuration\Contracts\SettingRepositoryInterface;
use Tectonic\Shift\Modules\Configuration\Repositories\EloquentSettingRepository;

class ConfigurationServiceProvider extends ServiceProvider
{
    protected $repositories = [
        SettingRepositoryInterface::class => EloquentSettingRepository::class
    ];
}