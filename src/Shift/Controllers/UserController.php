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
     *
     * @Get("profile", middleware={"shift.account", "auth"}, prefix="/")
     */
    public function profile()
    {
        $profile = $this->userProfileService->getUserProfile(Auth::user()->id);

        dd($profile);

        $this->respond('shift::users.profile', compact('profile'));
    }

    /**
     * Handle updating a user profile.
     *
     * @Post("/profile", middleware={"shift.account", "auth"}, prefix="/")
     *
     * @return mixed
     */
    public function updateProfile()
    {
        return $this->userProfileService->updateProfile(Input::all(), new UserProfileResponder);
    }
}
