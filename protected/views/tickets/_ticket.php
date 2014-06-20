<div class="<?php echo ($ticket->status == TicketsTopics::STATUS_AGENT_ANSWERED) ? 'ticket_answered' : 'ticket'; ?>">
    <?php echo ($ticket->status == TicketsTopics::STATUS_AGENT_ANSWERED) ? '<span class="label label-primary">' . Yii::t('translations', 'Получен ответ') . '</span>' : 'ticket'; ?>
    <a href="/tickets/show/<?php echo $ticket->id; ?>"><?php echo $ticket->name; ?></a>
</div>