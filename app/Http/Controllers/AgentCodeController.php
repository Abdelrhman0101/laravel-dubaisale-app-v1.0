<?php

namespace App\Http\Controllers;

use App\Models\AgentCode;
use Illuminate\Http\Request;

class AgentCodeController extends Controller
{

    public function index(){
        $agentCodes = AgentCode::with('user')->get();
        return response()->json($agentCodes);
    }
    public function store(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            // 'clients' => 'nullable|array',
        ]);

        $agentCode = AgentCode::create($request->all());

        return response()->json($agentCode, 201);
    }
}
