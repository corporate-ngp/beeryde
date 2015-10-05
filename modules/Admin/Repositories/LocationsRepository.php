<?php namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Locations;

class LocationsRepository
{

    /**
     * Create a new RolegRepository instance.
     *
     * @param  Modules\Admin\Models\Locations $model
     * @return void
     */
    public function __construct(Locations $model)
    {
        $this->model = $model;
    }

    /**
     * Get all ipaddresses.
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get post collection.
     *
     * @param  int     $n
     * @param  int     $user_id
     * @param  string  $orderby
     * @param  string  $direction
     * @return Illuminate\Support\Collection
     */
    public function index($n, $orderby = 'created_at', $direction = 'desc')
    {
        return $this->model
                ->select('*')
                ->orderBy($orderby, $direction)
                ->paginate($n);
    }

    /**
     * Get post collection.
     *
     * @param  int     $n
     * @param  int     $user_id
     * @param  string  $orderby
     * @param  string  $direction
     * @return Illuminate\Support\Collection
     */
    public function indexFront($request)
    {

        $query = $this->model
            ->select('*');

        if (!empty($request['location'])) {
            $datalist = $query->where('location', 'like', '%' . $request['location'] . '%');
        }
        if (isset($request['status']) && $request['status'] != '') {
            $datalist = $query->where('status', '=', $request['status']);
        }
        switch ($request['order'][0]['column']) {
            case 1:
                $orderby = 'id';
                break;
            case 2:
                $orderby = 'location';
                break;
            case 3:
                $orderby = 'address';
                break;
            case 4:
                $orderby = 'country_id';
                break;
            case 5:
                $orderby = 'state_id';
                break;
            case 6:
                $orderby = 'city_id';
                break;
            case 7:
                $orderby = 'status';
                break;
            default:
                $orderby = 'id';
        }
        if (!empty($request['order'][0]['dir'])) {
            $query->orderBy($orderby, $request['order'][0]['dir']);
        }

        $datalist = $query->get();

        $iTotalRecords = count($datalist);

        $iDisplayLength = intval($request['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($request['start']);

        $records = array();
        $records["data"] = array();

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $status = [];

        for ($i = $iDisplayStart; $i < $end; $i++) {
            $id = ($i + 1);
            $statusInt = $datalist[$i]->status;
            $createDate = date('Y-m-d H:i:s', strtotime($datalist[$i]->created_at));
            if ($statusInt == 1) {
                $status = array("success" => "Active");
            } else {
                $status = array("danger" => "Inactive");
            }
            $country = 'India';
            $state = 'Maharastra';
            $city = 'Pune';
            $address = $datalist[$i]->address.',<br/>'.$datalist[$i]->address1.',<br/>'.$datalist[$i]->landmark.',<br/>'.$datalist[$i]->zipcode;
            $records["data"][] = array(
                '<input type="checkbox" name="id[]" value="' . $id . '">',
                $id,
                $datalist[$i]->location,
                $address,
                $country,
                $state,
                $city,
                '<span class="label label-sm label-' . (key($status)) . '">' . (current($status)) . '</span>',
                '<a class="btn btn-xs default yellow-gold margin-bottom-5 edit-form-link" href="javascript:;" title="Edit"><i class="fa fa-pencil"></i> </a>'
                . '<a href="javascript:;" class="btn btn-xs default red-thunderbird margin-bottom-5 trash-form-link" title="Delete"><i class="fa fa-trash-o"></i></a>'
            );
        }
        if (isset($request["customActionType"]) && $request["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK";
            $inputs = ['id' => $request['id'], 'status' => $request['customActionName']];
            $this->updateStatus($inputs);
            $records["customActionMessage"] = "Record(s) updated successfully!";
        }

        $records["draw"] = intval($request['draw']);
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        return $records;
    }

    /**
     * Get post collection.
     *
     * @param  int  $id
     * @return array
     */
    public function edit($id)
    {
        $result = $this->model->findOrFail($id);

        return compact('result');
    }

    /**
     * Update ipaddresses.
     *
     * @param  array  $inputs
     * @return void
     */
    public function update($inputs)
    {
        $model = $this->model->where('id', $id)->firstOrFail();
        $model->name = $inputs['name'];
        $model->status = isset($inputs['status']) ? $inputs['status'] : 0;
        $model->save();
    }

    /**
     * Update ipaddresses.
     *
     * @param  array  $inputs
     * @return void
     */
    public function updateStatus($inputs)
    {
        $model = $this->model->whereIn('id', $inputs['id']);
        var_dump($model);
        exit;
        $model->status = $inputs['status'];
        $model->save();
    }

    /**
     * Create or update a post.
     *
     * @param  array  $inputs
     * @param  bool   $user_id
     * @return Modules\Admin\Models\Ipaddress
     */
    public function store($inputs, $user_id = null)
    {
        $model = new $this->model;
        $model->name = $inputs['name'];
        $model->status = isset($inputs['status']) ? $inputs['status'] : 0;
        if ($user_id)
            $model->created_by = $user_id;

        $model->save();

        return $model;
    }

    /**
     * Get ipaddresss collection.
     *
     * @param  Modules\Admin\Models\Admin
     * @return Array
     */
    public function getAllSelect()
    {
        $select = $this->all()->lists('id', 'name');

        return compact('select');
    }
}
