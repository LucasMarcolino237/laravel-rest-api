<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLogsController extends Controller
{
    public function index()
    {
        return response()->json(['msg' => 'Index de UsersLogs foi encontrado!']);
    }

    public function show()
    {
        return response()->json(['msg' => 'Show de UsersLogs foi encontrado!']);
    }
}
