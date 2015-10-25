<?php
/**
 * To present LinkCategory Model with associated authentication
 *
 *
 * @author NGP <corporate.ngp@gmail.com>

 
 */

namespace Modules\Admin\Models;

use Modules\Admin\Models\BaseModel;

class LinkCategory extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'link_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category', 'header_text', 'position', 'status', 'category_icon'];

    /**
     * get name of the category from ConfigSetting model when used in join
     * 
     * @return type
     */
    public function links()
    {
        return $this->hasMany('Modules\Admin\Models\Links');
    }
}
