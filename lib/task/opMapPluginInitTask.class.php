<?php

class opMapPluginInitTask extends sfDoctrineBaseTask
{
  protected function configure()
  {
    $this->namespace = "opMapPlugin";
    $this->name = "init";
    $this->briefDescription = 'find & save geocodes in diaries already registed.';
    $this->detailedDescription = <<<EOF
Call it with:

 [./symfony opMapPlugin:init]
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