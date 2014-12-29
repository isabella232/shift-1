<?php
namespace Tectonic\Shift\Library\Slugs;

use Eloquence\Database\Model;
use Tectonic\Application\Commanding\Command;
use Tectonic\Shift\Library\Support\Database\RepositoryInterface;

/**
 * Class CreateSlugCommand
 *
 * Signals the intent of a slug that will update a model, using the string provided
 * as the basis for the slug field.
 *
 * @package Tectonic\Shift\Library\SlugsListener
 */
class CreateSlugCommand extends Command
{
	/**
	 * @var
	 */
	public $model;

	/**
	 * @var
	 */
	public $repository;

	/**
	 * @var
	 */
	public $string;

	/**
	 * @param string $id
     */
	public function __construct($string, Model $model, RepositoryInterface $repository)
	{
		$this->model = $model;
		$this->repository = $repository;
		$this->string = $string;
	}
}
