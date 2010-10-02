<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * map actions.
 *
 * @package    OpenPNE
 * @subpackage map
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class mapActions extends sfActions
{
  public function executeMember(sfWebRequest $request)
  {
    $this->size = 100;
    $this->page = $request->getParameter("page");
    $this->member = Doctrine::getTable("Member")->find($request->getParameter("id", $this->getUser()->getMemberId()));
    if(!$this->member || $this->member->getIsActive())
    {
      $this->member = $this->getUser()->getMember();
    }
    $pager = Doctrine::getTable("Geocode")->getMemberPager($this->member->getId(), $this->getUser()->getMemberId(), $this->size, $this->page);
    $glist = array();
    $clist = array();
    $ulist = array();
    $this->getContext()->getConfiguration()->loadHelpers('Url');

    foreach($pager->getResults() as $geocode)
    {
      $glist[] = $geocode->getGeocode();
      $clist[] = $geocode->getForeignTitle();
      $ulist[] = url_for($geocode->getForeignUrl());
    }
    $this->geocodings = $glist;
    $this->captions = $clist;
    $this->urls = $ulist;

  }
  
  public function executeCommunity(sfWebRequest $request)
  {
    $this->size = 100;
    $this->page = $request->getParameter("page");
    $this->community = Doctrine::getTable("Community")->find($request->getParameter("id"));
    $this->forward404Unless($this->community);
    
    $pager = Doctrine::getTable("Geocode")->getCommunityPager($this->community->getid(), $this->getUser()->getMemberId(), $this->size, $this->page);
    $glist = array();
    $clist = array();
    $ulist = array();
    $this->getContext()->getConfiguration()->loadHelpers('Url');

    foreach($pager->getResults() as $geocode)
    {
      $glist[] = $geocode->getGeocode();
      $clist[] = $geocode->getForeignTitle();
      $ulist[] = url_for($geocode->getForeignUrl());
    }
    $this->geocodings = $glist;
    $this->captions = $clist;
    $this->urls = $ulist;
  }
  
  
}
