
环境
```text
php > 7.2
mysql > 5.6
redis > 3.0

```

运行环境
```text
local      本地
testing    测试
production 生产
```

参考文档
```text
[laravel 5.8](https://learnku.com/docs/laravel/5.8)

[Laravel 项目开发规范](https://learnku.com/docs/laravel-specification/5.5)

[Dingo API 2.0.0 中文文档](https://learnku.com/docs/laravel-specification/5.5)

```

安装
```bash
   
   git clone  
   
   cp .env.example .env
   # 修改 数据库配置
   edit db config
   # 安装PHP 依赖 
   composer install
   # 安装  js
   cnpm install
   #
   php artisan key:generate --ansi
   # jwt
   php artisan jwt:secret --force --ansi
   
   
   php artisan migrate
   
   php artisan admin:install
   
   php artisan admin:import helpers
   
   php artisan admin:import config
    
   php artisan passport:keys
  
    
```


```text

    代码分层
    services 服务层
    
    models  模型层 

    路由
    userLog  user-logs
    
   
    Controller/client 客户端 
    Controller/users  用户端 

```
