<?php

namespace App\Models;



class Functions
{

      public static function Projects_list()
      {
          return Project::where('status',1)->select('id','name','image')->get();
      }

      public static function settings_data()
      {
         return Setting::pluck('value','title');
      }

}
