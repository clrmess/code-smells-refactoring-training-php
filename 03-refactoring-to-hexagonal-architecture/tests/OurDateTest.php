<?php

declare(strict_types=1);

use App\OurDate;
use PHPUnit\Framework\TestCase;

class OurDateTest extends TestCase
{

    /** @test */
    public function isSameDate()
    {
        $OurDate = new OurDate('1789/01/24');
        $sameDay = new OurDate('2001/01/24');
        $notSameDay = new OurDate('1789/01/25');
        $notSameMonth = new OurDate('1789/02/24');

        $this->assertTrue($OurDate->isSameDay($sameDay), 'same');
        $this->assertFalse($OurDate->isSameDay($notSameDay), 'not same day');
        $this->assertFalse($OurDate->isSameDay($notSameMonth), 'not same month');
    }

    /**
     * @test
     * @dataProvider invalidDates
     */
    public function invalidDateAreNotCreated($date)
    {
        $this->expectException(InvalidArgumentException::class);
        new OurDate($date);
    }

    public function invalidDates(): array
    {
        return [
            'empty date' => [''],
            'invalid format' => ['1789-02-25'],
        ];
    }}
