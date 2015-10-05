<?php
/**
 * The class for Links manage specific actions.
 *
 *
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Repositories\LinksRepository,
    Modules\Admin\Repositories\LinkCategoryRepository,
    Modules\Admin\Repositories\UserTypeRepository,
    Modules\Admin\Http\Requests\LinksCreateRequest,
    Modules\Admin\Http\Requests\LinksUpdateRequest,
    Modules\Admin\Models\Links,
    Datatables,
    Illuminate\Support\Str,
    Response,
    Illuminate\Support\Facades\Auth,
    Illuminate\Support\Facades\Cache,
    Modules\Admin\Models\UserType,
    Illuminate\Http\Request;

class LinksController extends Controller
{

    /**
     * The LinksResponse instance.
     *
     * @var Modules\Admin\Repositories\LinksRepository
     */
    protected $repository;
    protected $categoryRepository;

    public function __construct(LinksRepository $repository, LinkCategoryRepository $categoryRepository, UserTypeRepository $usertype)
    {
        # User authentication filter
        parent::__construct();
        $this->middleware('acl');
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->usertype = $usertype;
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
            $response['message'] = trans('admin::messages.updated', ['name' => trans('admin::controller/links.link')]);
        } else {
            $response['status'] = 'fail';
            $response['message'] = trans('admin::messages.not-updated', ['name' => trans('admin::controller/links.link')]);
        }

        return response()->json($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Datatables $datatables
     * @return Response
     */
    public function getData()
    {
        $links = $this->repository->data();
        //to display own records
        if (Auth::user()->hasOwnView && (empty(Auth::user()->hasEdit) || empty(Auth::user()->hasDelete))) {
            $links = $links->filter(function ($row) {
                return (Str::equals($row['created_by'], Auth::user()->id)) ? true : false;
            });
        }

        return Datatables::of($links)
                ->addColumn('ids', function ($link) {
                    if (!empty(\Auth::user()->hasEdit)) {
                        return '<input type="checkbox" name="ids[]" value="' . $link->id . '">';
                    }
                })
                ->addColumn('status', function ($link) {
                    $status = ($link->status == 1) ? 'Active' : 'Inactive';
                    return $status;
                })
                ->addColumn('action', function ($link) {
                    $actionList = '';
                    if (!empty(\Auth::user()->hasEdit) || (!empty(\Auth::user()->hasOwnEdit) && ($link->created_by == \Auth::user()->id))) {
                        $actionList = '<a href="javascript:;" data-action="edit" data-id="' . $link->id . '" class="btn btn-xs default yellow-gold margin-bottom-5 edit-form-link" id="' . $link->id . '"><i class="fa fa-pencil"></i></a>';
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
        $selectedUserTypes = [];
        $categoryNames = $this->categoryRepository->listCategoryData()->toArray();
        $paginationArray = $this->repository->getPaginationList();
        $userTypes = $this->usertype->listUserTypeData()->toArray();
        return view('admin::links.index', compact('categoryNames', 'userTypes', 'selectedUserTypes', 'paginationArray'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $selectedUserTypes = [];
        $categoryNames = $this->categoryRepository->listCategoryData()->toArray();
        $paginationArray = $this->repository->getPaginationList();
        $userTypes = $this->usertype->listUserTypeData()->toArray();
        return view('admin::links.create', compact('categoryNames', 'userTypes', 'selectedUserTypes', 'paginationArray'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Repositories\LinksRepository $links
     * @param  LinksCreateRequest $request
     * @return Response
     */
    public function store(
    LinksCreateRequest $request)
    {
        $response = $this->repository->create($request->all());
        $response['sidebar'] = view('admin::layouts.sidebar')->render();
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  Modules\Admin\Models\Links
     * @return Response
     */
    public function show(Links $links)
    {
        return view('admin::links.show', compact('links'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Modules\Admin\Models\Links
     * @return Response
     */
    public function edit(Links $links)
    {
        $categoryNames = $this->categoryRepository->listCategoryData()->toArray();
        $userTypes = $this->usertype->listUserTypeData()->toArray();
        $paginationArray = $this->repository->getPaginationList();
        $selectedUserTypes = $this->repository->getUserTypeIdsbyLink($links->id);
        Cache::tags(UserType::table())->flush();
        $response['success'] = true;
        $response['form'] = view('admin::links.edit', compact('links', 'categoryNames', 'userTypes', 'selectedUserTypes', 'paginationArray'))->render();

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\LinksUpdateRequest $request
     * @param  Modules\Admin\Models\Links
     * @return Response
     */
    public function update(
    LinksUpdateRequest $request, $links)
    {
        $response = $this->repository->update($request->all(), $links);
        $response['sidebar'] = view('admin::layouts.sidebar')->render();
        return response()->json($response);
    }
}
