<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PracticeController extends Controller
{
    //

    public function example3() {
      // echo 'Environment: '.\App::environment();
      if(\App::environment() == 'local'){
        echo "Environment is local!";
      } else {
        echo "Environment is NOT local!";
      }
      echo '<br>';
      echo'App debug: '.config('app.debug');
      echo '<br>';
      echo config('mail.driver');
    }

    public function example4() {
      $random = new \Rych\Random\Random();
      return $random->getRandomString(8);
    }


}