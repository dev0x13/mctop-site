<?php


class SLON
{

    protected $flags;
    protected $project;

    public function __construct($project, $flags)
    {
        $this->project = $project;
        $this->flags = $flags;
        if ($this->NeedsToReport())
            $this->sendReport();

    }

    private function NeedsToReport()
    {
        if (isset($this->flags))
            foreach ($this->flags as $flag_name => $value) {
                if ($flag_name == 'DayOverflow' || $flag_name == 'AuditoryOverflow' || $flag_name = 'interval' || $flag_name = 'avatar')
                    return true;
            }
        return false;
    }

    public function sendReport()
    {
        //todo SUKA!
        /*$report = RedisSlon::model()->findByPk($this->project);
        if (is_null($report)) {
            $report = new ProjectsReports();
            $report->project_id = $this->project;
            $report_template['description'] = 'Обнаружена подозрительная активность';
            $report_template['flags'] = $this->flags;
            $report->report = HUtils::json_encode_cyr($report_template);
            $report->time = time();
            $report->save();
        } else {
            $report = new ProjectsReports();
            $report->project_id = $this->project;
            $report_template['description'] = 'Обнаружена подозрительная активность';
            $report_template['flags'] = $this->flags;
            $report->report = HUtils::json_encode_cyr($report_template);
            $report->time = time();
            $report->saveAnotherReport();
        }
        //VarDumper::dump($report,10);*/
    }

}