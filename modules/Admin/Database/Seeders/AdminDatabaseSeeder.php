<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call('Modules\Admin\Database\Seeders\AdminsTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\IpAddressesTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\LinkCategoriesTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\UserTypeTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\LinksTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\UserTypeLinksTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\LocationsTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\ConfigCategoryTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\ConfigSettingsTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\SystemEmailsTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\SitePagesTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\UsersTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\UserLinksTableSeeder');
        $this->call('Modules\Admin\Database\Seeders\CarBrandsTableSeeder');

        //enable foreign key check for this connection after running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Model::reguard();
    }
}
