<?php namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;

class SitePagesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('site_pages')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::unprepared(file_get_contents(__DIR__ . '/site_pages.sql'));
    }
}
