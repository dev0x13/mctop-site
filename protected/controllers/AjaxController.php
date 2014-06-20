<?php

class AjaxController extends Controller
{
    public function actionUsersList()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $login = Yii::app()->request->getQuery('term');
            $q = new CDbCriteria(array(
                'condition' => "login LIKE :match",
                'params' => array(':match' => "%$login%")
            ));
            $users = Users::model()->findAll($q);
            $lists = array();
            foreach ($users as $user) {
                $lists[] = $user;
            }
            echo HUtils::json_encode_cyr($lists);
        }
    }

    public function actionAutocompleteTest()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $res = array();

            if (isset($_GET['term'])) {
                $qtxt = "SELECT login FROM users WHERE login LIKE :login";
                $command = Yii::app()->db->createCommand($qtxt);
                $command->bindValue(":login", '%' . $_GET['term'] . '%', PDO::PARAM_STR);
                $res = $command->queryColumn();
            }

            echo CJSON::encode($res);
            Yii::app()->end();
        }
    }

    public function actionProjectSetRolesUsers($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $res = array();

            if (isset($_GET['term'])) {

                if (isset($_GET['id'])) {
                    $project_id = (int)$_GET['id'];
                    $users = Users::model()->preliminarySearch(($_GET['term']));

                    if (!is_null($users))
                        $filteredUsers = ProjectsRoles::model()->preliminaryFilterRolesInProject($users, $project_id);

                    if (!is_null($filteredUsers))
                        $res = $filteredUsers;

                }

            }

            echo CJSON::encode($res);
            Yii::app()->end();
        }
    }

    public function actionBonusScriptCheck()
    {
        if (Yii::app()->request->isAjaxRequest) {

            if (!Yii::app()->user->isGuest) {
                if (isset($_POST['Projects']['script_url']) && isset($_POST['Projects']['secret_key'])) {
                    $user = Users::model()->findByPk(Yii::app()->user->id);
                    $nickname = 'MCTop.' . $user->login;
                    $params = [];

                    $params['ajax'] = md5($_POST['Projects']['secret_key']);
                    $params['nickname'] = $nickname;

                    $result = HUtils::sendAjaxGetRequest($_POST['Projects']['script_url'], $params);

                    if (!$result)
                        echo json_encode(array('result' => 'type', 'message' => 'Site or script is not available'));
                    else {
                        $check = json_decode($result);

                        if (!is_null($check))
                            echo $result;
                        else
                            echo json_encode(array('result' => 'type', 'message' => 'Site or script is not available'));
                    }

                } else
                    return HUtils::json_encode_cyr(array('result' => 'error', 'message' => Yii::t('translations', 'Ошибка')));
            }

            // Завершаем приложение
            Yii::app()->end();
        }
    }
}