<?php
/**
 * Created by PhpStorm.
 * User: 24147
 * Date: 2019/8/1
 * Time: 14:26
 */

namespace App\Http\Controllers\Users;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Response;
use Dingo\Api\Routing\Helpers;


class BaseController extends Controller
{
    use Response;
    use Helpers;

}
