<?php namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

}
