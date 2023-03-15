<?php

namespace App\Http\Controllers;

use App\Enums\ResultStatusEnum;
use App\Models\Result;
use Illuminate\Http\Request;

class ApiResultController extends Controller
{
    public function getLinksByStatus(Request $request)
    {
        $status = $request->input('status');
        $limit = $request->input('limit');

        if (is_null($status) || is_null($limit)) {
            return response()->json([
                'status' => 'false',
                'data' => [
                    'error' => 'status or limit not null'
                ]
            ]);
        }
        if (!in_array($status, ResultStatusEnum::getValues())) {
            return response()->json([
                'status' => 'false',
                'data' => [
                    'error' => 'status not exist'
                ]
            ]);
        }

        $results = Result::select('link')->where('status', $status)->limit($limit)->get();
        return response()->json([
            'status' => 'success',
            'data' => $results
        ]);
    }
}
