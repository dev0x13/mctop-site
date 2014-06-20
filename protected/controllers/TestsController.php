<?php

    class TestsController extends Controller
    {


    public function actionIndex()
    {
        echo 1;
    }


    public function actionServers_Set()
    {
        $model = new RedisServers();
        $model->set_id(30);
        $model->set_project_id(79);
        $model->set_ip('94.23.229.141');
        $model->set_port(25570);
        $model->set_protocol_version('old');
        $model->save();
    }


    public function actionServers_Get()
    {
        $server = RedisServers::model()->get(30);
        puts($server);
    }

    public function actionProjects_Set()
    {
        $model = new RedisProjects(array(
            'id'=>79,
            'set_of_servers_ids' => array(
                30,
                31
            ),
            'set_of_votes_ids' => array(
                1
            ),
            'set_of_slon_reports' => array(
                1
            )
        ));
        $model->save();
        puts($model);
        $redis = Yii::app()->projects->getClient();
        puts($redis->sMembers('project:79:servers_id'));
    }


    public function actionProjects_Get()
    {
        $project = RedisProjects::model()->get(79);
        puts($project);
    }

    public function actionGet_all_servers()
    {
        echo 1;
    }

}
