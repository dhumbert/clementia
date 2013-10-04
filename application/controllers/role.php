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

        $role->name = Input::get('name');
        $role->allowed_sites = Input::get('allowed_sites');
        $role->tests_per_site = Input::get('tests_per_site');
        $role->price = number_format(Input::get('price'), 2, '.', '');

        if ($role->save()) {
            return Redirect::to_route('admin')->with('success', 'Role saved');
        } else {
            return Redirect::to_route('edit_role', array($id))->with('error', $role->errors->all());
        }
    }

    public function get_create()
    {
        $role = new Role;

        $this->layout->nest('content', 'role.create', array(
           'role' => $role,
        ));
    }

    public function post_create()
    {
        $role = new Role;
        $role->name = Input::get('name');
        $role->allowed_sites = Input::get('allowed_sites');
        $role->tests_per_site = Input::get('tests_per_site');
        $role->price = number_format(Input::get('price'), 2, '.', '');

        if ($role->save()) {
            Event::fire('role.created', array($role));
            return Redirect::to_route('admin')
                ->with('success', 'Role created');
        } else {
            return Redirect::to_route('create_role')
                ->with_input()
                ->with('error', $role->errors->all());
        }
    }
}