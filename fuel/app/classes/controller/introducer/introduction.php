<?php
class Controller_Introducer_Introduction extends Controller_Introducer
{

	public function action_index()
	{
		$query = Model_Introduction::query();
    $total_items = $query->count();
		$per_page = Config::get('private.default_per_page');

    $pagination = Pagination::forge('introductionpages', [
        'total_items' => $total_items,
        'per_page'    => $per_page,
        'uri_segment' => 'page',
    ]);
    $data['pagination'] = $pagination;

    $data['introductions'] =
        $query
        ->order_by('created_at', 'desc')
        ->limit($pagination->per_page)
        ->offset($pagination->offset)
        ->get();

		//$data['introductions'] = Model_Introduction::find('all');
		$this->template->title = "Introductions";
		$this->template->content = View::forge('introducer/introduction/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('introduction');

		if ( ! $data['introduction'] = Model_Introduction::find($id))
		{
			Session::set_flash('error', 'Could not find introduction #'.$id);
			Response::redirect('introducer/introduction');
		}

		$this->template->title = "Introduction";
		$this->template->content = View::forge('introducer/introduction/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			if(!Security::check_token()){
				Response::redirect('/');
			}

			$val = Model_Introduction::validate('create');

			if ($val->run())
			{
				$introduction = Model_Introduction::forge(array(
					'introducer_id' => Input::post('introducer_id'),
					'introduced_id' => Input::post('introduced_id'),
					'catchphrase' => Input::post('catchphrase'),
					'body' => Input::post('body'),
					'image_key' => Input::post('image_key'),
					'image_content_type' => 'image/jpeg',
				));

				if ($introduction and $introduction->save())
				{
					Session::set_flash('success', 'Added introduction #'.$introduction->id.'.');

					Response::redirect('introducer/introduction');
				}

				else
				{
					Session::set_flash('error', 'Could not save introduction.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Introductions";
		$this->template->content = View::forge('introducer/introduction/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('introducer/introduction');
		$this->send_mail();

		if ( ! $introduction = Model_Introduction::find($id))
		{
			Session::set_flash('error', 'Could not find introduction #'.$id);
			Response::redirect('introducer/introduction');
		}

		$val = Model_Introduction::validate('edit');

		if ($val->run())
		{
			$introduction->introducer_id = Input::post('introducer_id');
			$introduction->catchphrase = Input::post('catchphrase');
			$introduction->body = Input::post('body');
			$introduction->image_key = Input::post('image_key');

			if(!Security::check_token()){
				Response::redirect('/');
			}

			if ($introduction->save())
			{
				Session::set_flash('success', 'Updated introduction #' . $id);

				Response::redirect('introducer/introduction');
			}

			else
			{
				Session::set_flash('error', 'Could not update introduction #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$introduction->introducer_id = $val->validated('introducer_id');
				$introduction->catchphrase = $val->validated('catchphrase');
				$introduction->body = $val->validated('body');
				$introduction->image_key = $val->validated('image_key');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('introduction', $introduction, false);
		}

		$this->template->title = "Introductions";
		$this->template->content = View::forge('introducer/introduction/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('introducer/introduction');

		if ($introduction = Model_Introduction::find($id))
		{
			$introduction->delete();

			Session::set_flash('success', 'Deleted introduction #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete introduction #'.$id);
		}

		Response::redirect('introducer/introduction');

	}

	private function send_mail(){
		$email = \Email::forge();
		$email->from(Config::get('private.default_mail_from'), 'テスト配信サーバ');
		$email->to(Config::get('private.default_mail_to'));
		$email->subject('件名');
		$body = '本文';
		$email->body($body);

		try {
		    $email->send();
		}
		catch (\EmailValidationFailedException $e) {
		    $err_msg = '送信に失敗しました。';
				Log::debug($e);
		}
		catch (\EmailSendingFailedException $e) {
		    $err_msg = '送信に失敗しました。';
				Log::debug($e);
		}
	}


}
