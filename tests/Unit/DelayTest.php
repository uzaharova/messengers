<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Traits\MessengerTrait;

class DelayTest extends TestCase
{
    /**
     * A basic parameters for test.
     *
     * @return void
     */
    public function delayDataProvider() {
        return [
            ['02.03.2019 12:00:00', 1551526800, 1200],
            ['02.03.2019 10:00:00', 1551526800, 0],
            ['02.03.2019 11:40:00', 1551526800, 0],
            ['02.03.2019 11:42:00', 1551526800, 120]
        ];
    }

    /**
     * @dataProvider delayDataProvider
     */
    public function testDelayCheck($delay_date, $start, $expected)
    {
        $delay = MessengerTrait::getDelay($delay_date, $start);

        $this->assertEquals($expected, $delay);
    }
}
