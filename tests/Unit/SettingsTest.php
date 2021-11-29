<?php

namespace Tests\Unit;

use Tests\TestCase;

class SettingsTest extends TestCase
{
    public function test_get_nonexistent_setting()
    {
        $this->assertNull(settings('example'));
    }

    public function test_get_default_setting()
    {
        $this->assertEquals(settings('example', 'default value'), 'default value');
    }

    public function test_put_setting()
    {
        settings()->put('example', 'foo');

        $this->assertEquals(settings('example'), 'foo');

        settings()->forget('example');
    }

    public function test_forget_setting()
    {
        settings()->put('example', 'foo');
        settings()->forget('example');
        $this->assertNull(settings('example'));
    }
}