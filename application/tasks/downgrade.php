<?php

class Downgrade_Task
{
    public function __construct()
    {
        Bundle::start('composer');
    }

    public function run($arguments)
    {
        $users = User::where('downgrade_date', '<=', date('Y-m-d'))->get();
        if ($users) {
            foreach ($users as $user) {
                try {
                    // subscription was already downgraded in payment gateway, should be effective today
                    // so just change role
                    $role = Role::find($user->downgrade_role_id);
                    if (!$role) {
                        throw new Exception("Downgrade role id {$role->id} not found!");
                    }

                    $user->role_id = $role->id;
                    $user->downgrade_date = null;
                    $user->downgrade_role_id = null;
                    $user->save();
                    printf("Downgraded user %d to %s", $user->id, $role->name);
                } catch (Exception $e) {
                    printf("Error downgrading user %d: %s\n", $user->id, $e->getMessage());
                }
            }
        } else {
            print "No users to downgrade";
        }
    }    
}