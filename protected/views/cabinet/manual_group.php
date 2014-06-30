<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'MCTop.Manual') => array('/cabinet/manual'),
    Yii::t('translations', $category->title)
);
?>

<h1><?php echo Yii::t('translations', $category->title)?></h1>

<?php if(isset($articles)):?>
<div class="faq">
	<?php 
		foreach($articles as $key => $article)
		{
			echo '<a href="/cabinet/manual_page/'.$article->id.'">'.Yii::t('translations',$article->title).'</a>';
		}
	?>
</div>
<?php endif?>