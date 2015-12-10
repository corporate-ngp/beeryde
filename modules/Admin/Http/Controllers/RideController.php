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
use Modules\Admin\Models\Ride;
use Modules\Admin\Repositories\RideRepository;
use Modules\Admin\Repositories\CarRepository;
use Modules\Admin\Http\Requests\RideCreateRequest;
use Modules\Admin\Http\Requests\RideUpdateRequest;

class RideController extends Controller
{

    /**
     * The RideRepository instance.
     *
     * @var Modules\Admin\Repositories\RideRepository
     */
    protected $repository;
    protected $carRepository;

    /**
     * Create a new CarController instance.
     *
     * @param  Modules\Admin\Repositories\CarRepository $repository,
     *  Modules\Admin\Repositories\CarBrandRepository $carRepository,
     * 
     * @return void
     */
    public function __construct(RideRepository $repository, CarRepository $carRepository)
    {
        parent::__construct();
        $this->middleware('acl');
        $this->repository = $repository;
        $this->carRepository = $carRepository;
    }

    /**
     * List all the data
     * 
     * @return view
     */
    public function index()
    {
        $carList = $this->carRepository->listUserCarData();

        return view('admin::site.rides.index', compact('carList'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return datatable
     */
    public function getData(Request $request)
    {
        $model = $this->repository->data();
        //filter to display own records
        if (Auth::user()->hasOwnView && (empty(Auth::user()->hasEdit) || empty(Auth::user()->hasDelete))) {
            $model = $model->filter(function ($row) {
                return (Str::equals($row['created_by'], Auth::user()->id)) ? true : false;
            });
        }

        return Datatables::of($model)
                ->addColumn('status', function ($model) {
                    $status = ($model->status) ? '<span class="label label-sm label-success">Active</span>' : '<span class="label label-sm label-danger">Inactive</span>';
                    return $status;
                })
                ->addColumn('action', function ($model) {
                    $actionList = '';
                    if (!empty(Auth::user()->hasEdit) || (!empty(Auth::user()->hasOwnEdit) && ($model->created_by == Auth::user()->id))) {
                        $actionList = '<a href="javascript:;" data-action="edit" data-id="' . $model->id . '" id="' . $model->id . '" class="btn btn-xs default margin-bottom-5 yellow-gold edit-form-link" title="Edit"><i class="fa fa-pencil"></i></a>';
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
                    if ($request->has('user_id')) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::equals($row['user_id'], $request->get('user_id')) ? true : false;
                        });
                    }
                    if ($request->has('ride_from')) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(strtolower($row['ride_from']), strtolower($request->get('ride_from'))) ? true : false;
                        });
                    }
                    if ($request->has('ride_to')) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(strtolower($row['ride_to']), strtolower($request->get('ride_to'))) ? true : false;
                        });
                    }
                    if ($request->has('price')) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(strtolower($row['price']), strtolower($request->get('price'))) ? true : false;
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
     * Display a form to create new city.
     *
     * @return view as response
     */
    public function create()
    {
        $carList = $this->carRepository->listUserCarData();

        return view('admin::site.rides.create', compact('carList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\CarCreateRequest $request
     * @return json encoded Response
     */
    public function store(RideCreateRequest $request)
    {
        $response = $this->repository->store($request->all());

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified Car.
     *
     * @param  Modules\Admin\Models\Car $model
     * @return json encoded Response
     */
    public function edit(Ride $model)
    {
        $carList = $this->carRepository->listUserCarData();

        $response['success'] = true;
        $response['form'] = view('admin::site.rides.edit', compact('model', 'carList'))->render();

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\CarUpdateRequest $request, Modules\Admin\Models\Car $model
     * @return json encoded Response
     */
    public function update(RideUpdateRequest $request, Ride $model)
    {
        $response = $this->repository->updateMe($request->all(), $model);

        return response()->json($response);
    }
}
