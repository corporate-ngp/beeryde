<?php
/**
 * This class is for managing user related functionalities
 *
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */
namespace Modules\Api\Http\Controllers;

use Modules\Admin\Repositories\SiteUserRepository;
use Modules\Admin\Repositories\UserTokenRepository;
use Modules\Admin\Services\Helper\Helper;
use Validator;
use App\Libraries\ApiResponse;
use Input;
use Exception;
use Log;

class CarBrandsController extends Controller
{

    /**
     * The UserRepository instance.
     *
     * @var Modules\Api\Repositories\UserRepository
     */
    private $repository;
    private $userTokenRepo;

    /**
     * Create a new UserController instance.
     * @param  Modules\Admin\Repositories\UserRepository $userRepo,
     * @return void
     */
    public function __construct(SiteUserRepository $repository, UserTokenRepository $userTokenRepository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->userTokenRepo = $userTokenRepository;
    }

    /**
     * List all the data
     *
     * @return view
     */
    public function index()
    {
        try {
            $users = $this->repository->data();
            if (!empty($users)) {
                return ApiResponse::json($users);
            } else {
                return ApiResponse::error('Listing not available.');
            }
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

    public function show($userId)
    {
        try {
            $id = (int) $userId;
            $user = $this->repository->getById($id);
            if (!empty($user)) {
                return ApiResponse::json($user);
            } else {
                return ApiResponse::error("Can't fetch, Not valid record.");
            }
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

    public function store()
    {
        try {
            $inputs = Input::all();
            $validator = Validator::make($inputs, $this->repository->getCreateRules());
            if ($validator->passes()) {
                return $this->repository->createUser($inputs);
            } else {
                return ApiResponse::validation($validator);
            }
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

    public function update($id)
    {
        try {
            $inputs = Input::all();

            $id = (int) $id;
            $user = $this->repository->getById($id);
            $validator = Validator::make($inputs, $this->repository->getUpdateRules());
            if ($validator->passes()) {
                return $this->repository->updateUser($inputs, $user);
            } else {
                return ApiResponse::validation($validator);
            }
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $id = (int) $id;
            $user = $this->repository->getByIdWithTrashed($id);
            if (!empty($user)) {
                $user->delete();
                return ApiResponse::json('Record deleted.');
            } else {
                return ApiResponse::error("Can't delete, Record not found.");
            }
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        try {
            
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

    public function login()
    {
        try {
            $inputs = Input::all();
            $validator = Validator::make($inputs, $this->repository->getLoginRules($inputs));
            if ($validator->passes()) {
                
                $user = $this->repository->getLoginUser($inputs);
                if(!empty($user)){
                    return $this->userTokenRepo->create(['user_id' =>$user->id, 'token' => Helper::generateUserToken($user->id)]);
                }else{
                    return ApiResponse::error("Invalid login credentials or user does not exists.");
                }
            } else {
                return ApiResponse::validation($validator);
            }
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

    public function sendOtp()
    {
        try {
            
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

    public function sendEmail()
    {
        try {
            
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

    public function confirmEmail($token)
    {
        try {
            
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }
}
