<?php
class Controller_Introduction extends Controller_Base
{

	public function action_index()
	{
		$data['introductions'] = Model_Introduction::find('all');
		$this->template->title = "Introductions";
		$this->template->content = View::forge('introduction/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('introduction');

		if ( ! $data['introduction'] = Model_Introduction::find($id))
		{
			Session::set_flash('error', 'Could not find introduction #'.$id);
			Response::redirect('introduction');
		}

		$this->template->title = "Introduction";
		$this->template->content = View::forge('introduction/view', $data);

	}

}
