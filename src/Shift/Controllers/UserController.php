<?php
namespace Tectonic\Shift\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Identity\Users\Services\UserProfileService;
use Tectonic\Shift\Modules\Identity\Users\Observers\UserProfileResponder;

class UserController extends Controller
{
    /**
     * @var \Tectonic\Shift\Modules\Identity\Users\Services\UserProfileService
     */
    protected $userProfileService;

    /**
     * @param \Tectonic\Shift\Modules\Identity\Users\Services\UserProfileService $userProfileService
     */
	public function __construct(UserProfileService $userProfileService)
	{
        $this->userProfileService = $userProfileService;
	}

    /**
     * Display view for updating a user profile
     */
    public function profile()
    {
        $profile = $this->userProfileService->getUserProfile(Auth::user()->id);

        $this->respond('shift::users.profile', ['profile' => $profile]);
    }

    /**
     * Handle updating a user profile.
     *
     * @return mixed
     */
    public function updateProfile()
    {
        return $this->userProfileService->updateProfile(Auth::user()->id, Input::all(), new UserProfileResponder);
    }
}
