<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\MessageBag;

class IpLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $check_type 限制类型
     * @param  string $ipListConfigKey ip配置
     * @return mixed
     */
    public function handle($request, Closure $next, $check_type = 'BLACK', $ipListConfigKey = 'admin_white_list')
    {

        if ($this->check_ip_denied($check_type, $ipListConfigKey) == false) {
            return $next($request);
        } else {
             abort(403,  'ip access denied.' . $request->getClientIp(),['title' => 'ip access denied:' . $request->getClientIp()]);
        }
    }


    /**
     * 设置ip是否禁止访问
     *
     * @param string $checkType 检查类型,'WHITE':白名单检查,'BLACK':黑名单检查
     * @param null $ipListConfigKey 数组或者以逗号分隔的字符串
     *
     * @return bool
     */
    public function check_ip_denied($checkType = 'WHITE', $ipListConfigKey = null)
    {
        $access_ip = request()->getClientIp();

        $ip_list = config($ipListConfigKey);
        if (!$ip_list) {
            return false;
        }
        $ip_list = is_string($ip_list) ? explode(',', $ip_list) : $ip_list;
        //是否禁止访问.设置白名单策略,默认禁止.黑名单,默认允许
        $access_denied = ($checkType == 'WHITE') ? true : false;

        foreach ($ip_list as $ip) {
            //如果星号之前的IP段字符串是客户端IP的子串

            if (strpos($access_ip, '*') != false) {
                $ip = substr($ip, 0, strpos($ip, '*') - 1);
                if (strpos($access_ip, $ip) !== false) {
                    $access_denied = ($checkType == 'WHITE') ? false : true;
                    break;
                }
            } else {
                $method = substr_count($access_ip, ':') > 1 ? 'checkIp6' : 'checkIp4';
                if (\Symfony\Component\HttpFoundation\IpUtils::$method($access_ip, $ip)) {
                    $access_denied = ($checkType == 'WHITE') ? false : true;
                    break;
                }
            }
        }

        return $access_denied;
    }


}
