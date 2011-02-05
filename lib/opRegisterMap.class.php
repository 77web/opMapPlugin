<?php

class opRegisterMap
{
  static public function listenToDiaryPostCreate($args)
  {
    $form = $args['actionInstance']->getVar("form");
    
    if($form && $form->getObject()->getId())
    {
      $diary = $form->getObject();
      self::saveGeocode($diary->getBody(), get_class($diary), $diary->getId(), $diary->getMemberId());
    }
  }
  
  static public function listenToDiaryPostUpdate($args)
  {
    $form = $args['actionInstance']->getVar("form");

    if($form && $form->isValid())
    {
      $diary = $form->getObject();
      self::saveGeocode($diary->getBody(), get_class($diary), $diary->getId(), $diary->getMemberId());
    }
  }
  
  static public function saveGeocode($txt, $foreignTable, $foreignId, $memberId, $communityId=null)
  {
    $code_list = array();
    if(preg_match_all(SF_AUTO_LINK_RE, $txt, $matches, PREG_SET_ORDER)>0)
    {
      foreach($matches as $match)
      {
        $url = trim($match[0]);
        $code = null;
        if(strpos($url, "http://maps.google.co.jp")===0 || strpos($url, "http://maps.google.com")===0)
        {
          $qstr = parse_url($url, PHP_URL_QUERY);
          if($qstr)
          {
            foreach(explode("&", $qstr) as $hash)
            {
              if(strpos($hash, "=")!==FALSE)
              {
                list($key, $value) = explode("=", $hash);
                if($key=="ll")
                {
                  $code = $value;
                  break;
                }
              }
            }
          }
        }
        if($code!="")  $code_list[] = $code;
      }
    }
    Doctrine::getTable("Geocode")->setGeocode($code_list, $foreignTable, $foreignId, $memberId, $communityId);
  }
}

if (!defined('SF_AUTO_LINK_RE'))
{
  define('SF_AUTO_LINK_RE', '~
    (                       # leading text
      <\w+.*?>|             #   leading HTML tag, or
      [^=!:\'"/]|           #   leading punctuation, or
      ^                     #   beginning of line
    )
    (
      (?:https?://)|        # protocol spec, or
      (?:www\.)             # www.*
    )
    (
      [-\w]+                   # subdomain or domain
      (?:\.[-\w]+)*            # remaining subdomains or domain
      (?::\d+)?                # port
      \/?
      [a-zA-Z0-9_\-\/.,:;\~\?@&=+$%#!()]*
    )
    ([[:punct:]]|\s|<|$)    # trailing text
   ~x');
}
