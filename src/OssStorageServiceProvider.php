<?php

namespace Lostinfo\LaravelFilesystemOss;

use Iidestiny\Flysystem\Oss\OssAdapter;
use Iidestiny\Flysystem\Oss\Plugins\FileUrl;
use Iidestiny\Flysystem\Oss\Plugins\Kernel;
use Iidestiny\Flysystem\Oss\Plugins\SetBucket;
use Iidestiny\Flysystem\Oss\Plugins\SignatureConfig;
use Iidestiny\Flysystem\Oss\Plugins\SignUrl;
use Iidestiny\Flysystem\Oss\Plugins\TemporaryUrl;
use Iidestiny\Flysystem\Oss\Plugins\Verify;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class OssStorageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app('filesystem')->extend('oss', function ($app, $config) {
            $root    = $config['root'] ?? null;
            $buckets = $config['buckets'] ?? [];
            $adapter = new OssAdapter(
                $config['access_key'],
                $config['secret_key'],
                $config['endpoint'],
                $config['bucket'],
                $config['is_cname'],
                $root,
                $buckets
            );

            $adapter->setCdnUrl($config['cdn_url'] ?? null);

            $filesystem = new Filesystem($adapter);

            $filesystem->addPlugin(new FileUrl());
            $filesystem->addPlugin(new SignUrl());
            $filesystem->addPlugin(new TemporaryUrl());
            $filesystem->addPlugin(new SignatureConfig());
            $filesystem->addPlugin(new SetBucket());
            $filesystem->addPlugin(new Verify());
            $filesystem->addPlugin(new Kernel());

            return $filesystem;
        });
    }
}
