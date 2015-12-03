<?php
/**
 * The class for managing country specific actions.
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>

 
 */

namespace Modules\Admin\Http\Controllers;

use Auth;
use Datatables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Admin\Models\CarBrand;
use Modules\Admin\Repositories\CarBrandRepository;
use Modules\Admin\Http\Requests\CarBrandCreateRequest;
use Modules\Admin\Http\Requests\CarBrandUpdateRequest;

class CarBrandController extends Controller
{

    /**
     * The CarBrandRepository instance.
     *
     * @var Modules\Admin\Repositories\CarBrandRepository
     */
    protected $repository;

    /**
     * Create a new CarBrandController instance.
     *
     * @param  Modules\Admin\Repositories\ConfigSettingRepository $repository
     * @return void
     */
    public function __construct(CarBrandRepository $repository)
    {
        parent::__construct();
        $this->middleware('acl');
        $this->repository = $repository;
    }

    /**
     * List all the data
     * @param Modules\Admin\Repositories\CarBrandRepository $countryRepository
     * @return response
     */
    public function index()
    {
        return view('admin::site.car-brands.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return datatable
     */
    public function getData(Request $request)
    {
        $data = $this->repository->data($request->all());

        return Datatables::of($data)
                ->addColumn('status', function ($row) {
                    $status = ($row->status == 1) ? '<span class="label label-sm label-success">Active</span>' : '<span class="label label-sm label-danger">Inactive</span>';
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $actionList = '';
                    if (!empty(Auth::user()->hasEdit) || (!empty(Auth::user()->hasOwnEdit) && ($row->created_by == Auth::user()->id))) {
                        $actionList = '<a href="javascript:;" data-action="edit" data-id="' . $row->id . '" id="' . $row->id . '" class="btn btn-xs default margin-bottom-5 yellow-gold edit-form-link" title="Edit"><i class="fa fa-pencil"></i></a>';
                    }
                    return $actionList;
                })
                ->make(true);
    }

    /**
     * Display a form to create new country.
     *
     * @return view as response
     */
    public function create()
    {
        return view('admin::site.car-brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\CarBrandCreateRequest $request
     * @return json encoded Response
     */
    public function store(CarBrandCreateRequest $request)
    {
        $response = $this->repository->store($request->all());

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified country.
     *
     * @param  Modules\Admin\Models\CarBrand $country
     * @return json encoded Response
     */
    public function edit(CarBrand $carBrand)
    {
        $response['success'] = true;
        $response['form'] = view('admin::site.car-brands.edit', compact('carBrand'))->render();

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\CarBrandUpdateRequest $request, Modules\Admin\Models\CarBrand $country 
     * @return json encoded Response
     */
    public function update(CarBrandUpdateRequest $request, CarBrand $model)
    {
        $response = $this->repository->updateMe($request->all(), $model);

        return response()->json($response);
    }
}
