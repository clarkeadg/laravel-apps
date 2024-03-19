<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TwitterUser;
use App\Models\VerifiedUser;

class TestQueriesController extends Controller
{

    public function getQuery(Request $request)
    {       
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        // $data = User::select('name')
        //     ->limit(10)
        //     ->get();
        
        // $data = DB::table('users')
        //     ->select('name', 'avatar')
        //     ->limit(10)
        //     ->get();
        
        $data = TwitterUser::limit(10)
            ->get();

        // $data = VerifiedUser::limit(10)
        //     ->get();

        return response()->json($data);
    }   
}
