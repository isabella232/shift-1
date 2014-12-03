<?php
namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;

class UserController extends Controller
{
    protected $userProfileService;

    /**
     */
	public function __construct(UserProfileService $userProfileService)
	{
        $this->userProfileService = $userProfileService;
	}

    public function profile()
    {
        return $this->userProfileService->viewProfile(new UserProfileResponder);
    }
}
