<?php
/**
 * The class to present SystemEmail model.
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>

 
 */

namespace Modules\Admin\Models;

use Modules\Admin\Models\BaseModel;

class SystemEmail extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'system_emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'email_to', 'email_cc', 'email_bcc', 'email_from', 'subject', 'text1', 'text2', 'email_type', 'status'];

}
