<?php
/**
 */
class PluginGeocodeTable extends Doctrine_Table
{
  public function setGeocode($code_list, $foreignTable, $foreignId, $memberId)
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
      $code = explode(',', $code);
      if(count($code)==2)
      {
        $obj = new Geocode();
        $obj->setForeignId($foreignId);
        $obj->setForeignTable($foreignTable);
        $obj->setLat($code[0]);
        $obj->setLng($code[1]);
        $obj->setMemberId($memberId);
        $obj->save();
        $obj->free(true);
        unset($obj);
      }
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
    $q = $this->createQuery("g")->where("g.member_id = ?", $memberId)->orderBy("id DESC");
    
    $pager = new sfDoctrinePager("Geocode", $size);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->init();
    
    return $pager;
  }
  
  public function getMemberList($memberId, $accessMemberId, $size)
  {
    $q = $this->createQuery("g")->where("g.member_id = ?", $memberId)->orderBy("id DESC");
    
    return $q->limit($size)->execute();
  }

}