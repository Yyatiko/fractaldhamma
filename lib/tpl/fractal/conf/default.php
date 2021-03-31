<?php

/**
 * Default options for the "fractal" DokuWiki template
 *
 * Notes:
 * - In general, use the admin webinterface of DokuWiki to change the config.
 * - To change the type of a config value, have a look at "metadata.php" in
 *   the same directory as this file.
 * - To change/translate the descriptions showed in the admin/configuration
 *   menu of DokuWiki, have a look at the file
 *   /lib/tpl/fractal/lang/<your lang>/settings.php. If it does not exists,
 *   copy and translate the English one. Don't forget to mail your translation
 *   to
 *     ARSAVA <dokuwiki@dev.arsava.com>
 *   Thanks :-D.
 *
 *
 * LICENSE: This file is open source software (OSS) and may be copied under
 *          certain conditions. See COPYING file for details or try to contact
 *          the author(s) of this file in doubt.
 *
 * @license GPLv2 (http://www.gnu.org/licenses/gpl2.html)
 * @author ARSAVA <dokuwiki@dev.arsava.com>
 * @link https://www.dokuwiki.org/template:fractal
 * @link https://www.dokuwiki.org/devel:configuration
 */


//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}

//header navigation
$conf["fractal_headernav"]          = 1; //1: use/show header navigation
$conf["fractal_headernav_location"] = ":wiki:navigation_header"; //page/article used to store the header navigation

//custom copyright notice
$conf["fractal_copyright"]          = 1; //1: use/show copyright notice
$conf["fractal_copyright_default"]  = 1; //1: use default copyright notice (if copyright notice is enabled at all)
$conf["fractal_copyright_location"] = ":wiki:copyright"; //page/article used to store a custom copyright notice

//custom footer content
$conf["fractal_footer"]          = 0; //1: use/show custom footer content
$conf["fractal_footer_location"] = ":wiki:footer"; //page/article used to store a custom footer content

//other stuff
$conf["fractal_showpageinfo"]           = 0; //1: show meta information about the current page (footer->tpl_pageinfo())
$conf["fractal_hideadminlinksfromanon"] = 0; //1: hide admin links if client is not an authenticated user (including login link -> you have to call "example.com?do=login" manually)
$conf["fractal_loaduserjs"]             = 0; //1: fractal/user/user.js will be loaded

