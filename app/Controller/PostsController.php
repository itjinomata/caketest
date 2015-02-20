<?php


class PostsController extends AppController {

        // コンポーネントなのでコントローラーに書く。
        public $paginate = array(
            'limit' => 5,
            'order' => array(
                'Post.post_id' => 'desc'
            )
        );
        
        //関数に値が渡されなかったら、カッコ内の値が渡される。
    	public function index($postId = 0) {
            /**
             * tableのプライマリーキーがidならこれでいいけど
             * もし違うのであれば変数名変えてください
             * 
             * id0の存在する可能性があるため、こういうときは一般的にbooleanの値を渡したほうがわかりやすいと思います
             * というのもリレーショナルデータベースではidで紐づけることが多く、
             * 値が渡されなかった際、id0が入るつまり何にも紐付いていないデータを取得するんだな
             * と勘違いされる可能性があるためです
             */
            // → 引数$idがURLを取得する仕様と思っておりました。引数どんな値でも大丈夫だったんですね。修正しました。
            // → 引数をここで0にしてるのは、返信でない場合はreply_post_idに0を入れる仕様になっているため、このように考えています。
                        
            $listing = $this->Post->listing();
            $listMax = $listing[0]['Post']['post_id'];
            
            if($postId > 0 && $postId <= $listMax){
                $this->set('postId', $postId);
            }else{
                $this->set('postId', 0);                
            }
                
            $this->set('posts', $this->Post->listing());            
            $this->set('reply', $this->Post->recording($postId));
            
            //一覧表示の制御（foreach）をここでやる。それ以外は、paginateが勝手に$pagenateから計算してページを割り振ってくれる。
            $this->set('pgn', $this->paginate());                   
            
            if ($this->request->is('post')) {
                //var_dump($this->request->data);exit;
                if ($this->request->data['Post']['message']) {
                    //画像アップロードでエラーが出るので、バリデーションをfalseにしておく
                    if ($this->Post->save($this->request->data)) {
                        $this->Session->setFlash('Success!');
                        return $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Session->setFlash('failed!');
                    }
                }
            }
                                   
	}
    
        
        public function view($postId = false) {
 
            //postされている以外の数の時はindexにリダイレクトさせる。
            $listing = $this->Post->listing();
            $listMax = $listing[0]['Post']['post_id'];
            
            if($postId > 0 && $postId <= $listMax){
                //そのまま以後の操作を行う
            }else{
                return $this->redirect(array('action'=>'index'));
                //リダイレクトし終了
            }            
            
            //var_dump($id);exit;
            
            /**
             * オブジェクト参照にはコストがかかるため
             * 2回以上使うオブジェクトは変数に入れてしまったほうがいい
             * $table = $this->Post->recording($id)
             * $this->set('post', $table);   
             */
            
            //postデータの獲得
            $table = $this->Post->recording($postId);
            $this->set('post', $table);            
            
            /**
             * オブジェクト参照にはコストがかかるため
             * 2回以上使うオブジェクトは変数に入れてしまったほうがいい
             * $table = $this->Post->recording($id)
             * $this->set('post', $table);   
             */
            
            //prevデータ（前のデータ）の獲得            
            $this->set('prev', $this->Post->recording($table[0]['Post']['reply_post_id']));            
            
            //nextデータの獲得
            $this->set('nexts', $this->Post->nexting($postId));               
            
        }  
        
        public function delete($postId = false) {
            
            $user = $this->Auth->user();
            $table = $this->Post->recording($postId);
            
            
            /**
             * if文での変数の=演算子での評価は
             * 基本的に3つつけるようにしてください
             * 2つだと型のチェックまでしれくれず
             * (string)0 = (int)0
             * が成り立ってしまい、これで思わぬバグにつながることがあります
             */
            // → ありがとうございます。型を定義してない分、型合わせも考える必要があるんですよね。修正・納得しました。
            
            if ($user['member_id'] === $table[0]['Post']['member_id']){            
                if ($this->Post->delete($postId)) {
                    $this->Session->setFlash('Deleted!');
                    $this->redirect(array('action'=>'index'));
                }             
            
            }else{
                    $this->Session->setFlash('Failed!');
                    $this->redirect(array('action'=>'index'));                
            }    
                
                
        }  
        
        
}

?>