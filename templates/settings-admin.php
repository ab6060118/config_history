<?php
    script('ownnotes', 'settings');
?>
<div class="section" id="admin_activity_section">
    <h2><?php p($l->t('Admin Activities'))?></h2>
    <table id="admin_activitiy" class="grid">
        <tbody id="activity_list" ></tbody>
    </table>
    <input id="moreadminacvitity" type="button" value="<?php p($l->t('More'));?>">
    <input id="lessadminacvitity" type="button" value="<?php p($l->t('Less'));?>">
</div>
