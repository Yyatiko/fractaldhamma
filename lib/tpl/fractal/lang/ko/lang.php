<?php

/**
 * Korean language for the "fractal" DokuWiki template
 *
 * If your language is not/only partially translated or you found an error/typo,
 * have a look at the following files:
 * - /lib/tpl/fractal/lang/<your lang>/lang.php
 * - /lib/tpl/fractal/lang/<your lang>/settings.php
 * If they are not existing, copy and translate the English ones.
 *
 * Don't forget to mail your translation to ARSAVA <dokuwiki@dev.arsava.com>.
 * Thanks! :-D
 *
 *
 * LICENSE: This file is open source software (OSS) and may be copied under
 *          certain conditions. See COPYING file for details or try to contact
 *          the author(s) of this file in doubt.
 *
 * @license GPLv2 (http://www.gnu.org/licenses/gpl2.html)
 * @author Myeongjin <aranet100@gmail.com>
 * @link https://www.dokuwiki.org/template:fractal
 * @link https://www.dokuwiki.org/config:lang
 * @link https://www.dokuwiki.org/devel:configuration
 */


//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}

//links
$lang["fractal_lnk_print"] = "인쇄용 문서";
$lang["fractal_lnk_permrev"] = "고유 링크";
$lang["fractal_lnk_whatlinkshere"] = "여기를 가리키는 문서";
$lang["fractal_lnk_siteindex"] = "사이트맵";

//other
$lang["fractal_search"] = "찾기";
$lang["fractal_accessdenied"] = "접근 거부됨";
$lang["fractal_fillplaceholder"] = "이 자리를 채우거나 비활성화하세요";
$lang["fractal_donate"] = "기부";
$lang["fractal_templatefordw"] = "도쿠위키를 위한 fractal 템플릿";
$lang["fractal_recentchanges"] = "최근 바뀜";
