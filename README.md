# laravel filesystem oss

> `"aliyuncs/oss-sdk-php": "^2.4"` doesObjectExist这个API，（CDN域名实例化），必须开启私有bucket回源才可以使用，但是开启了私有bucket回源的CDN，没有任何上传的权限，只能访问（角色限制）。

**只有使用OSS地域域名可调用全部接口**

```
composer require "lostinfo/laravel-filesystem-oss"
```

## Configuration

app/filesystems.php

```php
'disks' => [
    ...
    'oss' => [
        'driver'     => 'oss',
        'root'       => '',
        'access_key' => env('OSS_ACCESS_KEY'),
        'secret_key' => env('OSS_SECRET_KEY'),
        'bucket'     => env('OSS_BUCKET'),
        'endpoint'   => env('OSS_ENDPOINT'),
        'is_cname'   => env('OSS_IS_CNAME', false),
        'cdn_url'    => env('OSS_CDN_URL'), # 配置后 Storage::url('xxx.png') 返回CDN域名路径
        'buckets'    => [],
    ],
]
```
