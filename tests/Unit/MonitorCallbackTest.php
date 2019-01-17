<?php

namespace Tests\Unit;

use App\MonitorCallback;
use Tests\TestCase;

class MonitorCallbackTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateKey()
    {
        $this->assertEquals(strlen(MonitorCallback::createKey()), 64);
    }
}
