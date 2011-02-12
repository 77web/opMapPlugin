<?php

class opMapPluginMapActions extends sfActions
{
  public function executeMember(sfWebRequest $request)
  {
    $this->member = Doctrine::getTable("Member")->find($request->getParameter("id", $this->getUser()->getMemberId()));
    if(!$this->member || !$this->member->getIsActive())
    {
      $this->member = $this->getUser()->getMember();
    }
    $this->list = Doctrine::getTable("Geocode")->getMemberList($this->member->getId(), $this->getUser()->getMemberId(), 100);
    
    if(count($this->list)==0)
    {
      return sfView::ERROR;
    }

  }
}