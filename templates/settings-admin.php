<?php
    script('ownnotes', 'settings');
?>
<div class="section" id="cofiguration_history_section">
    <h2><?php p($l->t('Configuration History'))?></h2>
    <table id="configuration_history" class="grid">
        <tbody id="history_list" ></tbody>
    </table>
    <input id="morehistory" type="button" value="<?php p($l->t('More'));?>">
    <input id="lesshistory" type="button" value="<?php p($l->t('Less'));?>">
    <font id="nomoremsg" ><?php p($l->t('No more history to show.')); ?></font>
</div>
