<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index() {

        $transactions = Transactions::with('table')->whereDate('created_at',today())->orderBy('created_at','desc')->get();
    
        return view('activity.index',compact('transactions'));
    }

    public function history() {
        $transactions = Transactions::where('status','paid')->orderBy('created_at','desc')->get();
        return view('activity.history',compact('transactions'));
    }

    public function report() {
        return view('activity.report');
    }

    public function reportShow(String $date) {
        $transactions = Transactions::with('table','orderItem')->where('status','paid')->whereDate('paid_at',$date)->get();
        $reportSummary = array();
        $reportSummary['date'] = $date;
        $reportSummary['total_transactions'] = $transactions->count();
        // //Cost Price Count
        $reportSummary['total_cost_price'] = $transactions->sum(function($transaction) {
            return $transaction->orderItem->sum(function($orderItem) {
                if($orderItem->product) {
                    return $orderItem->qty * $orderItem->product->cost_price;
                } else {
                    return 0;
                }
                // return $orderItem->qty * $orderItem->product->cost_price;
            });
        });
        $reportSummary['operasional_cost'] = (50 / 100) * $reportSummary['total_cost_price'];
        $reportSummary['total_items'] = $transactions->sum(function($transaction) {
            return $transaction->orderItem->sum('qty');
        });
        $reportSummary['total_revenue'] = $transactions->sum('total');
        $reportSummary['laba_kotor'] = $reportSummary['total_revenue'] - $reportSummary['total_cost_price'];
        $reportSummary['laba_bersih'] = $reportSummary['laba_kotor'] - $reportSummary['operasional_cost'];

        //Discount and Tax Count
        $reportSummary['total_discount'] = $transactions->sum('discount');
        $reportSummary['total_tax'] = $transactions->sum('tax');

        // //Get all order item from transactions
        $reportSummary['items'] = array();
        foreach($transactions as $transaction) {
            foreach($transaction->orderItem as $orderItem) {
                $item = array();
                $item['product_id'] = $orderItem->product_id;
                $item['name'] = $orderItem->product_name;
                $item['qty'] = $orderItem->qty;

                $item['cost_price'] = $orderItem->product->cost_price ?? 0;
                $item['price'] = $orderItem->price;
                $cost_price = $orderItem->product->cost_price ?? 0;
                $item['cost_price_total'] = $orderItem->qty * $cost_price;
                $item['total'] = $orderItem->qty * $orderItem->price;
                $item['profit'] = $item['total'] - $item['cost_price_total'];
                if(isset($reportSummary['items'][$orderItem->product_id])) {
                    $reportSummary['items'][$orderItem->product_id]['qty'] += $orderItem->qty;
                    $reportSummary['items'][$orderItem->product_id]['total'] += $orderItem->qty * $orderItem->price;
                    $reportSummary['items'][$orderItem->product_id]['cost_price_total'] += $orderItem->qty * $orderItem->product->cost_price;
                    $reportSummary['items'][$orderItem->product_id]['profit'] += $item['profit'];
                } else {
                    $reportSummary['items'][$orderItem->product_id] = $item;
                }
            }
        }

        // //Get all payment method from transactions
        $reportSummary['payment_methods'] = array();
        foreach($transactions as $transaction) {
            $paymentMethod = $transaction->paid_method;
            if(isset($reportSummary['payment_methods'][$paymentMethod])) {  
                $reportSummary['payment_methods'][$paymentMethod]['total_transaction'] += 1;
                $reportSummary['payment_methods'][$paymentMethod]['total'] += $transaction->total;
            } else {
                $reportSummary['payment_methods'][$paymentMethod] = array();
                $reportSummary['payment_methods'][$paymentMethod]['total_transaction'] = 1;
                $reportSummary['payment_methods'][$paymentMethod]['total'] = $transaction->total;
            }
        }

        // //Get all order type from transactions
        $reportSummary['order_types'] = array();
        foreach($transactions as $transaction) {
            $orderType = $transaction->order_type;
            if(isset($reportSummary['order_types'][$orderType])) {  
                $reportSummary['order_types'][$orderType]['total_transaction'] += 1;
                $reportSummary['order_types'][$orderType]['total'] += $transaction->total;
            } else {
                $reportSummary['order_types'][$orderType] = array();
                $reportSummary['order_types'][$orderType]['total_transaction'] = 1;
                $reportSummary['order_types'][$orderType]['total'] = $transaction->total;
            }
        }

        return response()->json(['transaction' => $transactions, 'summary' => $reportSummary]);
    }
}
