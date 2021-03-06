<?php

class Test_Controller extends Base_Controller 
{

    public $restful = TRUE;

    public function get_list() 
    {
        $this->layout->nest('content', 'test.list');
    }

    public function get_ajax_list()
    {
        $this->layout = NULL;

        $tests = Test::tests_for_ajax(Auth::user(), Input::get('site'), Input::get('status'), Input::get('sort'), Input::get('dir'));
        echo json_encode($tests);
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
            $result = $test->begin();
            $message = $result == Test::TEST_RUN ? 'Sweet! The test was run.' : 'Sweet! The test will be run soon.';
            return Redirect::to_route('test_detail', array($id))->with('success', $message);
        }
    }

    public function get_create() 
    {
        if (Auth::user()->has_sites()) {
            $test = new Test;
            $test->autorun = TRUE; // default
            $this->layout->nest('content', 'test.create', array(
                'test' => $test,
                'types' => IoC::resolve('tester')->get_types(),
                'sites' => Auth::user()->sites_dropdown_options(),
            ));
        } else {
            return Redirect::to('site/create')->with('error', 'You must create a site before you can create a test');
        }
    }

    public function post_create() 
    {
        $test = new Test;
        $test->description = Input::get('description');
        $test->url = Input::get('url');
        $test->type = Input::get('type');
        $test->site_id = Input::get('site');
        $test->options = Input::get('options');
        $test->autorun = Input::get('autorun') ?: false;

        try {
            if ($test->save()) {
                return Redirect::to_route('test_detail', array($test->id));
            } else {
                return Redirect::to('test/create')
                ->with('error', $test->errors->all())
                ->with_input();
            }
        } catch (Max_Tests_Exceeded_Exception $e) {
            return Redirect::to_route('test_list')->with('error',
                "Sorry! You have reached the maximum amount of tests you are allowed for this site. If you'd like to add more,
                    you will need to delete some of the ones below, or upgrade. <!-- todo: upgrade link -->");
        } catch (Invalid_Options_Exception $e) {
            return Redirect::to('test/create')
            ->with('error', $e->getMessage())
            ->with_input();
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
                'types' => IoC::resolve('tester')->get_types(),
                'sites' => Auth::user()->sites_dropdown_options(),
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
            $test->autorun = Input::get('autorun') ?: false;

            try {
                if ($test->save()) {
                    return Redirect::to_route('test_detail', array($test->id));
                } else {
                    return Redirect::to('test/edit/'.$id)
                    ->with('error', $test->errors->all())
                    ->with_input();
                }
            } catch (Invalid_Options_Exception $e) {
                return Redirect::to('test/create')
                ->with('error', $e->getMessage())
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