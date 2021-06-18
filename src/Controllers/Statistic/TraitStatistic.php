<?php


namespace severApp\Controllers\Statistic;


use Exception;
use severApp\Helpers\Message;
use severApp\Models\StatisticModel;

trait TraitStatistic
{
    public string $filter='';
    public int $sum=0;
    public function getToday(): string
    {
        return ' (DATE(createDate) = CURDATE())';
    }

    public function getYesterday(): string
    {
        return ' (DATE(createDate) = DATE(CURDATE() - INTERVAL 1 DAY))';
    }

    public function getThisWeek(): string
    {
        return ' (YEARWEEK(createDate, 7) = YEARWEEK(CURDATE(), 7))';
    }

    public function getThisMonth(): string
    {
        return ' ((Year(createDate) =  Year(CURDATE())) AND (Month(createDate) = Month(CURDATE())))';
    }

    public function getLastWeek(): string
    {
        return ' (YEARWEEK(createDate,7) = YEARWEEK(CURDATE(),7)-1)';
    }

    public function getLastMonth(): string
    {
        return ' ((Year(createDate) =  Year(CURDATE())) AND (Month(createDate) = Month(CURDATE())-1))';
    }

    /**
     * @throws Exception
     */
    private function coverTimeline($filter)
    {
        $aDate = [];
        $this->filter=$filter;
        $aTimeline = [];
        switch ($filter) {
            case'today':
            case'yesterday':
                $filter = $this->parseQuery($filter);
                $aDate = StatisticModel::getTotalWithFilter("DATE(createDate) as date", $filter);
                if (empty($aDate)){
                    return [
                        'sum'=>0,
                        'date'=>($this->filter=='today')?date('d-m-Y',strtotime('now')):date('d-m-Y',(strtotime('now')-86400))
                    ];
                }
                return [
                    'sum'=>$aDate[0][1],
                    'date'=>$aDate[0][0]
                ];
            case 'thisWeek':
            case 'lastWeek':
                $filter = $this->parseQuery($filter);
                $aDate = StatisticModel::getTotalWithFilter('DATE(createDate) as date', $filter);
                break;
            case 'thisMonth':
            case 'lastMonth':
                $aDate['type'] = $filter;
                $filter = $this->parseQuery($filter);
                $aDate = StatisticModel::getTotalWithFilter('Week(createDate) as date,Year(createDate) as year', $filter,
                    'date,year');
                break;
            default:
                throw new Exception('filter sai ten filer rồi', 404);
                break;
        }
        if (is_array($aDate)) {
            switch ($this->filter) {
                case 'thisMonth':
                    $aWeekInMonth = [];
                    $year=date('Y', time());
                    $month= date('m', time());
                    $week = date('W', strtotime($year . '-' .  $month . '-01')); // weeknumber of first day of
                    // month

                    $aDateRangeInWeek = [
                        'from' => date('d-m-Y', strtotime($year . '-' . $month . '-01'))
                    ];
                    $unix = strtotime($year . 'W' . $week . '+1 week');
                    while (date('m', $unix) == $month) {
                        $aDateRangeInWeek['to'] = date('d-m-Y', $unix - 86400); // Chu nhat tuan trc
                        //var_dump($aDateRangeInWeek);die();
                        if (isset($aDateRangeInWeek['from']) && isset($aDateRangeInWeek['to'])) {
                            $weekNumber = date('W', $unix - 1); // Xac dinh tuan hien tai
                            $aDateRangeInWeek['summary'] = $this->foundStatisticDataInMonth($weekNumber,$aDate);

                            $aWeekInMonth[] = $aDateRangeInWeek;
                            $aDateRangeInWeek = [];
                        }

                        $aDateRangeInWeek['from'] =date('d-m-Y', $unix);
                        $unix = $unix + (86400 * 7);
                    }
                    $aDateRangeInWeek['to'] = date(
                       'd-m-Y',
                        $unix = strtotime('last day of ' . $year . "-" . $month));

                    $aDateRangeInWeek['summary'] = $this->foundStatisticDataInMonth(date('W', $unix),$aDate);
                    $aWeekInMonth[] = $aDateRangeInWeek;
                    $aTimeline = $aWeekInMonth;
                    break;
                case 'lastMonth':
                    $aWeekInMonth = [];
                    $year=date( 'Y', \time() );
                    $month= Date("m", strtotime("first day of previous month"));
                    $week = date('W', strtotime($year . '-' .  $month . '-01')); // weeknumber of first day of
                    // month

                    $aDateRangeInWeek = [
                        'from' => date('d-m-Y', strtotime($year . '-' . $month . '-01'))
                    ];
                    $unix = strtotime($year . 'W' . $week . '+1 week');
                    while (date('m', $unix) == $month) {
                        $aDateRangeInWeek['to'] = date('d-m-Y', $unix - 86400); // Chu nhat tuan trc
                        //var_dump($aDateRangeInWeek);die();
                        if (isset($aDateRangeInWeek['from']) && isset($aDateRangeInWeek['to'])) {
                            $weekNumber = date('W', $unix - 1); // Xac dinh tuan hien tai
                            $aDateRangeInWeek['summary'] = $this->foundStatisticDataInMonth($weekNumber,$aDate);

                            $aWeekInMonth[] = $aDateRangeInWeek;
                            $aDateRangeInWeek = [];
                        }

                        $aDateRangeInWeek['from'] =date('d-m-Y', $unix);
                        $unix = $unix + (86400 * 7);
                    }
                    $aDateRangeInWeek['to'] = date(
                        'd-m-Y',
                        $unix = strtotime('last day of ' . $year . "-" . $month));

                    $aDateRangeInWeek['summary'] = $this->foundStatisticDataInMonth(date('W', $unix),$aDate);
                    $aWeekInMonth[] = $aDateRangeInWeek;
                    $aTimeline = $aWeekInMonth;
                    break;
                case 'lastWeek':
                    $unixTime = strtotime("last week");
                    for ($i = 1; $i <= 7; $i++) {
                        $date = date('Y-m-d', $unixTime);

                        $aTimeline[] = [
                            'from'    => $date,
                            'to'      => $date,
                            'summary' => $this->foundStatisticDataInWeek($date,$aDate)
                        ];
                        $unixTime = $unixTime + 86400; // next day
                    }
                    break;
                case 'thisWeek':
                    $unixTime = strtotime("this week");
                    for ($i = 1; $i <= 7; $i++) {
                        $date = date('Y-m-d', $unixTime);

                        $aTimeline[] = [
                            'from'    => $date,
                            'to'      => $date,
                            'summary' => $this->foundStatisticDataInWeek($date,$aDate)
                        ];
                        $unixTime = $unixTime + 86400; // next day
                    }

                    break;

            }
        }

        return $aTimeline;

    }
    private function foundStatisticDataInMonth($weekNumber,$aDate): int
    {
        if (empty($aDate)) {
            return 0;
        }

        foreach ($aDate as $order => $aWeekReport) {
            if (isset($aWeekReport[0]) && $aWeekReport[0] == $weekNumber) {
                unset($aDate[$order]);

                $this->calculateSum($aWeekReport[2]);

                return $aWeekReport[2];
            }
        }

        return 0;
    }
    private function foundStatisticDataInWeek($date,$aData): int
    {
        if (empty($aData)) {
            return 0;
        }

        foreach ($aData as $order => $aDailyReport) {
            if ($aDailyReport[0] == $date) {
                unset($aData[$order]);

                $this->calculateSum( (int) $aDailyReport[1]);

                return $aDailyReport[1];
            }
        }

        return 0;
    }

    private function calculateSum(int $dailySum): void
    {
        $this->sum = $this->sum + $dailySum;
    }
    public function parseQuery($filter)
    {
        $method = "get" . ucfirst($filter);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], []);
        }

    }
}