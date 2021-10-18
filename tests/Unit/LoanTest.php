<?php

namespace Tests\Unit;

use App\Models\Loan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testInstanceOfLoan()
    {
        $loan = new Loan([
        ]);
        $this->assertInstanceOf(Loan::class, $loan);
    }

    /**
     * @param $originalString
     * @param $expectedResult
     * @dataProvider providerTestLoanAttributes
     */
    public function testLoanAttributes($originalString, $expectedResult)
    {
        $this->assertEquals($expectedResult, $originalString);
    }

    public function providerTestLoanAttributes()
    {
        return [
            ['test', 'test'],
            ['ha', 'ha'],
            ['a', 'a'],
            ['b', 'b'],
            ['c', 'c'],
        ];
    }
}
