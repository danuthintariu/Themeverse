<?php

//Only admin will see this link
if($app_user['group_id']==0)
{
  $app_plugin_menu['account_menu'][] = array('title'=>TEXT_PLUGIN_TITLE,'url'=>url_for('themeverse/page/index'),'class'=>'fa-code-fork');
}
