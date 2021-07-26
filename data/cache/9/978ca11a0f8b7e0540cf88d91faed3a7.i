a:6:{i:0;a:3:{i:0;s:14:"document_start";i:1;a:0:{}i:2;i:0;}i:1;a:3:{i:0;s:6:"header";i:1;a:3:{i:0;s:8:"htaccess";i:1;i:1;i:2;i:1;}i:2;i:1;}i:2;a:3:{i:0;s:12:"section_open";i:1;a:1:{i:0;i:1;}i:2;i:1;}i:3;a:3:{i:0;s:12:"preformatted";i:1;a:1:{i:0;s:1643:"## You should disable Indexes and MultiViews either here or in the
## global config. Symlinks maybe needed for URL rewriting.
Options -Indexes -MultiViews +FollowSymLinks
## make sure nobody gets the htaccess, README, COPYING or VERSION files
<Files ~ "^([\._]ht|README$|VERSION$|COPYING$)">
  <IfModule mod_authz_core.c>
      Require all denied
  </IfModule>
  <IfModule !mod_authz_core.c>
      Order allow,deny
      Deny from all
  </IfModule>
</Files>
## Don't allow access to git directories
<IfModule alias_module>
  RedirectMatch 404 /\.git
</IfModule>
## Uncomment these rules if you want to have nice URLs using
#$conf['userewrite'] = 1 - not needed for rewrite mode 2
RewriteEngine on
RewriteBase /
RewriteRule ^_media/(.*)              lib/exe/fetch.php?media=$1  [QSA,L]
RewriteRule ^_detail/(.*)             lib/exe/detail.php?media=$1  [QSA,L]
RewriteRule ^_export/([^/]+)/(.*)     doku.php?do=export_$1&id=$2  [QSA,L]
RewriteRule ^$                        doku.php  [L]
RewriteCond %{REQUEST_FILENAME}       !-f
RewriteCond %{REQUEST_FILENAME}       !-d
RewriteRule (.*)                      doku.php?id=$1  [QSA,L]
RewriteRule ^index.php$               doku.php
## Not all installations will require the following line.  If you do,
## change "/dokuwiki" to the path to your dokuwiki directory relative
## to your document root.
#
## If you enable DokuWikis XML-RPC interface, you should consider to
## restrict access to it over HTTPS only! Uncomment the following two
## rules if your server setup allows HTTPS.
#RewriteCond %{HTTPS} !=on
#RewriteRule ^lib/exe/xmlrpc.php$      https://%{SERVER_NAME}%{REQUEST_URI} [L,R=301]";}i:2;i:26;}i:4;a:3:{i:0;s:13:"section_close";i:1;a:0:{}i:2;i:26;}i:5;a:3:{i:0;s:12:"document_end";i:1;a:0:{}i:2;i:26;}}