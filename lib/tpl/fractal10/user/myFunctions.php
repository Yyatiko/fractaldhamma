<?php

function getPathLinksById($idpage){
  $name = './data/pages/'.$idpage.'.txt';
  $contents = file_get_contents($name);
  $regex = '/\[\[https?:\/\/(*SKIP)(*FAIL)|\[\[\K[^][|]+/';
   // https://stackoverflow.com/a/66790744/15473629

  preg_match_all($regex, $contents, $matches, PREG_SET_ORDER); //links in page

  foreach ($matches as &$match)
  {
    $match[0] = preg_replace('/\s+/', '_', $match[0]);
    $match[0] = strtolower($match[0]);
    $match[0] = './data/pages/'.$match[0].'.txt';
  }
  unset($match);
  return $matches;
}

function getIdLinksById($idpage){
  $name = './data/pages/'.$idpage.'.txt';
  $contents = file_get_contents($name);
  $regex = '/\[\[https?:\/\/(*SKIP)(*FAIL)|\[\[\K[^][|]+/';

  preg_match_all($regex, $contents, $matches, PREG_SET_ORDER); //links in page

  foreach ($matches as &$match)
  {
    $match[0] = preg_replace('/\s+/', '_', $match[0]);
    $match[0] = strtolower($match[0]);
  }
  unset($match);
  return $matches;
}

function getPageTitleById($idpage){
  $name = './data/pages/'.$idpage.'.txt';
  if (file_exists($name)){
    $contents = file_get_contents($name);
    $regex = "/(?<=(====== ))(.*?)(?=( ======))/";  // $page title
    preg_match_all($regex, $contents, $matches, PREG_SET_ORDER); // title of page
    $title = $matches[0][0];
    return $title;
  }
}

function getPageTitleByPath($pagePath){
  $contents = file_get_contents($pagePath);
  $regex = "/(?<=(====== ))(.*?)(?=( ======))/";  // $page title
  preg_match_all($regex, $contents, $matches, PREG_SET_ORDER); // title of page
  $title = $matches[0][0];
  return $title;
}

function getPageIdByPath($pagePath){
  $pageId = str_replace('./data/pages/','',$pagePath);
  $pageId = str_replace('.txt','',$pageId);
  return $pageId;
}

function in_array_r($needle, $haystack, $strict = false) { //https://stackoverflow.com/a/4128377/15473629
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

//function that create navChildren.php navParent.php nodes.csv links.csv network.html
function matrixer(){
  $exculdePath = './data/pages/exculde.txt';

  if (file_exists($exculdePath)){
    $excludePaths = getPathLinksById("exclude");
  }

  $myChildren  = fopen(DOKU_TPLINC."user/navChildren.php", "w") or die("Unable to open file!");
  $myParent    = fopen(DOKU_TPLINC."user/navParent.php", "w") or die("Unable to open file!");
  $mylinks     = fopen(DOKU_TPLINC."user/links.csv", "w") or die("Unable to open file!");
  $mynodes     = fopen(DOKU_TPLINC."user/nodes.csv", "w") or die("Unable to open file!");

  $pagesPath = glob("./data/pages/*.txt");
  natsort($pagesPath);

  // Children loop

  fwrite($myChildren,  '<?php $navChildren=array(' ) ;
  fwrite($myChildren,  "\n" ) ;
  fwrite($mynodes,     'id,label,pageId' ) ;
  fwrite($mynodes,     "\n" ) ;
  fwrite($mylinks,     'from,to' ) ;
  fwrite($mylinks,     "\n" ) ;

  foreach ($pagesPath as $pagePath)
  {

    if (in_array_r($pagePath, $excludePaths))
    {
          continue;
    }

    $pageTitle  = getPageTitleByPath($pagePath);
    $pageId     = getPageIdByPath($pagePath);
    $subPagesId = getIdLinksById($pageId);

    fwrite($myChildren,  "'".$pagePath."'=>'\n" ) ;
    fwrite($mynodes,  $pageTitle.','.$pageTitle.','.$pageId) ;
    fwrite($mynodes,  "\n" ) ;

    if(count($subPagesId)==0) fwrite($myChildren,  "'");
    foreach ($subPagesId as $subPageId)
    {
      $subPageTitle = getPageTitleById($subPageId[0]);

      fwrite($myChildren, '<a href="doku.php?id='.$subPageId[0].'">'.$subPageTitle.'</a>');// with no nice URLs
      //fwrite($myChildren, '<a href="'.$subPageId.'">'.$titleSubPageId.'</a>'); // with nice URLs
      fwrite($myChildren, "\n");
      fwrite($mylinks,    $pageTitle.','.$subPageTitle) ;
      fwrite($mylinks,    "\n" ) ;

      if( !next( $subPagesId ) ) {
          fwrite($myChildren,  "'" );
      }
      else fwrite($myChildren,  '<br/><br/>' ) ;
    }

    fwrite($myChildren, ',' ) ;
    fwrite($myChildren, "\n");
    fwrite($myChildren, "\n");

  }

  fwrite($myChildren,  ') ?>' ) ;
  fclose($mylinks);
  fclose($mynodes);
  fclose($myChildren);

  // Parent loop

  fwrite($myParent,  '<?php $navParent=array(' ) ;
  fwrite($myParent,  "\n" ) ;

  foreach ($pagesPath as $pagePath)
  {
    if (in_array_r($pagePath, $excludePaths))
    {
          continue;
    }

    $pageTitle  = getPageTitleByPath($pagePath);
    $pageId     = getPageIdByPath($pagePath);

    fwrite($myParent,  "'".$pagePath."'=>'\n" ) ;

    foreach ($pagesPath as $subPagePath)
    {
      if (in_array_r($pagePath, $excludePaths))
      {
            continue;
      }

      $subPageId     = getPageIdByPath($subPagePath);
      $subPageTitle  = getPageTitleById($subPageId);
      $subSubPagesId = getIdLinksById($subPageId);

      foreach ($subSubPagesId as $subSubPageId)
      {
        if($subSubPageId[0] == $pageId) // if subPage source Page
        {
            fwrite($myParent, '<a href="doku.php?id='.$subPageId.'">'.$subPageTitle.'</a>'); // With nice URLs
            //fwrite($myfile2, '<a href="'.$subPageId.'">'.$subPageTitle.'</a>'); // With no nice URLs
            fwrite($myParent, "\n");
            fwrite($myParent,  '<br/><br/>' ) ;
        }
      }
    }
    fwrite($myParent,  "'," ) ;
    fwrite($myParent, "\n");
    fwrite($myParent, "\n");
  }
  fwrite($myParent,  ') ?>' ) ;
  fclose($myParent);

  exec("/usr/local/bin/Rscript /Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/script.R", $output, $retval);

}

 ?>
