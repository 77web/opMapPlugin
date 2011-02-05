<?php

class opMapPluginMapActions extends sfActions
{
  public function executeMember(sfWebRequest $request)
  {
    $this->size = 100;
    $this->page = $request->getParameter("page", 1);
    $this->member = Doctrine::getTable("Member")->find($request->getParameter("id", $this->getUser()->getMemberId()));
    if(!$this->member || $this->member->getIsActive())
    {
      $this->member = $this->getUser()->getMember();
    }
    $pager = Doctrine::getTable("Geocode")->getMemberPager($this->member->getId(), $this->getUser()->getMemberId(), $this->size, $this->page);
    $codeList = array();
    $captionList = array();
    $urlList = array();
    $this->getContext()->getConfiguration()->loadHelpers('Url');

    foreach($pager->getResults() as $geocode)
    {
      $codeList[] = $geocode->getGeocode();
      $captionList[] = $geocode->getForeignTitle();
      $urlList[] = url_for($geocode->getForeignUrl());
    }
    $this->geocodings = $codeList;
    $this->captions = $captionList;
    $this->urls = $urlList;

  }
}