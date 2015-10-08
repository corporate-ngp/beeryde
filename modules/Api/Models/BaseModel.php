<?php
/**
 * To provide base model specific general feature along with the class
 *
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Api 
 */

namespace Modules\Api\Models;

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
