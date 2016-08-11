<?php

namespace Morrelinko\SafiApi;

class Schedule
{
    protected $client;

    public function __construct(SafiApi $client)
    {
        $this->client = $client;
    }

    /**
     * Gets all the collection & delivery time schedules
     * @return array|mixed
     */
    public function all()
    {
        // return $this->client->call('GET', 'times');
        return $this->generateMockSchedules();
    }

    public function get()
    {
        return null;
    }

    public function dailySchedules()
    {
        $res = [];
        $times = ['08', '10', '12', '14', '16', '18', '20'];

        foreach ($times as $time) {
            $res[] = [
                'time' => $time . ':00:00 - ' . ($time + 2) . ':00:00',
                'pickups' => 32
            ];
        }

        return $res;
    }

    protected function generateMockSchedules()
    {
        $schedules = [];
        $period = Period::createFromMonth(2016, 6);

        foreach ($period->getDatePeriod('1 DAY') as $day) {
            /** @var $day \DateTimeImmutable */
            $schedules[$day->format('Y-m-d')] = $this->generateMockTimes();
            $schedules[$day->format('Y-m-d')] = $this->generateMockTimes();
        }

        return $schedules;
    }

    protected function generateMockTimes()
    {
        $res = [];
        $times = ['08', '10', '12', '14', '16', '18', '20'];

        foreach ($times as $time) {
            $res[$time . ':00:00 - ' . ($time + 2) . ':00:00'] = [
                'collections' => [
                    'is_available' => true,
                    'total_pickup' => 12,
                    'time_size' => 32
                ],
                'deliveries' => [
                    'time' => $time . ':00:00 - ' . ($time + 2) . ':00:00',
                    'is_available' => true,
                    'total_pickup' => 12,
                    'time_size' => 32
                ]
            ];
        }

        return $res;
    }
}
