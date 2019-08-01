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
