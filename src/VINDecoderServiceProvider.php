<?php

namespace Errorname\VINDecoder;

use Illuminate\Support\ServiceProvider;

class VINDecoderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Decoder::initDecoder();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
