<?php

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class MembersController extends AppController {

    //Authの仕様のログインページへのリンク回避
    public function beforeFilter() {
        parent::beforeFilter();

        //リンク回避の範囲全体
        $this->Auth->allow();
    }

    public function index() {

        // ② セッション情報ある場合、入力（checkから戻ったとき）
        
        /**
         * この処理はPOSTされたタイミングでは不要な処理のため
         * 記入する位置を調整してください
         */
        if (($this->Session->read('Posting')) && (empty($this->request->data['Member']))) {
            $this->request->data['Member'] = $this->Session->read('Posting');
        }

        // ① Postが送られたタイミングでデータが格納される（index内のvalidation）

        if ($this->request->is('post')) {
            $this->Member->set($this->request->data['Member']);
            // リクエストデータの形式Post

            if ($this->Member->validates()) {

                //echo"<pre>";var_dump($this->request->data);echo"</pre>";
                //echo exit;

                $this->Session->write('Posting', $this->request->data['Member']);
                $this->redirect(array('action' => 'check'));

                //echo '成功です。';
            } else {
                
                /**
                 * 無駄なeles文は書かないこと
                 */

                // 最初の②の部分でセッションの値を代入する関数をとっていたため、バリデーション発動時の前の値の代入でこの操作が必要になったのではと考えられる。
                // $this->Session->write('Posting', $this->request->data['Post']);
                // $this->redirect(array('action'=>'index'));
                //echo '失敗です。';
                //echo"<pre>";var_dump($this->Member->validationErrors);echo"</pre>";                    
            }
        }
    }

    public function check() {

        // echo"<pre>";var_dump($this->Session->read('Posting'));echo"</pre>";exit;
        //セッション情報がきちんと入力されているか否かでindexからステップを経て来ているか判別
        if ($this->Session->read('Posting')) {

            $this->set('sesposts', $this->Session->read('Posting'));

            if ($this->request->is('post')) {

                //パスワードを暗号化する
                /**
                * この方式だと
                * postされてる内容にuser_idとかプライマリーキーを入れられていると(開発者ツールでuser_idとかのツール使って勝手にフォーム生成されたりして)
                * UPDATE文になり、勝手にレコードを書き換えることが可能だったりします
                * 
                * cakeでsaveを利用するとinsertとupdateをプライマリーキーで判断してくれちゃうので
                * insertをしたい時はpostデータから必要なデータだけをとりだしてsave
                * もしくはpostデータからプライマリーキーの配列を削除してsaveをするようにしましょう
                */
                $sessionPlus = $this->Session->read('Posting');
                $passwordHasher = new SimplePasswordHasher();
                $sessionPlus['password'] = $passwordHasher->hash($sessionPlus['password']);

                if ($this->Member->save($sessionPlus)) {
                    $this->Session->setFlash('Success!');
                    $this->Session->delete('Posting');
                    /**
                     * redirectは別ページに飛ばし、処理が終わるため
                     * return をつけよう
                     * これがあると、cakeのredirectについて知らない人がコードを呼んでも
                     * saveがtrueだとredirectして終了なんだなって一発でわかるので
                     */
                    $this->redirect(array('action' => 'thanks'));
                } else {
                    $this->Session->setFlash('failed!');
                }
            }
        } else {
            
            /**
             * この処理をcheckメソッドの一番上で行うことでif文のネストを避けることができる
             * 
             * if(!$this->Session->read('Posting')){
             *      $this->redirect(array('action' => 'index')); 
             *      return;
             * }
             * 
             * if ($this->request->is('post')) {
             * ～～～～～～～～～～～
             */
            $this->redirect(array('action' => 'index'));
        }
    }

    public function thanks() {
        
    }

    public function login() {

        if ($this->Auth->loggedIn()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                //public $componentsで指定した場所にアクセスする。
                //redirectは2.3で廃止されている。
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }
        
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

}

?>