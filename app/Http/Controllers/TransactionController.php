<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function comment(Request $request)
    {

        $order = Order::where('user_id', '=', Auth::id())
            ->where('date_range_id', '=', $request->date_range_id)->first();

        $transaction = Transaction::find($order->transaction_id);

        DB::beginTransaction();

        try {

            $transaction->comments = $request->comment;
            $transaction->save();
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

        DB::commit();

        Session::flash('alert-success', 'Successfully Commented');
        return redirect()->route('home');
    }
}
