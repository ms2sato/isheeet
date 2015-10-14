<?php
class Controller_Introduction extends Controller_Template
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

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Introduction::validate('create');

			if ($val->run())
			{
				$introduction = Model_Introduction::forge(array(
					'introducer_id' => Input::post('introducer_id'),
					'cachphrase' => Input::post('cachphrase'),
					'body' => Input::post('body'),
					'image_key' => Input::post('image_key'),
				));

				if ($introduction and $introduction->save())
				{
					Session::set_flash('success', 'Added introduction #'.$introduction->id.'.');

					Response::redirect('introduction');
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
		$this->template->content = View::forge('introduction/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('introduction');

		if ( ! $introduction = Model_Introduction::find($id))
		{
			Session::set_flash('error', 'Could not find introduction #'.$id);
			Response::redirect('introduction');
		}

		$val = Model_Introduction::validate('edit');

		if ($val->run())
		{
			$introduction->introducer_id = Input::post('introducer_id');
			$introduction->cachphrase = Input::post('cachphrase');
			$introduction->body = Input::post('body');
			$introduction->image_key = Input::post('image_key');

			if ($introduction->save())
			{
				Session::set_flash('success', 'Updated introduction #' . $id);

				Response::redirect('introduction');
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
				$introduction->cachphrase = $val->validated('cachphrase');
				$introduction->body = $val->validated('body');
				$introduction->image_key = $val->validated('image_key');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('introduction', $introduction, false);
		}

		$this->template->title = "Introductions";
		$this->template->content = View::forge('introduction/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('introduction');

		if ($introduction = Model_Introduction::find($id))
		{
			$introduction->delete();

			Session::set_flash('success', 'Deleted introduction #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete introduction #'.$id);
		}

		Response::redirect('introduction');

	}

}
