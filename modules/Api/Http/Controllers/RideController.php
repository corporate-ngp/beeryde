<?php
/**
 * This class is for managing user related functionalities
 *
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */
namespace Modules\Api\Http\Controllers;

use Modules\Admin\Repositories\RideRepository;
use Validator;
use App\Libraries\ApiResponse;
use Input;
use Exception;
use Log;

class RideController extends Controller
{

    private $repository;

    public function __construct(RideRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
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

    public function show($id)
    {
        try {
            $id = (int) $id;
            $data = $this->repository->getById($id);
            if (!empty($data)) {
                return ApiResponse::json($data);
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
                return $this->repository->create($inputs);
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
                return $this->repository->update($inputs, $user);
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
            $data = $this->repository->getByIdWithTrashed($id);
            if (!empty($data)) {
                $data->delete();
                return ApiResponse::json('Record deleted.');
            } else {
                return ApiResponse::error("Can't delete, Record not found.");
            }
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

}
