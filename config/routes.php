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
    $routes->connect('/update-profile', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'updateProfile'], ['_name' => 'update_profile']);
    $routes->connect('/change-password', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'changePassword'], ['_name' => 'change_password']);
    $routes->connect('/forgetpassword', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'forgetPassword']);
    $routes->connect('/resetpassword/:token', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'resetPassword']);
    $routes->connect('/active/:token', ['prefix' => 'Frontend', 'controller' => 'TblUser', 'action' => 'activeUser']);

    $routes->prefix('manage', function($routes) {
        $routes->connect('/index', ['controller' => 'Home', 'action' => 'index'], ['_name' => 'home']);
        // manage wallet
        $routes->connect('/wallet/index', ['controller' => 'Wallet', 'action' => 'index'], ['_name' => 'wallet']);
        $routes->connect('/wallet/add-wallet', ['controller' => 'Wallet', 'action' => 'add'], ['_name' => 'wallet_add']);
        $routes->connect('/wallet/edit-wallet/:wallet_id', ['controller' => 'Wallet', 'action' => 'edit'], ['_name' => 'wallet_edit', 'id' => '\d+']);
        $routes->connect('/wallet/delete/:wallet_id', ['controller' => 'Wallet', 'action' => 'delete'], ['_name' => 'wallet_delete', 'id' => '\d+']);
        $routes->connect('/wallet/expense/:wallet_id', ['controller' => 'Wallet', 'action' => 'expense'], ['_name' => 'wallet_expense','wallet_id'=>'\d+']);
        $routes->connect('/wallet/transfer/:wallet_id', ['controller' => 'Transaction', 'action' => 'transfer'], ['_name' => 'wallet_transfer','wallet_id'=>'\d+']);
        
        // manage category
        $routes->connect('/category/index/:wallet_id', ['controller' => 'Category', 'action' => 'index'], ['_name' => 'category', 'wallet_id' => '\d+', 'pass' => ['wallet_id']]);
        $routes->connect('/category/:wallet_id', ['controller' => 'Category', 'action' => 'index'], ['_name' => 'category', 'wallet_id' => '\d+', 'pass' => ['wallet_id']]);
        $routes->connect('/category/add/:wallet_id', ['controller' => 'Category', 'action' => 'add'], ['_name' => 'category_add', 'wallet_id' => '\d+', 'pass' => ['wallet_id']]);
        $routes->connect('/category/getdata/:wallet_id', ['controller' => 'Category', 'action' => 'getData'], ['_name' => 'category_get_data','wallet_id' => '\d+', 'pass' => ['wallet_id']]);
        $routes->connect('/category/edit/:id', ['controller' => 'Category', 'action' => 'edit'], ['_name' => 'category_edit', 'id' => '\d+']);
        $routes->connect('/category/getdataupdate/:id/:parent_id/:wallet_id', ['controller' => 'Category', 'action' => 'getDataUpdate'], ['_name' => 'category_get_data_update', 'id' => '\d+','parent_id' => '\d+','wallet_id' => '\d+']);        
        $routes->connect('/category/delete/wallet-:wallet_id/:id', ['controller' => 'Category', 'action' => 'delete'], ['_name' => 'category_delete', 'id' => '\d+','wallet_id' => '\d+','pass' => ['wallet_id']]);
        $routes->connect('/category/check/wallet-:wallet_id/:id', ['controller' => 'Category', 'action' => 'check'], ['_name' => 'category_check', 'id' => '\d+','wallet_id' => '\d+','pass' => ['wallet_id']]);
         
        // manage transaction
        $routes->connect('/transaction/index/:wallet_id',['controller'=>'Transaction','action'=>'index'],['_name'=>'transaction','wallet_id'=>'\d+','pass'=>['wallet_id']]);
        $routes->connect('/transaction/index/:wallet_id/:query_date',['controller'=>'Transaction','action'=>'query'],['_name'=>'transaction_query','wallet_id'=>'\d+','pass'=>['wallet_id']]);
        
        $routes->connect('/transaction/report-monthly/:wallet_id',['controller'=>'Transaction','action'=>'report'],['_name'=>'report_monthly','wallet_id'=>'\d+','pass'=>['wallet_id']]);
        
        $routes->connect('/transaction/add/:wallet_id',['controller'=>'Transaction','action'=>'add'],['_name'=>'transaction_add','wallet_id'=>'\d+','pass'=>['wallet_id']]);
        $routes->connect('/transaction/edit/:id',['controller'=>'Transaction','action'=>'edit'],['_name'=>'transaction_update','id'=>'\d+']);
        $routes->connect('/transaction/delete/:id',['controller'=>'Transaction','action'=>'delete'],['_name'=>'transaction_delete','id'=>'\d+']);        
        $routes->connect('/transaction/getdata/:wallet_id', ['controller' => 'Transaction', 'action' => 'getData'], ['_name' => 'transaction_get_data','wallet_id' => '\d+', 'pass' => ['wallet_id']]);
        
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
