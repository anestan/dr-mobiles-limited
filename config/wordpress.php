<?php

/*
|--------------------------------------------------------------------------
| Notes - README
|--------------------------------------------------------------------------
|
| You can add as many WordPress constants as you want here. Just make sure
| to add them at the end of the file or at least after the "WordPress
| authentication keys and salts" section.
|
*/

/*
|--------------------------------------------------------------------------
| WordPress authentication keys and salts
|--------------------------------------------------------------------------
|
| @link https://api.wordpress.org/secret-key/1.1/salt/
|
*/
define('AUTH_KEY',         '!.i^x0|h5A<Na+sv<-jM-b!Gkr~4kVK _r;l+.Y<fo4)RE$NZnT|<_BJ/&py:A+_');
define('SECURE_AUTH_KEY',  '0,6JxJ+as7G,M,mo{}!~bM|/hLb+i)^IOYxB|JAo+scpP/[^M$Xx+RT? O~IGnzU');
define('LOGGED_IN_KEY',    'cyNj:&[&zJfS0C,YjAS%AP}f|V|+[`jM*de,$-rMM)q,=_% ,<b%=Hr(ki,xrz=v');
define('NONCE_KEY',        '&XLC`c@D`@o*1iahlML)6dxfE)/hx(]<ishR1Abz?q5)VXn0*_Qu-2}l%Qw%tO/9');
define('AUTH_SALT',        '_2|pRY7*Y:>$|=R#1nK-jxOsyuaO[p-$TC@h-GtlRBEx$d@vMkiW*[(Hw!ME-<rT');
define('SECURE_AUTH_SALT', 'd*aG]1*{`y3KS;P>r.agOOp-Y(rb08%V?BJ+0jw65[<)w1D[&w. z>Nr1-`$BUUW');
define('LOGGED_IN_SALT',   '+ =>Gwi&~C-}JCT=q)(O~e{45?gBX*rJ-w8I!6$H+N)vz.lO}obzQH|Pe3`[-^~P');
define('NONCE_SALT',       '^:_p:|+|Jnj3kq*HpoARcB~~*Yv|e|ME9gON+L0x?GzOVqrB*t(-|^w^pk|[:$Mn');

/*
|--------------------------------------------------------------------------
| WordPress database
|--------------------------------------------------------------------------
*/
define('DB_NAME', config('database.connections.mysql.database'));
define('DB_USER', config('database.connections.mysql.username'));
define('DB_PASSWORD', config('database.connections.mysql.password'));
define('DB_HOST', config('database.connections.mysql.host'));
define('DB_CHARSET', config('database.connections.mysql.charset'));
define('DB_COLLATE', config('database.connections.mysql.collation'));

/*
|--------------------------------------------------------------------------
| WordPress URLs
|--------------------------------------------------------------------------
*/
define('WP_HOME', config('app.url'));
define('WP_SITEURL', config('app.wp.url'));
define('WP_CONTENT_URL', WP_HOME.'/'.CONTENT_DIR);

/*
|--------------------------------------------------------------------------
| WordPress debug
|--------------------------------------------------------------------------
*/
define('SAVEQUERIES', config('app.debug'));
define('WP_DEBUG', config('app.debug'));
define('WP_DEBUG_DISPLAY', config('app.debug'));
define('SCRIPT_DEBUG', config('app.debug'));

/*
|--------------------------------------------------------------------------
| WordPress auto-update
|--------------------------------------------------------------------------
*/
define('WP_AUTO_UPDATE_CORE', false);

/*
|--------------------------------------------------------------------------
| WordPress file editor
|--------------------------------------------------------------------------
*/
define('DISALLOW_FILE_EDIT', true);

/*
|--------------------------------------------------------------------------
| WordPress default theme
|--------------------------------------------------------------------------
*/
define('WP_DEFAULT_THEME', 'dr-mobiles-limited');

/*
|--------------------------------------------------------------------------
| Application Text Domain
|--------------------------------------------------------------------------
*/
define('APP_TD', env('APP_TD', 'themosis'));

/*
|--------------------------------------------------------------------------
| JetPack
|--------------------------------------------------------------------------
*/
define('JETPACK_DEV_DEBUG', config('app.debug'));
