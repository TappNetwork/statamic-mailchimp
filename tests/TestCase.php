<?php

namespace Silentz\Mailchimp\Tests;

use JMac\Testing\Traits\AdditionalAssertions;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Silentz\Mailchimp\ServiceProvider;
use Statamic\Extend\Manifest;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;

class TestCase extends OrchestraTestCase
{
    use AdditionalAssertions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [StatamicServiceProvider::class, ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'silentz/mailchimp' => [
                'id' => 'silentz/mailchimp',
                'namespace' => 'Silentz\\Mailchimp',
            ],
        ];

        config(['statamic.users.repository' => 'file']);
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $configs = ['assets', 'cp', 'forms', 'routes', 'static_caching', 'sites', 'stache', 'system', 'users'];

        foreach ($configs as $config) {
            $app['config']->set("statamic.$config", require __DIR__."/../vendor/statamic/cms/config/{$config}.php");
        }
    }
}
