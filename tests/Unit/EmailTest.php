<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Traits\MessengerTrait;

class EmailTest extends TestCase
{
    /**
     * A basic parameters for test
     *
     * @return void
     */
    public function emailDataProvider() {
        return [
            ['test@example.com', true],
            ['test@mail.ru', true],
            ['test@gmail.ru', true],
            ['test@mail', false],
            ['111@mail', false]
        ];
    }

    /**
     * @dataProvider emailDataProvider
     */
    public function testEmailCheck($email, $expected)
    {
        $result = MessengerTrait::checkValidateEmail($email);

        $this->assertEquals($expected, $result);
    }
}
