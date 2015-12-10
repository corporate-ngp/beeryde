<?php
/**
 * The class for managing city specific actions.
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>
 */
namespace Modules\Admin\Http\Controllers;

use Auth;
use Datatables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Admin\Models\Car;
use Modules\Admin\Repositories\CarRepository;
use Modules\Admin\Repositories\CarBrandRepository;
use Modules\Admin\Repositories\CarModelRepository;
use Modules\Admin\Http\Requests\CarCreateRequest;
use Modules\Admin\Http\Requests\CarUpdateRequest;

class CarController extends Controller
{

    /**
     * The CarRepository instance.
     *
     * @var Modules\Admin\Repositories\CarRepository
     */
    protected $repository;

    /**
     * The CarBrandRepository instance.
     *
     * @var Modules\Admin\Repositories\CarBrandRepository
     */
    protected $carBrandRepository;

    /**
     * The CarModelRepository instance.
     *
     * @var Modules\Admin\Repositories\CarModelRepository
     */
    protected $carModelRepository;

    /**
     * Create a new CarController instance.
     *
     * @param  Modules\Admin\Repositories\CarRepository $repository,
     *  Modules\Admin\Repositories\CarBrandRepository $carBrandRepository,
     *  Modules\Admin\Repositories\CarModelRepository $carModelRepository
     * 
     * @return void
     */
    public function __construct(CarRepository $repository, CarBrandRepository $carBrandRepository, CarModelRepository $carModelRepository)
    {
        parent::__construct();
        $this->middleware('acl');
        $this->repository = $repository;
        $this->carBrandRepository = $carBrandRepository;
        $this->carModelReposotiry = $carModelRepository;
    }

    /**
     * List all the data
     * 
     * @return view
     */
    public function index()
    {
        $carBrandList = $this->carBrandRepository->listCarBrandData()->toArray();
        $carModelList = [];

        return view('admin::site.cars.index', compact('carBrandList', 'carModelList'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return datatable
     */
    public function getData(Request $request)
    {
        $model = $this->repository->data();
        //dd($model);
        //filter to display own records
        if (Auth::user()->hasOwnView && (empty(Auth::user()->hasEdit) || empty(Auth::user()->hasDelete))) {
            $model = $model->filter(function ($row) {
                return (Str::equals($row['created_by'], Auth::user()->id)) ? true : false;
            });
        }

        return Datatables::of($model)
                ->addColumn('status', function ($row) {
                    $status = ($row->status) ? '<span class="label label-sm label-success">Active</span>' : '<span class="label label-sm label-danger">Inactive</span>';
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $actionList = '';
                    if (!empty(Auth::user()->hasEdit) || (!empty(Auth::user()->hasOwnEdit) && ($row->created_by == Auth::user()->id))) {
                        $actionList = '<a href="javascript:;" data-action="edit" data-id="' . $row->id . '" id="' . $row->id . '" class="btn btn-xs default margin-bottom-5 yellow-gold edit-form-link" title="Edit"><i class="fa fa-pencil"></i></a>';
                    }
                    return $actionList;
                })
                ->filter(function ($instance) use ($request) {

                    //to display own records
                    if (Auth::user()->hasOwnView) {
                        $instance->collection = $instance->collection->filter(function ($row) {
                            return (Str::equals($row['created_by'], Auth::user()->id)) ? true : false;
                        });
                    }
                    if ($request->has('car_brand_id')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::equals($row['car_brand_id'], $request->get('car_brand_id')) ? true : false;
                        });
                    }
                    if ($request->has('car_model_id')) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::equals($row['car_model_id'], strtoupper($request->get('car_model_id'))) ? true : false;
                        });
                    }
                    if ($request->has('user_id')) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(strtolower($row['user_id']), strtolower($request->get('user_id'))) ? true : false;
                        });
                    }
                    if ($request->has('registration_number')) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(strtolower($row['registration_number']), strtolower($request->get('registration_number'))) ? true : false;
                        });
                    }
                    if ($request->has('status')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::equals($row['status'], $request->get('status')) ? true : false;
                        });
                    }
                })
                ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return json encoded response
     */
    public function getCarModelData($carBrandId)
    {
        $carModelList = $this->carModelReposotiry->listCarModelData($carBrandId)->toArray();
        $response['list'] = View('admin::site.cars.carmodeldropdown', compact('carModelList'))->render();
        return response()->json($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return json encoded response
     */
    public function getUserCarsData($userId)
    {
        $carModelList = $this->reposotiry->listUserCarData($userId)->toArray();
        $response['list'] = View('admin::site.cars.usercardropdown', compact('carList'))->render();
        return response()->json($response);
    }

    /**
     * Display a form to create new city.
     *
     * @return view as response
     */
    public function create()
    {
        $carBrandList = $this->carBrandRepository->listCarBrandData()->toArray();
        $carModelList = [];

        return view('admin::site.cars.create', compact('carBrandList', 'carModelList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\CarCreateRequest $request
     * @return json encoded Response
     */
    public function store(CarCreateRequest $request)
    {
        $response = $this->repository->store($request->all());

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified Car.
     *
     * @param  Modules\Admin\Models\Car $row
     * @return json encoded Response
     */
    public function edit(Car $model)
    {
        $carBrandList = $this->carBrandRepository->listCarBrandData()->toArray();
        $carModelList = $this->carModelReposotiry->listCarModelData($model->car_brand_id)->toArray();

        $response['success'] = true;
        $response['form'] = view('admin::site.cars.edit', compact('model', 'carBrandList', 'carModelList'))->render();

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\CarUpdateRequest $request, Modules\Admin\Models\Car $city
     * @return json encoded Response
     */
    public function update(CarUpdateRequest $request, Car $city)
    {
        $response = $this->repository->updateMe($request->all(), $city);

        return response()->json($response);
    }
}
