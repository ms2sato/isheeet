<?php
class Controller_Authenticated extends Controller_Base{
  public function before(){
    parent::before();

    if(!$this->is_skipped() && !$this->is_logged_in()){
      Session::set_flash('error', 'アクセスできません');
      Response::redirect('/');
    }
  }

  // 真を返せばスキップされる
  protected function is_skipped(){
    // ex. introduction/ はログインしなくても大丈夫とする場合
    return Request::active()->controller == 'Controller_Introduction' &&
     in_array(Request::active()->action, array('index'));
  }
}
