<?php
/**
 * The class for linkcategory manage specific actions.
 *
 *
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Http\Controllers;

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Repositories\LinkCategoryRepository,
    Modules\Admin\Http\Requests\LinkCategoryCreateRequest,
    Modules\Admin\Http\Requests\LinkCategoryUpdateRequest,
    Modules\Admin\Models\LinkCategory,
    Datatables,
    Illuminate\Support\Facades\Auth,
    Response,
    Illuminate\Support\Str,
    Illuminate\Http\Request;

class LinkCategoryController extends Controller
{

    /**
     * The LinkCategoryResponse instance.
     *
     * @var Modules\Admin\Repositories\LinkCategoryRepository
     */
    protected $repository;

    public function __construct(LinkCategoryRepository $repository)
    {
        parent::__construct();
        $this->middleware('acl');
        $this->repository = $repository;
    }

    /**
     * Hadle Ajax Group Action
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
     */
    public function groupAction(Request $request)
    {
        $response = [];
        $result = $this->repository->groupAction($request->all());
        if ($result) {
            $response['status'] = 'success';
            $response['message'] = trans('admin::messages.updated', ['name' => trans('admin::controller/linkcategory.linkcategory')]);
        } else {
            $response['status'] = 'fail';
            $response['message'] = trans('admin::messages.not-updated', ['name' => trans('admin::controller/linkcategory.linkcategory')]);
        }

        return response()->json($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Datatables $datatables
     * @return Response
     */
    public function getData(Datatables $datatables)
    {
        $LinkCategories = $this->repository->data();
        //to display own records
        if (Auth::user()->hasOwnView && (empty(Auth::user()->hasEdit) || empty(Auth::user()->hasDelete))) {
            $LinkCategories = $LinkCategories->filter(function ($row) {
                return (Str::equals($row['created_by'], Auth::user()->id)) ? true : false;
            });
        }

        return Datatables::of($LinkCategories)
                ->addColumn('ids', function ($LinkCategory) {
                    if (!empty(\Auth::user()->hasEdit)) {
                        return '<input type="checkbox" name="ids[]" value="' . $LinkCategory->id . '">';
                    }
                })
                ->addColumn('status', function ($LinkCategory) {
                    $status = ($LinkCategory->status == 1) ? 'Active' : 'Inactive';
                    return $status;
                })
                ->addColumn('action', function ($LinkCategory) {
                    $actionList = '';
                    if (!empty(\Auth::user()->hasEdit) || (!empty(\Auth::user()->hasOwnEdit) && ($LinkCategory->created_by == \Auth::user()->id))) {
                        $actionList = '<a href="javascript:;" data-action="edit" data-id="' . $LinkCategory->id . '" class="btn btn-xs default yellow-gold margin-bottom-5 edit-form-link" id="' . $LinkCategory->id . '"><i class="fa fa-pencil"></i></a>';
                    }
                    return $actionList;
                })
                ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin::link-category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::link-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Repositories\LinkCategoryRepository $linkCategory
     * @param  LinkCategoryCreateRequest $request
     * @return Response
     */
    public function store(
    LinkCategoryCreateRequest $request)
    {
        $response = $this->repository->create($request->all());
        $response['sidebar'] = view('admin::layouts.sidebar')->render();
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  Modules\Admin\Models\LinkCategory
     * @return Response
     */
    public function show(LinkCategory $linkCategory)
    {
        return view('admin::link-category.show', compact('linkCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Modules\Admin\Models\LinkCategory
     * @return Response
     */
    public function edit(LinkCategory $linkCategory)
    {
        $response['success'] = true;
        $response['form'] = view('admin::link-category.edit', compact('linkCategory'))->render();

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\LinkCategoryUpdateRequest $request
     * @param  Modules\Admin\Models\LinkCategory
     * @return Response
     */
    public function update(
    LinkCategoryUpdateRequest $request, $linkCategory)
    {
        $response = $this->repository->update($request->all(), $linkCategory);
        $response['sidebar'] = view('admin::layouts.sidebar')->render();
        return response()->json($response);
    }
}
