<?php
/**
 * Created by PhpStorm.
 * User: 24147
 * Date: 2019/8/1
 * Time: 14:35
 */

namespace App\Http\Controllers\Users;


use App\Exceptions\UserException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HomeController extends BaseController
{

    public function index(Request $request)
    {

        throw new UserException(1,'333');
      return  $this->success();
    }

}
