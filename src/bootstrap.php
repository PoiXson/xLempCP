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

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;

require_once(__DIR__.'/../vendor/autoload.php');

class bootstrap {

	private static $instance = NULL;

	protected $router;
	protected $dispatcher = NULL;

	protected $pageClass = NULL;



	public static function get() {
		if(self::$instance == NULL)
			self::$instance = new static();
		return self::$instance;
	}
	public function __construct() {
		$this->router = new RouteCollector();
		// default route
		$this->router->any('/',         ['pxn\\xLempCP\\routes\\dashboard', 'Render']);
		// mysql
		$this->router->any('/db',       ['pxn\\xLempCP\\routes\\db',        'Render']);
		// php
		$this->router->any('/php',      ['pxn\\xLempCP\\routes\\php',       'Render']);
		// zfs page
		$this->router->any('/zfs',      ['pxn\\xLempCP\\routes\\zfs',       'Render']);
		$this->router->any('/zfs/{id}', ['pxn\\xLempCP\\routes\\zfs',       'Render']);
	}



/*
	public function addRoute($name) {
		$this->router->any(
				'/'.$name.'/{disk:\a+}',
				function($disk) use ($name) {
					echo $disk;
					if(empty($name))
						$name = 'dashboard';
					$classPath = 'pxn\\xLempCP\\routes\\'.$name;
					// ensure page class exists
					if(!\class_exists($classPath)) {
						return 'Oops?! The page file \''.$name.'\' could not be found. '.
								'This shouldn\'t happen! This is a last resort error page.';
					}
					// load page class
					$this->pageClass = new $classPath();
					// call render() function
					if(!\method_exists($this->pageClass, 'Render')) {
						return 'Oops?! The page class doesn\'t contain a Render() function!';
					}
					return $this->pageClass->Render();
				}
		);
	}
*/



	public function dispatch() {
		$this->dispatcher = new Dispatcher(
				$this->router->getData()
		);
		try {
			$response = $this->dispatcher->dispatch(
					$_SERVER['REQUEST_METHOD'],
					\parse_url($_SERVER['REQUEST_URI'], \PHP_URL_PATH)
			);
		} catch (HttpRouteNotFoundException $e) {
			echo '<p>404 - '.$e->getMessage().'</p>';
			return;
		}
		echo '<p>RESPONSE: '.$response.'</p>';
	}



}

bootstrap::get()
	->dispatch();
