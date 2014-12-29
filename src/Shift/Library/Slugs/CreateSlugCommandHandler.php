<?php
namespace Tectonic\Shift\Library\Slugs;

use Illuminate\Support\Str;
use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;

class CreateSlugCommandHandler implements CommandHandlerInterface
{
    /**
     * Handle the command.
     *
     * @param CreateSlugCommand $command
     */
    public function handle($command)
    {
        $model = $command->model;
        $repository = $command->repository;

        $repository->lock('roles');

        while (true) {
            $model->slug = Slug::create($command->string);

            if ($repository->getBySlug($model->slug)) {
                continue;
            }

            $repository->save($model);

            break;
        }

        $repository->unlock();
    }
}
