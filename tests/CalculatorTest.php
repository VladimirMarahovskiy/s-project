<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 04.04.19
 * Time: 17:06
 */

namespace App\Tests;

use App\Util\Calc;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAdd()
    {
        $calculator = new Calc();
        $result = $calculator->add(30, 12);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
}