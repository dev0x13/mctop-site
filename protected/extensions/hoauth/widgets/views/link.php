<?php
/**
 * @var HOAuthWidget $this
 * @var string $provider name of provider
 */

$invitation = Yii::app()->user->isGuest ? HOAuthAction::t('Sign in with') : HOAuthAction::t('Connect with');
$provider_short = ($provider == 'Vkontakte') ? 'VK' : 'Facebook';
?>
<a href="<?php echo Yii::app()->createUrl('/s/oauth', array('provider' => $provider)); ?>"
   class="zocial <?php echo strtolower($provider_short) ?>"><?php echo "$invitation $provider_short"; ?></a>
