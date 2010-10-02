<?php

class mapComponents extends sfComponents
{

  /* GoogleMap　単独マップに単独マーカー用
   * partialとして渡されるパラメータ：$geocoding, $caption, $url 
   */
  public function executeGoogleMap()
  {
    $apikey = Doctrine::getTable('SnsConfig')->get('google_maps_api_key');
    $this->getResponse()->addJavascript("http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=".$apikey);

    $this->getResponse()->addJavascript("/opMapPlugin/js/googlemap");
    $this->getResponse()->addStylesheet("/opMapPlugin/css/map");
  }
  
  /* GoogleMap　単独マップに複数マーカー用
   * partialとして渡されるパラメータ：$geocodings, $captions, $urls
   */
  public function executeGoogleMaps()
  {
    $apikey = Doctrine::getTable('SnsConfig')->get('google_maps_api_key');
    $this->getResponse()->addJavascript("http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=".$apikey);
    
    if(!is_array($this->geocodings))
    {
      $this->geocodings = $this->geocodings->getRawValue();
    }
    if(!is_array($this->captions))
    {
      $this->captions = $this->captions->getRawValue();
    }
    if(!is_array($this->urls))
    {
      $this->urls = $this->urls->getRawValue();
    }
    
    $this->geocodings = array_filter($this->geocodings);
    $this->captions = array_filter($this->captions);
    $this->urls = array_filter($this->urls);

    $this->getResponse()->addJavascript("/opMapPlugin/js/googlemap");
    $this->getResponse()->addStylesheet("/opMapPlugin/css/map");
  }
}