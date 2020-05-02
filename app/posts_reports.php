<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class posts_reports extends Model
{
    public static function unRead(){
        $reports=posts_reports::where('status','=','unRead')->get();
        if($reports!=null){
            foreach ($reports as $report) {
                $report->post_name= DB::table('posts')->where('id','=',$report->post_id)->get()->first()->post_name;
                $report->user_name= DB::table('users')->where('id','=',$report->user_id)->get()->first()->name;
            }
        }
        return $reports;
    }

}
