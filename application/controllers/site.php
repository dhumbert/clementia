<?php

class Site_Controller extends Base_Controller
{

    public $restful = TRUE;

    public function get_index()
    {
        $sites = Auth::user()->sites()->get();

        $this->layout->nest('content', 'site.list', array(
            'user_can_create_more_sites' => !Auth::user()->has_reached_site_limit(),
            'sites' => $sites,
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
}