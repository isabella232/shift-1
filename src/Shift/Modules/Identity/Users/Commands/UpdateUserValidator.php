<?php
namespace Tectonic\Shift\Modules\Identity\Users\Commands;

use App;
use Tectonic\Application\Validation\Validator;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;

class UpdateUserValidator extends Validator
{
	public function getRules()
    {
        $userRepository = App::make(UserRepositoryInterface::class);
        $user = $userRepository->requireBySlug($this->input['slug']);

        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'passwordConfirmation' => 'same:password'
        ];
    }
}
