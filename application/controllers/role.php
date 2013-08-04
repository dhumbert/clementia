<?php

class Role_Controller extends Base_Controller
{

    public $restful = TRUE;

    public function get_edit($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return Response::error(404);
        }

        $this->layout->nest('content', 'role.edit', array(
            'role' => $role,
        ));
    }

    public function post_edit($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return Response::error(404);
        }

        $role->allowed_sites = Input::get('allowed_sites');
        $role->tests_per_site = Input::get('tests_per_site');

        if ($role->save()) {
            return Redirect::to_route('admin')->with('success', 'Role saved');
        } else {
            return Redirect::to_route('edit_role', array($id))->with('error', $role->errors->all());
        }
    }
}