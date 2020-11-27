<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserLogs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_logs = UserLogs::paginate(5);

        return response()->json([
            'msg' => 'Index de UsersLogs foi encontrado!',
            'data' => [
                'user_logs' => $user_logs,
            ]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $user_logs = UserLogs::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(5);
        
        return response()->json([
            'msg' => 'Show de UsersLogs foi encontrado!',
            'data' => [
                'user_logs' => $user_logs,
            ]]);
    }
}
