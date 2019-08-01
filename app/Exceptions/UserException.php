<?php
/**
 * Created by PhpStorm.
 * User: 24147
 * Date: 2019/8/1
 * Time: 15:08
 */

namespace App\Exceptions;


class UserException extends AppRuntimeException
{
    protected $codePrefix = '10';
}
