<?php

class Downgrade_Task
{
    public function __construct()
    {
        Bundle::start('composer');
    }

    public function run($arguments)
    {
        print date("Y-m-d H:i:s") . " | Running downgrade\n";
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
                    printf("%s | Downgraded user %d to %s\n", date("Y-m-d H:i:s"), $user->id, $role->name);
                } catch (Exception $e) {
                    printf("%s | Error downgrading user %d: %s\n", date("Y-m-d H:i:s"), $user->id, $e->getMessage());
                }
            }
        } else {
            print date("Y-m-d H:i:s") . " | No users to downgrade\n";
        }
    }    
}