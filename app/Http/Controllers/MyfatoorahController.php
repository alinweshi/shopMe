<?php

namespace App\Http\Controllers;

use App\Services\MyFatoorahService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyfatoorahController extends Controller
{
    private $myfatoorahService;
    public function __construct(MyFatoorahService $myfatoorahService)
    {
        $this->myfatoorahService = $myfatoorahService;
    }
    public function pay(Request $request)
    {
        DB::beginTransaction();

        try {
            // Process payment with MyFatoorah
            $data = $request->all();
            $response = $this->myfatoorahService->sendPayment($data);

            DB::commit();

            return response()->json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeTransaction(Request $request)
    {

        try {
            DB::beginTransaction();
            // Store transaction data
            $this->myfatoorahService->saveTransactionData($request);
            DB::commit();
            return response()->json(['success' => 'payment is successful'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            // return $e->getMessage();
            return response()->json(['error ' => 'An unexpected error occurred while processing your request. Please try again later.
            '], 500);
        }
    }

    public function error(Request $request)
    {
        DB::beginTransaction();

        try {
            // Process error and store transaction data
            $this->myfatoorahService->saveTransactionData($request);
            DB::commit();
            return response()->json(['error ' => 'An unexpected error occurred while processing your request. Please try again later.
            '], 500);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error ' => 'An unexpected error occurred while processing your request. Please try again later.
            '], 500);
        }
    }
}
