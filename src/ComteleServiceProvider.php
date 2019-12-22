<?php

namespace Andremellow\Comtele;

use Andremellow\Comtele\Channels\ComteleChannel;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Config\Repository as Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class ComteleChannelServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/comtele.php' => config_path('comtele.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
         $this->mergeConfigFrom(
            __DIR__.'/Config/comtele.php', 'comtele'
        );

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('comtele', function ($app) {
                return $this->createComteleChannel($app['config']);
            });
        });
    }

    public function createComteleChannel(Config $confg)
    {
        // Check for Nexmo config file.
        if (! $this->hasConfigSection()) {
            $this->raiseRunTimeException('Missing comtele configuration section.');
        }

        if ($this->configHas('send.url') === false) {
            $this->raiseRunTimeException('You must provide comtele.send.url when using a private key');
        }

        return new ComteleChannel();
    }

    /**
     * Checks if has global Nexmo configuration section.
     *
     * @return bool
     */
    protected function hasConfigSection()
    {
        return $this->app->make(Config::class)
                         ->has('comtele');
    }

    /**
     * Checks if Nexmo config has value for the
     * given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function configHas($key)
    {
        /** @var Config $config */
        $config = $this->app->make(Config::class);
        // Check for Nexmo config file.
        if (! $config->has('comtele')) {
            return false;
        }
        return
            $config->has('comtele.'.$key) &&
            ! is_null($config->get('comtele.'.$key)) &&
            ! empty($config->get('comtele.'.$key));
    }

    /**
     * Raises Runtime exception.
     *
     * @param string $message
     *
     * @throws \RuntimeException
     */
    protected function raiseRunTimeException($message)
    {
        throw new \RuntimeException($message);
    }
}