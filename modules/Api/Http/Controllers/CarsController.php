<?php
/**
 * This class is for managing user related functionalities
 *
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */
namespace Modules\Api\Http\Controllers;

use Modules\Admin\Repositories\CarRepository as MyRepository;
use Validator;
use App\Libraries\ApiResponse;
use Input;
use Exception;
use Log;

class CarsController extends Controller
{

    /**
     * The UserRepository instance.
     */
    private $repository;

    /**
     * Create a new Controller instance.
     * @return void
     */
    public function __construct(MyRepository $repository)
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
            $myObj = $this->repository->data();
            if (!empty($myObj)) {
                return ApiResponse::json($myObj);
            } else {
                return ApiResponse::error('Listing not available.');
            }
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

    public function show($listId)
    {
        try {
            $id = (int) $listId;
            $myObj = $this->repository->show($id);
            if (!empty($myObj)) {
                return ApiResponse::json($myObj);
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

    public function update($listId)
    {
        try {
            $inputs = Input::all();
            $id = (int) $listId;
            $myObj = $this->repository->getById($id);
            $validator = Validator::make($inputs, $this->repository->getUpdateRules());
            if ($validator->passes()) {
                return $this->repository->update($inputs, $myObj);
            } else {
                return ApiResponse::validation($validator);
            }
        } catch (Exception $e) {
            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
        }
    }

//    public function destroy($listId)
//    {
//        try {
//            $id = (int) $listId;
//            $myObj = $this->repository->getById($id);
//            if (!empty($myObj)) {
//                $myObj->delete();
//                return ApiResponse::json('Record deleted.');
//            } else {
//                return ApiResponse::error("Can't delete, Record not found.");
//            }
//        } catch (Exception $e) {
//            Log::info(str_replace(['\\'], [''], __METHOD__), ['error_message' => $e->getMessage()]);
//        }
//    }
}
