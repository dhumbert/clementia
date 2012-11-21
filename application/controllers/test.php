<?php

class Test_Controller extends Base_Controller {

	public $restful = TRUE;

	public function get_list() {
    $tests = Auth::user()->tests;
		$this->layout->nest('content', 'test.list', array(
      'tests' => $tests,
    ));
	}

  public function get_detail($id) {
    $test = Test::find($id);
    if (!$test) {
      return Response::error('404');
    } else {
      $this->layout->nest('content', 'test.detail', array(
        'test' => $test,
      ));
    }
  }

  public function put_run($id) {
    echo 'sfd';
  }

	public function get_create() {
		$this->layout->nest('content', 'test.create');
	}

  public function post_create() {
    $test = new Test;
    $test->description = Input::get('description');
    $test->url = Input::get('url');
    $test->type = Input::get('type');
    $test->user_id = Auth::user()->id;
    $test->save_options(Input::get('options'));

    if ($test->save()) {
      return Redirect::to('test');
    } else {
      return Redirect::to('test/create')
        ->with('error', $test->errors->all())
        ->with_input();
    }
  }

}