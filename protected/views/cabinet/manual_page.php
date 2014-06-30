<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'MCTop.Manual') => array('/cabinet/manual'),
    Yii::t('translations', $category->title) => array('/cabinet/manual/group/'.$category->id),
    Yii::t('translations', $article->title)
);
?>

<h1><?php echo $article->title;?></h1>

<?php echo $article->content;?>