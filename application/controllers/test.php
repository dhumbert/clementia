<?php

class Test_Controller extends Base_Controller 
{

	public $restful = TRUE;

	public function get_list() 
  {
    $tests = Auth::user()->tests;
    $user_can_create_more_tests = !Auth::user()->has_reached_his_test_limit();
		$this->layout->nest('content', 'test.list', array(
      'tests' => $tests,
      'user_can_create_more_tests' => $user_can_create_more_tests,
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

  public function post_run($id) 
  {
    $test = Test::find($id);
    if (!$test) {
      return Response::error('404');
    } else {
      $test->queue();
      return Redirect::to_route('test_detail', array($id))->with('success', 'Sweet! The test will be run soon.');
    }
  }

	public function get_create() 
  {
    $test = new Test;
		$this->layout->nest('content', 'test.create', array(
      'test' => $test,
    ));
	}

  public function post_create() 
  {
    $test = new Test;
    $test->description = Input::get('description');
    $test->url = Input::get('url');
    $test->type = Input::get('type');
    $test->user_id = Auth::user()->id;
    $test->options = Input::get('options');

    try {
      if ($test->save()) {
        return Redirect::to_route('test_detail', array($test->id));
      } else {
        return Redirect::to('test/create')
          ->with('error', $test->errors->all())
          ->with_input();
      }
    } catch (Max_Tests_Exceeded_Exception $e) {
      return Redirect::to_route('test_list')->with('error', 'Sorry! You have reached the maximum amount of tests you are allowed.');
    }
  }

  public function get_edit($id)
  {
    $test = Test::find($id);
    if (!$test) {
      return Response::error('404');
    } else {
      $this->layout->nest('content', 'test.edit', array(
        'test' => $test,
      ));
    }
  }

  public function put_edit($id)
  {
    $test = Test::find($id);
    if (!$test) {
      return Response::error('404');
    } else {
      $test->description = Input::get('description');
      $test->url = Input::get('url');
      $test->type = Input::get('type');
      $test->options = Input::get('options');

      if ($test->save()) {
        return Redirect::to_route('test_detail', array($test->id));
      } else {
        return Redirect::to('test/edit/'.$id)
          ->with('error', $test->errors->all())
          ->with_input();
      }
    }
  }

  public function delete_destroy($id) 
  {
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