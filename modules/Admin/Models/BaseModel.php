<?php
/**
 * To provide base model specific general feature along with the class
 *
 * @author NGP <corporate.ngp@gmail.com>

 
 */

namespace Modules\Admin\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    /**
     * Return Table represent with the associated model
     * 
     * @return tablename
     */
    public static function table()
    {
        $instance = new static;
        return $instance->getTable();
    }

    /**
     * Return Table columns with the associated model
     * 
     * @return table columns
     */
    public static function getTableColumns($tableName)
    {
        return Schema::getColumnListing($tableName);
    }
}
