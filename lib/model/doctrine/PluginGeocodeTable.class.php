<?php
/**
 */
class PluginGeocodeTable extends Doctrine_Table
{
  public function setGeocode($code_list, $foreignTable, $foreignId, $memberId, $communityId)
  {
    $newcode_list = array();
    foreach($code_list as $code)
    {
      $newcode_list[$code] = $code;
    }
    foreach($this->getCodeList($foreignTable, $foreignId) as $geocode)
    {
      if(!in_array($geocode->getGeocode(), $code_list))
      {
        $geocode->delete();
      }
      else
      {
        unset($newcode_list[$geocode->getGeocode()]);
      }
    }

    foreach($newcode_list as $code)
    {
      $obj = new Geocode();
      $obj->setForeignId($foreignId);
      $obj->setForeignTable($foreignTable);
      $obj->setGeocode($code);
      $obj->setMemberId($memberId);
      $obj->setCommunityId($communityId);
      $obj->save();
      $obj->free(true);
      unset($obj);
    }
  }
  
  public function deleteRelatedGeocodes($foreignTable, $foreignId)
  {
    return $this->createQuery()->where("foreign_table=?",$foreignTable)->addWhere("foreign_id=?", $foreignId)->delete()->execute();
  }
  
  public function getCodeList($foreignTable, $foreignId)
  {
    return $this->createQuery()->where("foreign_table=?",$foreignTable)->addWhere("foreign_id=?", $foreignId)->execute();
  }
  
  public function getMemberPager($memberId, $accessMemberId, $size, $page=1)
  {
    $q = $this->createQuery("g")->where("g.member_id = ?", $memberId)->orderBy("created_at DESC");
    
    $pager = new sfDoctrinePager("Geocode", $size);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->init();
    
    return $pager;
  }
  
  public function getCommunityPager($communityId, $accessMemberId, $size, $page)
  {
    $q = $this->createQuery("g")->where("g.community_id = ?", $communityId)->orderBy("created_at DESC");
    $isMember = Doctrine::getTable('CommunityMember')->isMember($accessMemberId, $communityId);
    $tables = array("CommunityTopic", "CommunityTopicComment", "CommunityEvent", "CommunityEventComment");
    $public_flag = Doctrine::getTable("CommunityConfig")->retrieveByNameAndCommunityId("public_flag", $communityId);
    switch($public_flag)
    {
      case "private":
        if(!$isMember)
        {
          $tables = array();
        }
      case "public":
        if($accessMemberId<1)
        {
          $tables = array();
        }
      case "expublic":
      default:
    }
    if(count($tables)>0)
    {
      $q->andWhereIn("foreign_table", $tables);
    }
    else
    {
      $q->addWhere("foreign_table IS NULL");
    }
    
    $pager = new sfDoctrinePager("Geocode", $size);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->init();
    
    return $pager;
  }
}