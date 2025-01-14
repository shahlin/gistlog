<?php

class BrowserKitTestCase extends Laravel\BrowserKitTesting\TestCase
{
    protected $baseUrl = 'http://localhost';

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    protected function setUp(): void
    {
        $this->skipSomeOnCi();

        parent::setUp();
    }

    protected function skipSomeOnCi()
    {
        $annotations = $this->getAnnotations();

        collect($this->getAnnotations())->each(function ($location) {
            if (! isset($location['requires'])) {
                return;
            }

            if (in_array('!Travis', $location['requires']) && env('TRAVIS') == true) {
                $this->markTestSkipped('This test does not run on Travis.');
            }
        });
    }
}
