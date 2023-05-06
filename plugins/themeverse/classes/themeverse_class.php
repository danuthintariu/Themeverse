<?php

class user_class
{
  static function get_user_info()
  {
    global $app_user;
    
    $html = '';
    $html .=  '<div>'.TEXT_USER_ID.': <b>' . $app_user['id'] . '</b></div>';
    $html .= '<div>'.TEXT_USER_ACCG_ID.': <b>' . $app_user['group_id'] . '</b></div>';
    
    $user_info_query = db_query("select * from app_entity_1 where id='" . $app_user['id'] . "'");
    if($user_info = db_fetch_array($user_info_query))
    {
      $html .= '<div>'.TEXT_USER_NAME.': <b>' . $user_info['field_12'] . '</b></div>'; 
    }
    
    return $html;
  }
}
