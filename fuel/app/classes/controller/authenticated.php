<?php
class Controller_Authenticated extends Controller_Base{
  public function before(){
    parent::before();

    if(!$this->is_logged_in()){
      Session::set_flash('error', 'アクセスできません');
      Response::redirect('/');
    }

  }
}
