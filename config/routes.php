<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('Route');

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['prefix' => 'Frontend', 'controller' => 'Pages', 'action' => 'display', 'home']);
    $routes->connect('/pages/:action', ['prefix' => 'Frontend', 'controller' => 'Pages']);
    $routes->connect('/user/:action', ['prefix' => 'Frontend', 'controller' => 'TblUser']);
    $routes->connect('/register', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'add']);
    $routes->connect('/login', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'login'], ['_name' => 'login']);
    $routes->connect('/loginHome', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'loginHome']);
    $routes->connect('/logout', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'logout'], ['_name' => 'logout']);
    $routes->connect('/forgetpassword', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'forgetPassword']);
    $routes->connect('/resetpassword/:token', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'resetPassword']);
    $routes->connect('/active/:token', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'activeUser']);

    $routes->prefix('manage', function($routes) {
        $routes->connect('/index', ['controller' => 'Home', 'action' => 'index'], ['_name' => 'home']);
        // manage wallet
        $routes->connect('/wallet/index', ['controller' => 'Wallet', 'action' => 'index'], ['_name' => 'wallet']);
        $routes->connect('/wallet/add-wallet', ['controller' => 'Wallet', 'action' => 'add'], ['_name' => 'wallet_add']);
        $routes->connect('/wallet/edit-wallet/:id', ['controller' => 'Wallet', 'action' => 'edit'], ['_name' => 'wallet_edit', 'id' => '\d+']);
        $routes->connect('/wallet/delete-wallet/:id', ['controller' => 'Wallet', 'action' => 'index'], ['_name' => 'wallet_delete', 'id' => '\d+']);
        // manage category
        $routes->connect('/category/index/:wallet_id', ['controller' => 'Category', 'action' => 'index'], ['_name' => 'category', 'wallet_id' => '\d+', 'pass' => ['wallet_id']]);
        $routes->connect('/category/:wallet_id', ['controller' => 'Category', 'action' => 'index'], ['_name' => 'category', 'wallet_id' => '\d+', 'pass' => ['wallet_id']]);
        $routes->connect('/category/add/:wallet_id', ['controller' => 'Category', 'action' => 'add'], ['_name' => 'category_add', 'wallet_id' => '\d+', 'pass' => ['wallet_id']]);

        $routes->connect('/category/getdata/:wallet_id', ['controller' => 'Category', 'action' => 'getData'], ['_name' => 'category_get_data','wallet_id' => '\d+', 'pass' => ['wallet_id']]);

        $routes->connect('/category/edit/:id', ['controller' => 'Wallet', 'action' => 'edit'], ['_name' => 'category_edit', 'id' => '\d+']);
        $routes->connect('/category/delete/:id', ['controller' => 'Wallet', 'action' => 'index'], ['_name' => 'category_delete', 'id' => '\d+']);
        $routes->fallbacks('InflectedRoute');
    });

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
//    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `InflectedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('InflectedRoute');
});


/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
