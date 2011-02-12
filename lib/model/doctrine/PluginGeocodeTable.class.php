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
    if($accessMemberId!=$memberId)
    {
      //consider public flag
      $q->select('g.*')->addFrom('Diary d')->addWhere('d.id = g.foreign_id');
      if($accessMemberId>0)
      {
        //sns member
        $flags = array(DiaryTable::PUBLIC_FLAG_OPEN, DiaryTable::PUBLIC_FLAG_SNS);
        //friend or not
        if(Doctrine::getTable('MemberRelationship')->createQuery()->where('member_id_from = ? AND member_id_to = ? AND is_friend = 1', array($accessMemberId, $memberId))->count()>0)
        {
          $flags[] = DiaryTable::PUBLIC_FLAG_FRIEND;
        }
        
        $q->andWhereIn('d.public_flag', $flags);
      }
      else
      {
        //not a sns member
        $q->addWhere('d.is_open = 1');
      }
    }
    
    return $q->limit($size)->execute();
  }

}