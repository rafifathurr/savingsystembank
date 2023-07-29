<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Customer;
use App\Models\Points;
use App\Models\Status;
use App\Models\Type;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $month_now = date('m');
        $total_amount = 0;
        $total_in = 0;
        $total_out = 0;

        $nasabah = Customer::where('id_user', Auth::user()->id)
                ->first();
        $all_transacts = Transactions::where('accountId', $nasabah->accountId);
        $all_transacts_2 = Transactions::where('transfer_to', $nasabah->accountId)->where('status', 2)->union($all_transacts)->get();
        $mount_transacts = Transactions::where('accountId', $nasabah->accountId)
                        ->whereMonth('transaction_date', $month_now);
        $mount_transacts_2 = Transactions::where('accountId', $nasabah->accountId)
                        ->where('transfer_to', $nasabah->accountId)
                        ->where('status', 2)
                        ->whereMonth('transaction_date', $month_now)
                        ->union($mount_transacts)
                        ->get();


        foreach($all_transacts_2 as $transacts){
            if($transacts->status == 1){
                $total_amount += $transacts->amount;
            }else{
                if($transacts->transfer_to == $nasabah->accountId){
                    $total_amount += $transacts->amount;
                }else{
                    $total_amount -= $transacts->amount;
                }

            }


        }

        foreach($mount_transacts_2 as $transacts){
            if($transacts->status == 1){
                $total_in += $transacts->amount;
            }else{
                if($transacts->transfer_to == $nasabah->accountId){
                    $total_in += $transacts->amount;
                }else{
                    $total_out += $transacts->amount;
                }

            }
        }


        $data['title'] = "Home";
        $data['total_balance'] = $total_amount;
        $data['total_in'] = $total_in;
        $data['total_out'] = $total_out;
        return view('home', $data);
    }

}
