<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
	public $helpers = array('Html', 'Form', 'Session');
        
	public $components = array(
		'Session', 
		'Auth' => array(
			'loginAction' => array('controller' => 'members','action' => 'login'), //ログインを行なうaction
                       'loginRedirect' => array('controller' => 'posts', 'action' => 'index'), //ログイン後のページ
                       'logoutRedirect' => array('controller' => 'members', 'action' => 'login'), //ログアウト後のページ
			'authError'=>'ログインして下さい。',
			'authenticate' => array(
            	            'Form' => array(
                	        'userModel' => 'Member', //ユーザー情報のモデル
                               'fields' => array('username' => 'email','password'=>'password')
                            )
                       )
		)
	);
        
        public function beforeFilter(){
            //上記でユーザー情報はMemberで指定されている。
            $this->set('user', $this->Auth->user());
        }
        
    
}
