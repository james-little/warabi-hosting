<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'hosting');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'hosting');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'T9xQ7b6@mn0X');

/** MySQL のホスト名 */
define('DB_HOST', '127.0.0.1:/var/run/mysql/mysqld.sock');
// define('DB_HOST', '127.0.0.1:3306');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');
define('WP_USE_EXT_MYSQL', false);

define('WP_REDIS_PATH', '/var/run/redis/6379.sock');


/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'z?:(V kDgnld1SIQd0,@UK`a#h(fst<*j(x#jehCu%wzw,B#D Ay_j|M1%EwiKo|');
define('SECURE_AUTH_KEY',  'p_@k7YIRd[568PSiN+dF/{n-&o:|H`vqX+eT&F.zn4S:XiUY/%bHFKh-|KNeDg|O');
define('LOGGED_IN_KEY',    '<wT>${Fb]-2yxi,T(;$#G:4$;`y=S-UxrZZT7iJ`u|VO.ji-q3aM G`mT##--NnV');
define('NONCE_KEY',        '!{=6HZyE^T;qO|NJOTg$wmM#TuZ+lIo4A_UAu}+1+.`[!X+1=+>*BzdvZ#39jCgi');
define('AUTH_SALT',        'A-R8-3+@Y(+y-W+2U(-:vux(e44d0{;wLEwp|goRdl?5A]dsM[yHDrd[I-*eA b%');
define('SECURE_AUTH_SALT', 'gs.{JPM[9~VtTnVXyb-Y-Y-+]uY-QSdK[s[vAjbVUY|![ac@Nlt,bSeWQbtxx3^3');
define('LOGGED_IN_SALT',   ':,c`.|R2,YyX!gCQ2`*lZV kAQ$&nDXY#tF{n{r:E84ZBO|?eN%fHH-5O^ 8Ia)?');
define('NONCE_SALT',       '&<qE$?j)^P^zDXk1/^pq|WWtF{&Viui(?f$d-JipZePm.eE)+{.SLac[vP/|cTjm');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
