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
use Modules\Admin\Repositories\PagesRepository;
use Validator;
use App\Libraries\ApiResponse;
use Input;
use Exception;
use Log;
use Auth;

class PagesController extends Controller
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
    public function __construct(PagesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * List all the data
     *
     * @return view
     */
    public function index()
    {
        $data = $this->repository->data();
        if (!empty($data)) {
            $response = ApiResponse::json($data);
        } else {
            $response = ApiResponse::error('Not able to show pages list');
        }
        
        return $response;
    }

    public function show($id)
    {
        $id = (int) $id;
        $data = $this->repository->getById($id);
        if (!empty($data)) {
            $response = ApiResponse::json($data);
        } else {
            $response = ApiResponse::error('Not able to show page details');
        }
        
        return $response;
    }
}
