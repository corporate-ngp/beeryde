<?php
/**
 * The class for managing FAQ specific actions.
 * 
 * 
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Http\Controllers;

use Auth;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Admin\Models\Faq;
use Modules\Admin\Repositories\FaqCategoryRepository;
use Modules\Admin\Repositories\FaqRepository;
use Modules\Admin\Http\Requests\FaqCreateRequest;
use Modules\Admin\Http\Requests\FaqUpdateRequest;

class FaqController extends Controller
{

    /**
     * The FaqRepository instance.
     *
     * @var Modules\Admin\Repositories\FaqRepository
     */
    protected $repository;

    /**
     * The FaqRepository instance.
     *
     * @var Modules\Admin\Repositories\FaqCategoryRepository
     */
    protected $faqCategoryRepository;

    /**
     * Create a new FaqController instance.
     *
     * @param  Modules\Admin\Repositories\FaqRepository $repository
     * @return void
     */
    public function __construct(FaqRepository $repository, FaqCategoryRepository $faqCategoryRepository)
    {
        parent::__construct();
        $this->middleware('acl');
        $this->repository = $repository;
        $this->faqCategoryRepository = $faqCategoryRepository;
    }

    /**
     * List all the data
     * @return response
     */
    public function index()
    {
        $allCategoriesList = $this->faqCategoryRepository->listAllCategoriesData()->toArray();
        $categoryList = $this->faqCategoryRepository->listCategoryData()->toArray();

        return view('admin::faq.index', compact('categoryList', 'allCategoriesList'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return datatable
     */
    public function getData(Request $request)
    {
        $faqs = $this->repository->data();
        //filter to display own records
        if (Auth::user()->hasOwnView && (empty(Auth::user()->hasEdit) || empty(Auth::user()->hasDelete))) {
            $faqs = $faqs->filter(function ($row) {
                return (Str::equals($row['created_by'], Auth::user()->id)) ? true : false;
            });
        }

        return Datatables::of($faqs)
                ->addColumn('status', function ($faq) {
                    $status = ($faq->status == 1) ? '<span class="label label-sm label-success">Active</span>' : '<span class="label label-sm label-danger">Inactive</span>';
                    return $status;
                })
                ->addColumn('question_answer', function ($faq) {
                    $actionList = '';
                    $actionList = '<b>' . $faq->question . '</b><br />[' . $faq->answer . ']';
                    return $actionList;
                })
                ->addColumn('action', function ($faq) {
                    $actionList = '';
                    if (!empty(Auth::user()->hasEdit) || (!empty(Auth::user()->hasOwnEdit) && ($faq->created_by == Auth::user()->id))) {
                        $actionList = '<a href="javascript:;" id="' . $faq->id . '" data-action="edit" data-id="' . $faq->id . '" id="' . $faq->id . '" class="btn btn-xs default margin-bottom-5 yellow-gold edit-form-link" title="Edit"><i class="fa fa-pencil"></i></a>';
                    }
                    return $actionList;
                })
                ->make(true);
    }

    /**
     * Display a form to create new faq.
     * 
     * @return view as response
     */
    public function create()
    {
        $categoryList = $this->faqCategoryRepository->listCategoryData()->toArray();

        return view('admin::faq.create', compact('categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\FaqCreateRequest $request
     * @return json encoded Response
     */
    public function store(FaqCreateRequest $request)
    {
        $response = $this->repository->create($request->all());

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified configuration setting.
     *
     * @param  Modules\Admin\Models\Faq $faq, Modules\Admin\Repositories\FaqCategoryRepository $faqCategoryRepository
     * @return json encoded Response
     */
    public function edit(Faq $faq)
    {
        $categoryList = $this->faqCategoryRepository->listCategoryData()->toArray();

        $response['success'] = true;
        $response['form'] = view('admin::faq.edit', compact('faq', 'categoryList'))->render();

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\FaqUpdateRequest $request, Modules\Admin\Models\Faq $faq 
     * @return json encoded Response
     */
    public function update(FaqUpdateRequest $request, Faq $faq)
    {
        $response = $this->repository->update($request->all(), $faq);

        return response()->json($response);
    }
}
