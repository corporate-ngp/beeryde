<?php
/**
 * This class is for managing user related functionalities
 *
 *
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Api
 */
namespace Modules\Api\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Admin\Repositories\SiteUserRepository;
use Validator;
use App\Libraries\ApiResponse;
use Input;
use Exception;
use Log;
use Auth;

class UserController extends Controller
{

    /**
     * The UserRepository instance.
     *
     * @var Modules\Api\Repositories\UserRepository
     */
    private $repository;

    /**
     * Create a new UserController instance.
     * @param  Modules\Admin\Repositories\UserRepository $userRepo,
     * @return void
     */
    public function __construct(SiteUserRepository $userRepo)
    {
        $this->repository = $userRepo;
    }

    /**
     * List all the data
     *
     * @return view
     */
    public function index()
    {
        $users = $this->repository->data();
        if (!empty($users)) {
            $response = ApiResponse::json($users);
        } else {
            $response = ApiResponse::error('Not able to show users list');
        }
        return $response;
    }

    public function show($userId)
    {
        $users = $this->repository->data();
        $id = (int) $userId;
        $user = $this->repository->getById($id);
        if (!empty($user)) {
            $response = ApiResponse::json($user);
        } else {
            $response = ApiResponse::error('Not able to show user details');
        }
        return $response;
    }
}
