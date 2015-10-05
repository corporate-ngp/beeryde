<?php namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\LocationsRepository;

class LocationsController extends Controller
{

    /**
     * The LocationsRepository instance.
     *
     * @var Modules\Admin\Repositories\LocationsRepository
     */
    protected $repository;

    /**
     * Create a new IpaddressController instance.
     *
     * @param  Modules\Admin\Repositories\LocationsRepository $repository
     * @return void
     */
    public function __construct(
    LocationsRepository $repository)
    {
        $this->repository = $repository;

        //$this->middleware('ajax', ['only' => ['indexOrder', 'indexFront']]);
    }

    //default method (verb/action - GET)
    public function index(Request $request)
    {
//        $results = $this->repository->index(10);
//        $links = str_replace('/?', '?', $results->render());
//        return view('admin::locations.index', compact('links', 'results'));
        return view('admin::locations.index');
    }

    //Add form (verb/action - GET)
    public function create()
    {

        return view('admin::locations.create');
    }

    //Add Form action processes here (verb/action - POST)
    public function store(Request $request)
    {
        $this->repository->store($request->all());

        return redirect('admin/locations')->with('ok', 'Data added successfully.');
    }

    //View the record (verb/action - GET)
    public function show($id)
    {
        
    }

    //Edit form (verb/action - GET)
    public function edit($id)
    {
        return view('admin::locations.edit', $this->repository->edit($id));
    }

    //Edit form action processes (verb/action - PUT/PATCH)
    public function update(Request $request, $id)
    {
        echo "<pre>";
        print_r($request);
        die();
        $this->repository->update($request->all(), $id);

        return redirect('admin/locations')->with('ok', 'Data updated successfully.');
    }

    //Delete record (verb/action - DELETE)
    public function destroy()
    {
        
    }

    public function indexFront(Request $request)
    {
        return $this->repository->indexFront($request->all());
    }
}
