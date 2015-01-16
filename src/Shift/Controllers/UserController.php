<?php
namespace Tectonic\Shift\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\LaravelLocalisation\Facades\Translator;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Identity\Users\Commands\CreateUserCommand;
use Tectonic\Shift\Modules\Identity\Users\Commands\UpdateUserCommand;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Search\UserSearch;
use Tectonic\Shift\Modules\Identity\Users\Services\UserProfileService;
use Tectonic\Shift\Modules\Identity\Users\Observers\UserProfileResponder;

class UserController extends Controller
{
    /**
     * @var \Tectonic\Shift\Modules\Identity\Users\Services\UserProfileService
     */
    protected $userProfileService;

    /**
     * @var ValidationCommandBus
     */
    private $commandBus;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param \Tectonic\Shift\Modules\Identity\Users\Services\UserProfileService $userProfileService
     */
	public function __construct(
        ValidationCommandBus $commandBus,
        UserProfileService $userProfileService,
        UserRepositoryInterface $userRepository
    ) {
        $this->userProfileService = $userProfileService;
        $this->commandBus = $commandBus;
        $this->userRepository = $userRepository;
    }

    /**
     * Search for the required users and return the result.
     *
     * @Get("users", middleware={"shift.account", "shift.auth"}, as="users.index")
     *
     * @return response|json
     */
    public function getIndex()
    {
        $search = App::make(UserSearch::class);
        $users = Translator::translate($search->fromInput(Input::get()));

        return $this->respond('shift::users.index', compact('users'));
    }

    /**
     * Create a new user form.
     *
     * @Get("users/new", middleware={"shift.account", "shift.auth"}, as="users.new")
     *
     * @return response|json
     */
    public function getNew()
    {
        $user = $this->userRepository->getNew();

        return $this->respond('shift::users.new', compact('user'));
    }

    /**
     * Create new user account.
     *
     * @Post("users", middleware={"shift.account", "shift.auth"}, as="users.create")
     *
     * @return response
     */
    public function postStore()
    {
        $command = CreateUserCommand::fromInput(Input::get());

        $this->commandBus->execute($command);

        return Redirect::route('users.index');
    }

    /**
     * Retrieve a single user based on their slug.
     *
     * @Get("users/{slug}", middleware={"shift.account", "shift.auth"}, as="users.show")
     *
     * @param $slug
     * @return array
     */
    public function getShow($slug)
    {
        $user = $this->userRepository->requireBySlug($slug);

        return $this->respond('shift::users.edit', compact('user'));
    }

    /**
     * Update a specific user record based on the.
     *
     * @Put("users", middleware={"shift.account", "shift.auth"}, as="users.update")
     *
     * @param string $slug
     * @return mixed
     */
    public function putUpdate($slug)
    {
        $input = Input::get();
        $input['slug'] = $slug;

        $command = UpdateUserCommand::fromInput($input);

        $this->commandBus->execute($command);

        return Redirect::route('users.index');
    }

    /**
     * Display view for updating a user profile
     *
     * @Get("profile", middleware={"shift.account", "auth"}, prefix="/", as="user.profile")
     */
    public function profile()
    {
        $profile = $this->userProfileService->getUserProfile(Auth::user()->id);

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
