<?php

class Test_Controller extends Base_Controller 
{

	public $restful = TRUE;

	public function get_list() 
  {
    $tests = Auth::user()->tests;
		$this->layout->nest('content', 'test.list', array(
      'tests' => $tests,
    ));
	}

  public function get_detail($id) 
  {
    $test = Test::find($id);
    if (!$test) {
      return Response::error('404');
    } else {
      $logs = $test->logs()->order_by('created_at', 'desc')->get();
      $description = $test->generate_description_for_output();

      $this->layout->nest('content', 'test.detail', array(
        'test' => $test,
        'logs' => $logs,
        'description' => $description,
      ));
    }
  }

  public function put_run($id) 
  {
    $test = Test::find($id);
    if (!$test) {
      return Response::error('404');
    } else {
      $test->run();
      return Redirect::to_route('test_detail', array($id))->with('success', 'Sweet! The test was run.');
    }
  }

	public function get_create() 
  {
		$this->layout->nest('content', 'test.create');
	}

  public function post_create() 
  {
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

  public function delete_destroy($id) {
    $test = Test::find($id);
    if (!$test) {
      return Response::error('404');
    } else {
      if ($test->destroy_if_user_can(Auth::user()->id)) {
        return Redirect::to_route('test_list')->with('success', 'Test deleted.');
      } else {
        return Response::error('403');
      }
    }
  }

}