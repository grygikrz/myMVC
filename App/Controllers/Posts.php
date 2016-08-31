<?php

namespace App\Controllers;

use \Core\View;
use \Core\Lang;
/**
 * Home controller
 *
 * PHP version 5.4
 */
class Posts extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
		View::renderTemplate('Posts/index.html', [
    	'lang' => Lang::get('simple text', 'simple text')
]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
