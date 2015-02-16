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

        /**
         * 恐らく確認画面から戻ってきた時にvalueに渡すということをしたいんだろうけど
         * $this->request->dataに値を渡せばvalueに関してがcakeがよしなにやってくれるはず ①
         * 
         * またSessionが存在しているかどうかを判定してこの処理を書かなければSessionが存在しない時に内部的にエラーになってるはず ②
         */
        // $this->request->data['Post'] に値が存在すれば勝手にFormに値を代入してくれる。
        // ② セッション情報ある場合、入力（checkから戻ったとき）
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
                 * すでにここがaction indexなので自分自身にredirectする意味はない
                 * ここでredirectしなければまたindexのviewが表示されます
                 * 
                 * ここのアルゴリズムの説明が必要だったら声かけてください
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
        /**
         * このactionはよくかけてるね
         * ただSessionが存在するかどうかをチェックして
         * 存在しない場合indexにredirectしてやる
         * みたいに書かないと、
         * いきなりcheckに飛んできた時にエラーのページが表示されるので
         * Sessionの存在チェックをしてください
         */
        // echo"<pre>";var_dump($this->Session->read('Posting'));echo"</pre>";exit;
        //セッション情報がきちんと入力されているか否かでindexからステップを経て来ているか判別
        if ($this->Session->read('Posting')) {

            $this->set('sesposts', $this->Session->read('Posting'));

            if ($this->request->is('post')) {

                //パスワードを暗号化する
                $sessionPlus = $this->Session->read('Posting');
                $passwordHasher = new SimplePasswordHasher();
                $sessionPlus['password'] = $passwordHasher->hash($sessionPlus['password']);

                if ($this->Member->save($sessionPlus)) {
                    $this->Session->setFlash('Success!');
                    $this->Session->delete('Posting');
                    $this->redirect(array('action' => 'thanks'));
                } else {
                    $this->Session->setFlash('failed!');
                }
            }
        } else {
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