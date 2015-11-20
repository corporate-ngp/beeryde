<?php
/**
 * The class for user manage specific actions.
 *
 *
 * @author NGP <corporate.ngp@gmail.com>

 
 */
namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\SiteUserRepository;
use Modules\Admin\Http\Requests\SiteUserCreateRequest;
use Modules\Admin\Http\Requests\SiteUserUpdateRequest;
use Modules\Admin\Models\SiteUser;
use Datatables;
use Modules\Admin\Services\Helper\ImageHelper;
use Illuminate\Support\Str;

class SiteUserController extends Controller
{

    /**
     * The UserRepository instance.
     *
     * @var Modules\Admin\Repositories\UserRepository
     */
    protected $repository;

    /**
     * Create a new UserController instance.
     *
     * @param  Modules\Admin\Repositories\UserRepository $repository
     * @param  Modules\Admin\Repositories\UserTypeRepository $userTypeRepository
     * @param  Modules\Admin\Repositories\LinksRepository $linksRepository
     * @param  Modules\Admin\Repositories\LinkCategoryRepository $linkCategoryRepository
     * @return void
     */
    public function __construct(
    SiteUserRepository $repository)
    {
        parent::__construct();
        //$this->middleware('acl');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Datatables $datatables
     * @return Response
     */
    public function getData(Request $request)
    {
        $users = $this->repository->data();

        return Datatables::of($users)
                ->addColumn('ids', function ($user) {
                    return '<input type="checkbox" name="ids[]" value="' . $user->id . '">';
                })
                ->addColumn('avatar', function ($user) {
                    return '<div class="user-listing-img">' . ImageHelper::getUserAvatar($user->id, $user->avatar) . '</div>';
                })
                ->addColumn('email', function ($user) {
                    $gender = ($user->gender == 1) ? 'Male' : 'Female';
                    return $user->name . ' (' . $gender . ') <br/>' . $user->email . ' </br>' . $user->contact;
                })
                ->addColumn('status', function ($user) {
                    return ($user->status == 1) ? '<span class="label label-sm label-success">' . trans('admin::messages.active') . '</span>' : '<span class="label label-sm label-danger">' . trans('admin::messages.inactive') . '</span>';
                })
                ->addColumn('action', function ($user) {
                    $actionList = '';

                        $actionList .= '<a href="javascript:;" data-action="edit" data-id="' . $user->id . '" class="btn btn-xs default yellow-gold margin-bottom-5 edit-form-link edit" title="' . trans('admin::messages.edit') . '"><i class="fa fa-pencil"></i></a>';

                        $actionList .= '<a href="javascript:;" data-message="' . trans('admin::messages.delete-confirm') . '" data-action="delete" data-id="' . $user->id . '" class="btn btn-xs default red-thunderbird margin-bottom-5 delete" title="' . trans('admin::messages.delete') . '"><i class="fa fa-trash-o"></i></a>';
                        $actionList .= '<a href="'.\URL::to("/admin/site-user/".$user->id).'" data-message="Show" data-action="show" data-id="' . $user->id . '" class="btn btn-xs default blue-thunderbird margin-bottom-5 show" title="Show"><i class="fa fa-search"></i></a>';

                    return $actionList;
                })
                ->filter(function ($instance) use ($request) {

                    if ($request->has('name')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return (Str::contains($row['name'], $request->get('name')) || Str::equals($row['id'], $request->get('name'))) ? true : false;
                        });
                    }
                    if ($request->has('email')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return (Str::contains($row['email'], $request->get('email')) || Str::contains($row['name'], $request->get('email')) || Str::contains($row['contact'], $request->get('email'))) ? true : false;
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
     * @return Response
     */
    public function index()
    {
        $bulkAction = $this->repository->getAdminBulkActionSelect();
        return view('admin::site.users.index', compact('bulkAction'));
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

    /**
     * Show the form for creating a new resource.
     * @param  Modules\Admin\Repositories\UserTypeRepository $userTypeRepository
     * @return Response
     */
    public function create()
    {
        return view('admin::site.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     * @return Response
     */
    public function store(SiteUserCreateRequest $request)
    {
        $response = $this->repository->create($request->all());
        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Modules\Admin\Models\User
     * @return Response
     */
    public function edit(SiteUser $user)
    {
        return view('admin::site.users.edit', compact('user'));
    }
    
     public function show(SiteUser $user)
    {
        foreach(collect($user) as $key => $value){
             
            echo "<br/> ".$key.' = '.$value ;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\UserUpdateRequest $request
     * @param  Modules\Admin\Models\User
     * @return Response
     */
    public function update(SiteUserUpdateRequest $request, SiteUser $user)
    {
        $response = $this->repository->update($request->all(), $user);
        return response()->json($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function trashed()
    {
        $bulkAction = $this->repository->getTrashBulkActionSelect();
        return view('admin::site.users.trashed', compact('bulkAction'));
    }

    /**
     * Display a listing of the trashed resources.
     *
     * @param  Request $request
     * @return Response
     */
    public function getTrashedData(Request $request)
    {
        $users = $this->repository->trashedData();

        return Datatables::of($users)
                ->addColumn('ids', function ($user) {
                    return '<input type="checkbox" name="ids[]" value="' . $user->id . '">';
                })
                ->addColumn('avatar', function ($user) {
                    return '<div class="user-listing-img">' . ImageHelper::getUserAvatar($user->id, $user->avatar) . '</div>';
                })
                ->addColumn('email', function ($user) {
                    $gender = ($user->gender == 1) ? 'Male' : 'Female';
                    return $user->name .' (' . $gender . ') <br/>' . $user->email . ' </br>' . $user->contact;
                })
                ->addColumn('status', function ($user) {
                    return ($user->status == 1) ? '<span class="label label-sm label-success">' . trans('admin::messages.active') . '</span>' : '<span class="label label-sm label-danger">' . trans('admin::messages.inactive') . '</span>';
                })
                ->addColumn('action', function ($user) {

                        $actionList = '<a href="javascript:;" data-message="' . trans('admin::messages.delete-confirm') . '" data-action="delete-hard" data-id="' . $user->id . '" class="btn btn-xs default red-thunderbird margin-bottom-5 delete" title="' . trans('admin::messages.delete-hard') . '"><i class="fa fa-trash-o"></i></a>';

                        $actionList .= '<a href="javascript:;" data-message="' . trans('admin::messages.restore-confirm') . '" data-action="restore" data-id="' . $user->id . '" class="btn btn-xs default red-thunderbird margin-bottom-5 delete" title="' . trans('admin::messages.restore') . '"><i class="fa fa-undo"></i></a>';
                    return $actionList;
                })
                ->filter(function ($instance) use ($request) {

                    if ($request->has('name')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return (Str::contains($row['name'], $request->get('name')) || Str::equals($row['id'], $request->get('name'))) ? true : false;
                        });
                    }
                    if ($request->has('email')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return (Str::contains($row['email'], $request->get('email')) || Str::contains($row['name'], $request->get('email')) || Str::contains($row['contact'], $request->get('email'))) ? true : false;
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

}
