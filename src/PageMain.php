<?php
/**
 * xLempCP - Web Server Control Panel
*
* @copyright 2015
* @license GPL-3
* @author lorenzo at poixson.com
* @link http://poixson.com/
*/
namespace pxn\xLempCP;

abstract class PageMain implements Page {

	protected static $twig;



	public function __construct() {
		$loader = new \Twig_Loader_Filesystem(__DIR__.'/views/');
		self::$twig = new \Twig_Environment($loader, [
				'debug' => TRUE,
				'static_variables' => TRUE,
				'auto_reload' => TRUE,
				'cache' => __DIR__.'/cache/'
		]);
	}



	public function Render() {
		// body content call
		$func = new \Twig_SimpleFunction('RenderBody', function () {
			echo 'this is my test BODY function';
			return $this->RenderBody();
		});
		self::$twig->addFunction($func);


$clss = \get_class($this);
$pos = \strrpos($clss, '\\');
$page = \substr($clss, $pos+1);


		return self::$twig->render('main.twig.html', [
				'MainMenuItems' => [
						[ 'isActive' => ($page == 'nginx'), 'url' => '/nginx/', 'title' => 'Nginx'],
						[ 'isActive' => ($page == 'php'),   'url' => '/php/',   'title' => 'PHP'],
						[ 'isActive' => ($page == 'db'),    'url' => '/db/',    'title' => 'MySQL'],
						[ 'isActive' => ($page == 'email'), 'url' => '/email/', 'title' => 'Postfix'],
						[ 'isActive' => ($page == 'zfs'),   'url' => '/zfs/',   'title' => 'ZFS'],
				]
//				'body' => $this->RenderBody()
		]);
	}



	protected abstract function RenderBody();



	public static function getTwig() {
		return self::$twig;
	}



}
