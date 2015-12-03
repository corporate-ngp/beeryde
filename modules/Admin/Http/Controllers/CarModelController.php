<?php namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\CarModelRepository;
use Modules\Admin\Repositories\CarBrandRepository;
use Modules\Admin\Http\Requests\CarModelCreateRequest;
use Modules\Admin\Http\Requests\CarModelUpdateRequest;
use Modules\Admin\Models\CarModel;
use Datatables;
use Illuminate\Support\Str;
use Auth;

class CarModelController extends Controller
{

    /**
     * The CarModelRepository instance.
     *
     * @var Modules\Admin\Repositories\CarModelRepository
     */
    protected $repository;
    protected $carBrandRepository;

    /**
     * Create a new CarModelController instance.
     *
     * @param  Modules\Admin\Repositories\CarModelRepository $repository
     * @return void
     */
    public function __construct(CarModelRepository $repository, CarBrandRepository $carBrandRepository)
    {
        parent::__construct();
        $this->middleware('acl');
        $this->repository = $repository;
        $this->carBrandRepository = $carBrandRepository;
    }

    //default method (verb/action - GET)
    public function index()
    {
        $data['page_title'] = 'Manage CarModel';
        $carBrandList = $this->carBrandRepository->listCarBrandData()->toArray();
        return view('admin::site.car-models.index', compact('data', 'carBrandList'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return datatable
     */
    public function getData(Request $request)
    {
        $data = $this->repository->data();
        //dd($data->toArray());
        return Datatables::of($data)
                ->addColumn('car_brand_id', function ($result) {
                    return (!empty($result->CarBrand->name)) ? $result->CarBrand->name : '';
                })
                ->addColumn('status', function ($result) {
                    switch ($result->status) {
                        case 0:
                            $status = '<span class="label label-sm label-danger">Inactive</span>';
                            break;
                        case 1:
                            $status = '<span class="label label-sm label-success">Active</span>';
                            break;
                    }
                    return $status;
                })
                ->addColumn('action', function ($result) {
                    $actionList = '';
                    if (!empty(Auth::user()->hasEdit) || (!empty(Auth::user()->hasOwnEdit) && ($result->created_by == Auth::user()->id))) {
                        $actionList = '<a href="javascript:;" data-action="edit" title="Edit" data-id="' . $result->id . '" class="btn btn-xs default margin-bottom-5 yellow-gold edit-form-link" title="Edit" id="' . $result->id . '"><i class="fa fa-pencil"></i></a>';
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
                            return Str::contains($row['car_brand_id'], $request->get('car_brand_id')) ? true : false;
                        });
                    }
                    if ($request->has('name')) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['name'], $request->get('name')) ? true : false;
                        });
                    }
                    if ($request->has('state_code')) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['state_code'], strtoupper($request->get('state_code'))) ? true : false;
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
     * Hadle Ajax Group Action
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
     */
    public function groupAction(Request $request)
    {
        $response = $this->repository->groupAction($request->all());
        return response()->json($response);
    }

    //Add form (verb/action - GET)
    public function create()
    {
        $carBrandList = $this->carBrandRepository->listCarBrandData()->toArray();
        return view('admin::site.car-models.create',  compact('carBrandList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\CarModelCreateRequest $request
     * @return json encoded Response
     */
    public function store(CarModelCreateRequest $request)
    {
        $response = $this->repository->create($request->all());

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified configuration category.
     *
     * @param  Modules\Admin\Models\CarModel $state
     * @return json encoded Response
     */
    public function edit(CarModel $state)
    {
        //dd($state);
        $carBrandList = $this->carBrandRepository->listCarBrandData()->toArray();
        $response['success'] = true;
        $response['form'] = view('admin::site.car-models.edit', compact('state', 'carBrandList'))->render();

        return response()->json($response);
    }

    public function update(CarModelUpdateRequest $request, CarModel $state)
    {
        $response = $this->repository->update($request->all(), $state);

        return response()->json($response);
    }
}
