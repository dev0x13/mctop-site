<a href="/users/profile/<?php echo $member->id; ?>">
    <div class="role">
        <?php echo $member->name . ' ' . $member->surname;; ?>
        <div class="role_title">
            <?php echo Roles::getRolesInString($member->user_role); ?>
        </div>
        <div class="buttons">
            <?php if (Roles::getGeneralRole($member->user_role)->weight != 2): ?>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'events-form',
                )); ?>
                <input type="hidden" name="method" value="delete"/>
                <input type="hidden" name="user" value="<?php echo $member->id; ?>"/>
                <input type="submit" class="btn btn-danger"
                       value="<?php echo Yii::t('translations', 'Удалить пользователя'); ?>"/>
                <?php $this->endWidget(); ?>
            <?php endif; ?>
        </div>
    </div>
</a>