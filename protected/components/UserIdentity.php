<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    const ERROR_USER_EMAIL_NOT_APPROVED = 3;

    public function authenticate()
    {
        $user = Users::model()->find('login=:login', array(':login' => $this->username));
        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        elseif (!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->errorCode = self::ERROR_NONE;
            $this->setState('id', $user->id);
            $this->setState('language', $user->language);
            //$redis = Yii::app()->social_network->getClient();
            //$redis->set('social_network:user:'.$user->id.':ip');
            //todo fix
        }

        return $this->errorCode;
    }

}
