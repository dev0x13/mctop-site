<a href="/users/profile/<?php echo $member->uid; ?>">
    <div class="role">
        <?php echo $member->u->name . ' ' . $member->u->surname; ?>
        <div class="role_title">
            <?php echo GuildsRoles::getRolesInString($member->roles_weight); ?>
        </div>
        <div class="buttons">
            <?php if (GuildsMembers::getGeneralRole($member->roles_weight)->weight != 2): ?>
                <?php
                if (GuildsMembers::getGeneralRole(GuildsMembers::model()->find('uid=:user', array(
                        ':user' => Yii::app()->user->id))->roles_weight)->weight == 2
                ):
                    ?>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'events-form',
                    )); ?>
                    <input type="hidden" name="method" value="delete"/>
                    <input type="hidden" name="user" value="<?php echo $member->uid; ?>"/>
                    <input type="submit" class="btn btn-danger mctbtn_normal"
                           value="<?php echo Yii::t('translations', 'Удалить пользователя'); ?>"/>
                    <?php $this->endWidget(); ?>
                <? endif; ?>
            <?php endif; ?>
        </div>
    </div>
</a>