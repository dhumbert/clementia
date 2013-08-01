<?php

class Site_Controller extends Base_Controller
{

    public $restful = TRUE;

    public function get_index()
    {
        $sites = Auth::user()->sites()->get();

        $allowed_tests = Auth::user()->allowed_tests() ?: '&infin;';

        $this->layout->nest('content', 'site.list', array(
            'user_can_create_more_sites' => !Auth::user()->has_reached_site_limit(),
            'sites' => $sites,
            'allowed_tests' => $allowed_tests,
        ));
    }

    public function get_create()
    {
        $site = new Site;
        $this->layout->nest('content', 'site.create', array(
            'site' => $site,
        ));
    }

    public function post_create()
    {
        $site = new Site;
        $site->parse_url(Input::get('domain'));
        $site->user_id = Auth::user()->id;

        if ($site->save()) {
            return Redirect::to('site');
        } else {
            return Redirect::to('site/create')
                ->with('error', $site->errors->all())
                ->with_input();
        }
    }

    public function delete_delete($id)
    {
        $site = Site::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();

        if (!$site) {
            return Response::error(404);
        }

        $site->delete();

        return Redirect::to('site')
            ->with('success', $site->domain . ' was removed from your account');
    }

    public function get_check_max_tests()
    {
        $this->layout = NULL;

        $site = Site::where('id', '=', Input::get('site'))->where('user_id', '=', Auth::user()->id)->first();

        if (!$site) {
            return Response::error(404);
        }

        $tests = count($site->tests);
        $max_tests = Auth::user()->role->tests_per_site;

        $maxedOut = true;
        if ($tests < $max_tests) {
            $maxedOut = false;
        }

        echo json_encode($maxedOut);
    }
}