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

  public static function listenToDiaryCommentPostDelete($args)
  {
    $obj = $args['actionInstance']->getVar("diaryComment");
    if($obj)
    {
      self::deleteRelatedGeocode($obj);
    }
  }
  
  public static function listenToCommunityTopicCommentPostDelete($args)
  {
    $obj = $args['actionInstance']->getVar("communityTopicComment");
    if($obj)
    {
      self::deleteRelatedGeocode($obj);
    }
  }

  public static function listenToCommunityEventCommentPostDelete($args)
  {
    $obj = $args['actionInstance']->getVar("communityEventComment");
    
    if($obj)
    {
      self::deleteRelatedGeocode($obj);
    }
  }

  public static function listenToCommunityTopicPostDelete($args)
  {
    $obj = $args['actionInstance']->getVar("communityTopic");
    if($obj)
    {
      self::deleteRelatedGeocode($obj);
    }
  }

  public static function listenToCommunityEventPostDelete($args)
  {
    $obj = $args['actionInstance']->getVar("communityEvent");
    
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