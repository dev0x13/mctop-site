<h1><?php echo Yii::t('translations','Пользователи Online')?></h1>

<h4>
<?php 
	foreach($users as $key => $user)
	{
		echo '<a href="/u'.$user->id.'">'.$user->name. ' '.$user->surname.'</a><br><br>';
	}
?>
</h4>