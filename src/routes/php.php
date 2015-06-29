<?php
/**
 * xLempCP - Web Server Control Panel
 *
 * @copyright 2004-2015
 * @license GPL-3
 * @author lorenzo at poixson.com
 * @link http://poixson.com/
 */
namespace pxn\xLempCP\routes;

class php implements \pxn\xLempCP\Page {



	public function Render($id='') {
		return '<p>PHP PAGE '.$id.'</p>';
	}



}
