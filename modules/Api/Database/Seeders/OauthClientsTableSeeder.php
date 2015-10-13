<?php namespace Modules\Api\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;
use Modules\Api\Repositories\OauthClientRepository as OauthClient;

class OauthClientsTableSeeder extends Seeder
{
    
    public function __construct(OauthClient $oauthClient)
    {
        $this->model = $oauthClient;
    }
    
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('oauth_clients')->truncate();                                
        $data['id'] = 'f3d259ddd3ed8ff3843839b';
        $data['secret'] = '4c7f6f8fa93d59c45502c0ae8c4a95b';
        $data['name'] = 'web';        
        $data['created_at'] = Carbon::now();            
        $data['updated_at'] = Carbon::now();
        $this->model->create($data);        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    
}