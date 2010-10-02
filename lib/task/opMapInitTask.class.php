<?php

class opInitMapTask extends sfDoctrineBaseTask
{
  protected function configure()
  {
    $this->namespace = "opInit";
    $this->name = "map";
    $this->briefDescription = 'find & save geocodes in diaries already registed.';
    $this->detailedDescription = <<<EOF
Call it with:

 [./symfony opInit:map]
EOF;
  }
  
  protected function execute($arguments = array(), $options=array())
  {
    $configuration = $this->createConfiguration('pc_frontend', 'cli');
    new sfDatabaseManager($this->configuration);
    
    $diaryList = Doctrine::getTable('Diary')->createQuery()->where('body LIKE ?', '%googlemaps%')->execute();
    foreach($diaryList as $diary)
    {
      opRegisterMap::saveGeocode($diary->getBody(), 'Diary', $diary->getId(), $diary->getMemberId());
      
      $diary->free(true);
      unset($diary);
    }
  }
}