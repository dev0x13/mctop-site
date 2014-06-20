<?php

Class SecurityVoteLayer
{

    private $project;
    private $SLON;
    public $flags;

    public function __construct(&$project)
    {

        $this->project = $project;
        $this->checkMultivote();

        if (!$this->flags['multivote']) {

            if (($this->project->getVotesCountMonth()) > 10)
                $this->checkVotesInterval();

            $this->checkDayOverflow();
            $this->checkAuditoryOverflow();

            $this->checkUserAvatar();

            $this->checkBrowserUniqueness();
        }

    }

    public function checkMultivote()
    {
        if (Votes::model()->isVoteExists($this->project->id)) {
            $this->flags['multivote'] = 1;
            return false;
        } else
            return true;

    }

    public function checkDayOverflow()
    {
        if (Yii::app()->request->isPostRequest) {
            if ($this->project->redisRecord->stats->votes_today + 1 > $this->project->redisRecord->stats->avg_online_day) {

                if (!Yii::app()->redis->getClient()->get('helpers:project:' . $this->project->id . ':report:letter_was_sent')) {
                    $role = ProjectsRoles::model()->find('role=2 and project=:project', array(':project' => $this->project->id));
                    $user = Users::model()->findByPk($role->user);

                    $YII_language = Yii::app()->language;

                    if ($user->language == 'en') {
                        if (Yii::app()->language != 'en') {
                            Yii::app()->language = 'en';
                        }
                    }
                    $message = Yii::t('translations', '
                    Здравствуйте!

                    По нашим сведениям на Вашем проект была замечена подозрительная деятельность.

                    Просим Вас выслать доступ к статистике Вашего сайта.

                    С уважением, MCTop Team');

                    $mail = mail($user->email, 'MCTop: ' . Yii::t('translations', 'Посещаемость сайта'), $message, 'From: MCTop. <webmaster@mctop.im>' . "\r\n" .
                        'Reply-To: webmaster@mctop.im');
                    Yii::app()->redis->getClient()->set('helpers:project:' . $this->project->id . ':report:letter_was_sent', 1);

                    Yii::app()->language = $YII_language;
                }

                $this->flags['DayOverflow'] = 1;

            }
        }
    }

    public function checkAuditoryOverflow()
    {
        if (Yii::app()->request->isPostRequest) {
            if ($this->project->redisRecord->stats->votes_today + 1 > $this->project->redisRecord->stats->players_count)
                $this->flags['AuditoryOverflow'] = 1;
        }
    }

    public function checkBrowserUniqueness()
    {
        if (Votes::model()->isRepeatingUserAgent($this->project->id))
            $this->flags['useragent'] = 1;
    }

    public function checkVotesInterval()
    {
        if (Yii::app()->request->isPostRequest) {
            if (Votes::model()->isWrongInterval($this->project->id))
                $this->flags['interval'] = 1;
        }
    }

    public function checkUserAvatar()
    {
        if (Users::model()->findByPk(Yii::app()->user->id)->avatar == 'http://vk.com/images/camera_a.gif')
            $this->flags['avatar'] = 1;
    }

    public function InitSLON()
    {
        $this->SLON = new SLON($this->project->id, $this->flags);
    }

}
