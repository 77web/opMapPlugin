<?php

class opDeleteMap
{
  public static function listenToDiaryPostDelete($args)
  {
    $obj = $args['actionInstance']->getVar("diary");
    if($obj)
    {
      self::deleteRelatedGeocode($obj);
    }
  }
  
  protected static function deleteRelatedGeocode($obj)
  {
    $foreignTable = get_class($obj);
    $foreignId = $obj->getId();
    
    Doctrine::getTable("Geocode")->deleteRelatedGeocodes($foreignTable, $foreignId);
  }
}