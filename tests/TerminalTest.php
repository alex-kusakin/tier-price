<?php
/**
 * @author Alex Kusakin
 */

namespace TierPrice\Tests;

use PHPUnit\Framework\TestCase;
use TierPrice\ServiceLocator;

class TerminalTest extends TestCase
{
    /**
     * @var \TierPrice\Terminal
     */
    protected $terminal;

    protected function setUp() : void
    {
        $this->terminal = ServiceLocator::getTerminal();
        $this->terminal->setPricing(
            [
                'A' => [1 => 2.00, 4 => 7.00],
                'B' => [1 => 12.00],
                'C' => [1 => 1.25, 6 => 6.00],
                'D' => [1 => 0.15],
            ]
        );
    }

    /**
     * @dataProvider scanSequenceProvider
     *
     * @param $total
     * @param $codes
     * @throws \Exception
     */
    public function testTerminalScanning($total, $codes)
    {
        foreach ($codes as $code) {
            $this->terminal->scan($code);
        }

        $this->assertEquals($this->terminal->getTotal(), $total, 'Total does not match.');

    }

    /**
     * @return array
     */
    public function scanSequenceProvider()
    {
        return [
            [32.4, ['A','B','C','D','A','B','A','A']],
            [7.25, ['C','C','C','C','C','C','C']],
            [15.4, ['A','B','C','D']]
        ];
    }

}
