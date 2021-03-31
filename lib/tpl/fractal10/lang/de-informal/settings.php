<?php

/**
 * German language (informal, "Du") for the Config Manager
 *
 * If your language is not/only partially translated or you found an error/typo,
 * have a look at the following files:
 * - /lib/tpl/fractal10/lang/<your lang>/lang.php
 * - /lib/tpl/fractal10/lang/<your lang>/settings.php
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
 * @author ARSAVA <dokuwiki@dev.arsava.com>
 * @link https://www.dokuwiki.org/template:fractal10
 * @link https://www.dokuwiki.org/config:lang
 * @link https://www.dokuwiki.org/devel:configuration
 */


//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}

//header navigation
$lang["fractal10_headernav"]          = "Header-Navigation anzeigen?";
$lang["fractal10_headernav_location"] = "Falls ja, folgende wiki-Seite als Header-Navigation verwenden:";

//custom copyright notice
$lang["fractal10_copyright"]          = "Copyright-Hinweis einblenden?";
$lang["fractal10_copyright_default"]  = "Falls ja, Standard-Copyright-Hinweis nutzen?";
$lang["fractal10_copyright_location"] = "Falls nicht den Standard-Copyright-Hinweis, folgende wiki-Seite als Copyright-Hinweis verwenden:";

//custom footer content
$lang["fractal10_footer"]          = "Zusätzlichen, eigenen Inhalt für Footer einblenden?";
$lang["fractal10_footer_location"] = "Falls ja, folgende wiki-Seite als zusätzlichen Footer-Inhalt verwenden:";

//other stuff
$lang["fractal10_showpageinfo"]           = "Meta-Informationen über die betrachtete Seite im Footer anzeigen?";
$lang["fractal10_hideadminlinksfromanon"] = "Alle Links zu Admin- und Benutzerfunktionen verstecken, falls der Client kein authentifizierter Benutzer ist? Bitte beachten: Das Login-Formular muss manuell aufgerufen werden, falls diese Option aktiviert ist (Tipp: '".DOKU_URL.DOKU_SCRIPT."?do=login').";
$lang["fractal10_loaduserjs"]             = "Datei 'fractal10/user/user.js' laden?";

