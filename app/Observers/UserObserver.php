<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserLogs;

class UserObserver
{   
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user = User::find($user->id);

        $user_log['user_id'] = $user->id;
        $user_log['data_new'] = json_encode(explode(',', $user));

        UserLogs::create($user_log);
    }
    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $user = User::find($user->id);
        $data_old = UserLogs::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        
        $user_log['user_id'] = $user->id;
        $user_log['data_old'] = $data_old['data_new'];
        $user_log['data_new'] = json_encode(explode(',', $user));
        
        
        UserLogs::create($user_log);
    }
}
