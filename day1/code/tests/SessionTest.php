<?php

namespace tdd;

use Generator;
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../vendor/autoload.php';

class SessionTest extends TestCase
{
    /**
     * @dataProvider provideJobs
     * @test
    */
    public function add_jobs_accepts_int_array(array $jobs, ?string $exception): void
    {
        if ($exception)
            $this->expectException($exception);
        else
            $this->expectNotToPerformAssertions();

        $session = new Session();
        $session->addJobs(...$jobs);
    }

    public function provideJobs(): Generator
    {
        yield 'multiple valid datapoints has no exceptions' => [[6, 9, 15, -2, 92, 11], ''];
        yield 'single valid datapoint has no exceptions' => [[7], ''];
        yield 'invalid data has exceptions' => [['apple', 'orange', 'banana'], \TypeError::class];
    }

    /**
     * @dataProvider provideJobsAndStats
     * @test
     */
    public function getSessionStats_returns_expected_stats(array $jobs, SessionStats $expected): void
    {
        $session = new Session();
        if (! empty($jobs)) $session->addJobs(...$jobs);

        self::assertEquals($expected, $session->getSessionStats());
    } 

    public function provideJobsAndStats(): Generator
    {
        yield 'single job returns expected values' => [[7], new SessionStats(7, 7, 1, 7)];
        yield 'several jobs return expected values (rounded)' => [[6, 9, 15, -2, 92, 11], new SessionStats(-2, 92, 6, 21.83)];
        yield 'no jobs returns expected values' => [[], new SessionStats(0, 0, 0, 0)];
    }

}
