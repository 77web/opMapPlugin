<?php

class mapWinAction extends sfAction
{
  public function execute($request)
  {
    $apikey = Doctrine::getTable('SnsConfig')->get('google_maps_api_key');
    $this->getResponse()->addJavascript("http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=".$apikey);
    
    $this->getResponse()->addJavascript("/opMapPlugin/js/googlemap_edit");
    $this->getResponse()->addStylesheet("/opMapPlugin/css/map");
    $this->default_center_x = sfConfig::get("app_default_map_x");
    $this->default_center_y = sfConfig::get("app_default_map_y");
  }
}