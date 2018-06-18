<?php

namespace  Tests;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Webmozart\Assert\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        TestResponse::macro('data', function ($key) {
            return $this->original->getData()[$key];
        });

        EloquentCollection::macro('assertEquals', function ($items) {
            Assert::count($items->count(), $this);
            $this->zip($items)->each(function ($itemPair) {
                Assert::assertTrue($itemPair[0]->is($itemPair[1]));
            });
        });
    }
}
