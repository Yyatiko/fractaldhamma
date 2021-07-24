<?php

function getPathLinksById($idpage){
  $name = './data/pages/'.$idpage.'.txt';
  $name = str_replace(':', '/', $name); // if contains namespaces
  $contents = file_get_contents($name);
  $regex = '/\[\[https?:\/\/(*SKIP)(*FAIL)|\[\[\K[^][|]+/';
   // https://stackoverflow.com/a/66790744/15473629

  preg_match_all($regex, $contents, $matches, PREG_SET_ORDER); //links in page

  foreach ($matches as &$match)
  {
    $match[0] = preg_replace('/\s+/', '_', $match[0]);
    $match[0] = strtolower($match[0]);
    $match[0] = str_replace(':','/',$match[0]);
    $match[0] = './data/pages/'.$match[0].'.txt';
  }
  unset($match);
  return $matches;
}

function getIdLinksById($idpage){
  $name = './data/pages/'.$idpage.'.txt';
  $name = str_replace(':', '/', $name); // if contains namespaces
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
  $name = str_replace(':', '/', $name); // if contains namespaces
  if (file_exists($name)){
    $contents = file_get_contents($name);
    $regex = "/(?<=(====== ))(.*?)(?=( ======))/";  // $page title
    preg_match_all($regex, $contents, $matches, PREG_SET_ORDER); // title of page
    $title = $matches[0][0];
    return $title;
  }
}

function getFirstNameSpaceById($idpage){
    $regex = "/^(.*?)(?=(:))/";  // $first name space
    preg_match_all($regex, $idpage, $matches, PREG_SET_ORDER); // title of page
    $namespace = $matches[0][0];
    return $namespace;
}

function getPageTitleByPath($pagePath){
  $contents = file_get_contents($pagePath);
  $regex = "/(?<=(====== ))(.*?)(?=( ======))/";  // $page title
  preg_match_all($regex, $contents, $matches, PREG_SET_ORDER); // title of page
  $title = $matches[0][0];
  return $title;
}

function getIdFromFullPath($pagePath){
  $regex = "/[^\/]+(?=.txt)/";  // $page title
  preg_match_all($regex, $pagePath, $matches, PREG_SET_ORDER); // title of page
  $title = $matches[0][0];
  return $title;
}

function getPageIdByPath($pagePath){
  $pageId = str_replace('./data/pages/','',$pagePath);
  $pageId = str_replace('/',':',$pageId);
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

function utf8hex ($string) {
  $string = str_replace('<c4><81>','ā',$string);    //Ą<e1><b9><ad>
  $string = str_replace('<e1><b9><ad>','ṭ',$string);    //Ą<e1><b9><ad>
  $string = str_replace('<e1><b9><85>','ṅ',$string);    //Ą<e1><b9><ad>
  //$string = str_replace('"',"'",$string);    //Ą<e1><b9><ad>
  //$string = str_replace('@','"',$string);    //Ą<e1><b9><ad>
   return ($string);
   }

//function that create navChildren.php navParent.php nodes.csv links.csv network.html in the root directory only (not up to date)
function matrixer(){

  $excludePaths = getPathLinksById("exclude"); // need to fix error when no such file exsite.
  $excludeIds   = getIdLinksById("exclude"); // need to fix error when no such file exsite.

  $myChildren  = fopen(DOKU_TPLINC."user/navChildren.php", "w") or die("Unable to open file!");
  $myParent    = fopen(DOKU_TPLINC."user/navParent.php", "w")   or die("Unable to open file!");
  $mylinks     = fopen(DOKU_TPLINC."user/links.csv", "w")       or die("Unable to open file!");
  $mynodes     = fopen(DOKU_TPLINC."user/nodes.csv", "w")       or die("Unable to open file!");

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
    // faulty fwrite($mynodes,  $pageTitle.',<a href="doku.php?id='.$pageId.'">'.$pageTitle.'</a>,'.$pageId) ;
    fwrite($mynodes,  $pageTitle.','.$pageTitle.','.$pageId) ;
    fwrite($mynodes,  "\n" ) ;

    if(count($subPagesId)==0) fwrite($myChildren,  "'");
    foreach ($subPagesId as $subPageId)
    {
      if (in_array_r($subpageId[0], $excludeIds))
      {
            continue;
      }

      $subPageTitle = getPageTitleById($subPageId[0]);

      fwrite($myChildren, '<a href="doku.php?id='.$subPageId[0].'">'.$subPageTitle.'</a>');
      // with no nice URLs
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
      if (in_array_r($subPagePath, $excludePaths))
      {
            continue;
      }

      $subPageId     = getPageIdByPath($subPagePath);
      $subPageTitle  = getPageTitleById($subPageId);
      $subSubPagesId = getIdLinksById($subPageId);

      foreach ($subSubPagesId as $subSubPageId)
      {
        if (in_array_r($subSubPageId[0], $excludeIds))
        {
              continue;
        }
        if($subSubPageId[0] == $pageId) // if subPage source Page
        {
            fwrite($myParent, '<a href="doku.php?id='.$subPageId.'">'.$subPageTitle.'</a>');
            // With nice URLs
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
  //echo $retval;
  //echo "<pre>"; print_r($output); echo "</pre>";
}

//personalised function that create navChildren.php navParent.php nodes.csv links.csv network.html in every subspace
function matrixerByNameSpace($nameSpace){

  if (strlen($nameSpace)>0) $nameSpaceSlash = $nameSpace."/";

  if (!is_dir(DOKU_TPLINC."user/".$nameSpace)){
    mkdir(DOKU_TPLINC."user/".$nameSpace, 777, true);// this doesnt work... need to give permission manualy every time
  }

  if (is_file("./data/pages/".$nameSpaceSlash."exclude.txt")){
    $excludePaths = getPathLinksById($nameSpace.":exclude");
    $excludeIds   = getIdLinksById($nameSpace.":exclude");
  }
  else {
    $excludePaths = array();
    $excludeIds   = array();
  }

  $myChildren  = fopen(DOKU_TPLINC."user/".$nameSpace."/navChildren.php", "w") or die("Unable to open file!");
  $myParent    = fopen(DOKU_TPLINC."user/".$nameSpace."/navParent.php", "w")   or die("Unable to open file!");
  $mylinks     = fopen(DOKU_TPLINC."user/".$nameSpace."/links.csv", "w")       or die("Unable to open file!");
  $mynodes     = fopen(DOKU_TPLINC."user/".$nameSpace."/nodes.csv", "w")       or die("Unable to open file!");
  $myRScript   = fopen(DOKU_TPLINC."user/".$nameSpace."/script.R", "w")        or die("Unable to open file!");

  $ChildCheck = array(); // to check for doublon on remove them
  $ParentCheck = array();

  $pagesPath = glob("./data/pages/".$nameSpace."/*.txt");
  natsort($pagesPath);

  // Children loop

  fwrite($myChildren,  '<?php $navChildren=array(' ) ;
  fwrite($myChildren,  "\n" ) ;
  fwrite($mynodes,     'id,title,pageId' ) ; //title replaces label (label is used in older script)
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

    $ChildrenCheck = array() ; // reinitiallize the array


    fwrite($myChildren,  "'".$pagePath."'=>'\n" ) ;
    //fwrite($mynodes,  $pageTitle.','.$pageTitle.','.$pageId) ;
    fwrite($mynodes,  $pageTitle.','.$pageTitle.',doku.php?id='.$pageId) ;
    //fwrite($mynodes,  $pageTitle.','.$pageTitle.',<a href="doku.php?id="'.$pageId.'"') ;
    //fwrite($mynodes, $pageTitle.',<a href="doku.php?id='.$pageId.'">'.$pageTitle.'</a>,'.$pageId) ;
    fwrite($mynodes,  "\n" ) ;

    if(count($subPagesId)==0) fwrite($myChildren,  "'");
    foreach ($subPagesId as $subPageId)
    {
      if (in_array_r($subpageId[0], $excludeIds))
      {
            continue;
      }


      $subPageTitle = getPageTitleById($subPageId[0]);

      if (!in_array_r($subPageId[0], $ChildrenCheck)) // jump over if it is a doublon.
      {
        fwrite($myChildren, '<a href="doku.php?id='.$subPageId[0].'">'.$subPageTitle.'</a>');
        fwrite($myChildren, "\n");
        // with no nice URLs
        //fwrite($myChildren, '<a href="'.$subPageId.'">'.$titleSubPageId.'</a>'); // with nice URLs
      }

      array_push($ChildrenCheck, $subPageId[0]); // add $subPageId to the check

      fwrite($mylinks,    $pageTitle.','.$subPageTitle) ; // doublon in links.csv are removed with Rscript but could be added in the if above if needed
      fwrite($mylinks,    "\n" ) ;

      if( !next( $subPagesId ) ) {  // I think this could be simplify as it is done in the parent loop
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

  // Parent loop // could simply flip or tranverspose the last matrix, but...

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
    $ParentCheck = array() ; // reinitiallize the array

    fwrite($myParent,  "'".$pagePath."'=>'\n" ) ;

    foreach ($pagesPath as $subPagePath)
    {
      if (in_array_r($subPagePath, $excludePaths))
      {
            continue;
      }

      $subPageId     = getPageIdByPath($subPagePath);
      $subPageTitle  = getPageTitleById($subPageId);
      $subSubPagesId = getIdLinksById($subPageId);

      foreach ($subSubPagesId as $subSubPageId)
      {
        if (in_array_r($subSubPageId[0], $excludeIds))
        {
              continue;
        }
        if (in_array_r($subPageId, $ParentCheck)) // jump over if it is a doublon.
        {
              continue;
        }
        if($subSubPageId[0] == $pageId) // if subPage source Page
        {
            array_push($ParentCheck, $subPageId); // add $subPageId to the check
            fwrite($myParent, '<a href="doku.php?id='.$subPageId.'">'.$subPageTitle.'</a>');
            // With nice URLs
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

  include(DOKU_TPLINC."user/".$nameSpaceSlash."navChildren.php");
    // contain the children matrix. the first Id is used as the anchor.
  $keys=array_Keys($navChildren);
  $firstPath=$keys[0];
  $firstTitle=getPageTitleByPath($firstPath);

  $rScript = file_get_contents(DOKU_TPLINC."user/script.R");
  //echo "<pre>" . $rScript . "</pre>";
  $rScript = str_replace("user", "user/".$nameSpace, $rScript);
  $rScript = str_replace("anchorNode", $firstTitle, $rScript);
  fwrite($myRScript, $rScript) ;
  fclose($myRScript) ;

  //echo "/usr/local/bin/Rscript /Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/".$nameSpaceSlash."script.R";
  exec("/usr/local/bin/Rscript /Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/".$nameSpaceSlash."script.R", $output, $retval);
  //echo '</br>return value : '.$retval; // for debugging
  //echo "<pre>"; print_r($output); echo "</pre>"; // for debugging

}




 ?>
