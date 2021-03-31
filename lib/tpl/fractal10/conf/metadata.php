<?php

/**
 * Types of the different option values for the "fractal10" DokuWiki template
 *
 * Notes:
 * - In general, use the admin webinterface of DokuWiki to change the config.
 * - To change/add configuration values to store, have a look at this file
 *   and the "default.php" in the same directory as this file.
 * - To change/translate the descriptions showed in the admin/configuration
 *   menu of DokuWiki, have a look at the file
 *   /lib/tpl/fractal10/lang/<your lang>/settings.php. If it does not exists,
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
 * @link https://www.dokuwiki.org/template:fractal10
 * @link https://www.dokuwiki.org/devel:configuration
 */


//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}

//header navigation
$meta["fractal10_headernav"]          = array("onoff");
$meta["fractal10_headernav_location"] = array("string");

//custom copyright notice
$meta["fractal10_copyright"]          = array("onoff");
$meta["fractal10_copyright_default"]  = array("onoff");
$meta["fractal10_copyright_location"] = array("string");

//custom footer content
$meta["fractal10_footer"]          = array("onoff");
$meta["fractal10_footer_location"] = array("string");

//other stuff
$meta["fractal10_showpageinfo"]           = array("onoff");
$meta["fractal10_hideadminlinksfromanon"] = array("onoff");
$meta["fractal10_loaduserjs"]             = array("onoff");

