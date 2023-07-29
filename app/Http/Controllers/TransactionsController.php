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

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $account_id = Customer::where('id_user', Auth::user()->id)->first();
        $data['title'] = "List of Transaction";
        $data['transaction'] = Transactions::with('member', 'status_name', 'type')
                            ->where('accountId', $account_id->accountId)
                            ->orderBy('transaction_date', 'asc')
                            ->get();
        return view('transaction.index', $data);
    }

    public function create(){

        $total_amount = 0;
        $nasabah = Customer::where('id_user', Auth::user()->id)
                ->first();
        $all_transacts = Transactions::where('accountId', $nasabah->accountId)->get();

        foreach($all_transacts as $transacts){
            if($transacts->status == 1){
                $total_amount += $transacts->amount;
            }else{
                $total_amount -= $transacts->amount;
            }

            if($transacts->transfer_to == $nasabah->accountId){
                $total_amount += $transacts->amount;
            }
        }

        $data['title'] = "Add Transaction";
        $data['url'] = "store";
        $data['nasabah'] = $nasabah;
        $data['total_amount'] = $total_amount;
        $data['customer'] = Customer::where('deleted_at', null)
                        ->orderBy('name', 'asc')
                        ->get();
        $data['type'] = Type::where('deleted_at',null)
                    ->orderBy('id', 'asc')
                    ->get();
        $data['status'] = Status::orderBy('id', 'asc')
                        ->get();

        // GENERATE RANDOM NUMBER
        $id_check = mt_rand();
        $check = Transactions::where('id', $id_check)
                ->first();

        // CHECK NUMBER EXIST
        if($check){
            $data['transactions_id'] = mt_rand();
        }else{
            $data['transactions_id'] = $id_check;
        }

        return view('transaction.create', $data);
    }

    public function getStatus(Request $req){
        $type = Type::where('id', $req->type)->first();
        $status = Status::where('id', $type->status)->first();
        return $status->id;
    }

    public function store(Request $req){
        $date = date('Y-m-d');
        $datenow = date('Y-m-d H:i:s');

        $status = Type::where('id', $req->type)->first();

        if($req->type == 7){
            $exec = Transactions::create([
                'id' => $req->transactions_id,
                'accountId' => $req->account_id,
                'transaction_date' => $date,
                'type_transaction' => $req->type,
                'transfer_to' => $req->transferto,
                'status' => $status->status,
                'amount' => $req->amount,
                'created_at' => $datenow
            ]);
        }else{
            $exec = Transactions::create([
                'id' => $req->transactions_id,
                'accountId' => $req->account_id,
                'transaction_date' => $date,
                'type_transaction' => $req->type,
                'status' => $status->status,
                'amount' => $req->amount,
                'created_at' => $datenow
            ]);
        }

        if($exec){
            return redirect()->route('transactions.index')->with(["success" => "Transaction Success!"]);
        }else{
            return redirect()->back()->with(["error" => "Failed!"]);
        }

    }

    public function report(){
        $nasabah = Customer::where('id_user', Auth::user()->id)
                ->first();
        $data['title'] = "History";
        $data['nasabah'] = Customer::where('id_user', Auth::user()->id)->first();
        $data['tgl_awal'] = Transactions::with('member', 'status_name', 'type')
                        ->where('accountId', $nasabah->accountId)
                        ->orderBy('transaction_date', 'asc')
                        ->first();
        return view('report.index', $data);
    }

    public function scopeReport(Request $req){

        $transaction = Transactions::with('member', 'status_name', 'type')
                    ->where('accountId', $req->account_id)
                    ->orderBy('transaction_date', 'desc')
                    ->get();

        return Datatables::of($transaction)
        ->addIndexColumn()
        ->addColumn('date_time', function ($data) {
            return '<center>'.date('H:i:s', strtotime($data->created_at)).'</center>';
        })
        ->addColumn('credit', function ($data) {
            if($data->status == 1){
                return '<div style="text-align:right;"> Rp. '.number_format($data->amount,0,',','.').',-</div>';
            }else{
                return '<div style="text-align:right;">-</div>';
            }
        })
        ->addColumn('debit', function ($data) {
            if($data->status == 2){
                return '<div style="text-align:right;"> Rp. '.number_format($data->amount,0,',','.').',-</div>';
            }else{
                return '<div style="text-align:right;">-</div>';
            }
        })
        ->addColumn('amount', function ($data) {
            if($data->status == 1){
                return '<div style="text-align:right;color:green;"> + Rp. '.number_format($data->amount,0,',','.').',-</div>';
            }else{
                return '<div style="text-align:right;color:red;"> - Rp. '.number_format($data->amount,0,',','.').',-</div>';
            }
        })
        ->rawColumns(['date_time', 'credit', 'debit', 'amount'])
        ->make(true);
    }

    public function income(){
        $data['title'] = "List of Income";
        $data['nasabah'] = Customer::where('id_user', Auth::user()->id)->first();
        return view('report.income', $data);
    }

    public function scopeIncome(Request $req){

        $month_now = date('m');
        $transaction = Transactions::with('member', 'status_name', 'type')
                    ->where('accountId', $req->account_id)
                    ->where('status', 1)
                    ->whereMonth('transaction_date', $month_now)
                    ->orderBy('transaction_date', 'desc');

        $transaction_2 = Transactions::with('member', 'status_name', 'type')
                    ->where('transfer_to', $req->account_id)
                    ->where('status', 2)
                    ->whereMonth('transaction_date', $month_now)
                    ->orderBy('transaction_date', 'desc')
                    ->union($transaction)
                    ->get();

        return Datatables::of($transaction_2)
        ->addIndexColumn()
        ->addColumn('date_time', function ($data) {
            return '<center>'.date('H:i:s', strtotime($data->created_at)).'</center>';
        })
        ->addColumn('amount', function ($data) {
            return '<div style="text-align:right;color:green;"> + Rp. '.number_format($data->amount,0,',','.').',-</div>';
        })
        ->rawColumns(['date_time', 'amount'])
        ->make(true);
    }

    public function outcome(){
        $data['title'] = "List of Outcome";
        $data['nasabah'] = Customer::where('id_user', Auth::user()->id)->first();
        return view('report.outcome', $data);
    }

    public function scopeOutcome(Request $req){

        $month_now = date('m');
        $transaction = Transactions::with('member', 'status_name', 'type')
                    ->where('accountId', $req->account_id)
                    ->where('status', 2)
                    ->whereMonth('transaction_date', $month_now)
                    ->orderBy('transaction_date', 'desc');

        $transaction_2 = Transactions::with('member', 'status_name', 'type')
                    ->where('transfer_to', $req->account_id)
                    ->where('status', 1)
                    ->whereMonth('transaction_date', $month_now)
                    ->orderBy('transaction_date', 'desc')
                    ->union($transaction)
                    ->get();

        return Datatables::of($transaction)
        ->addIndexColumn()
        ->addColumn('date_time', function ($data) {
            return '<center>'.date('H:i:s', strtotime($data->created_at)).'</center>';
        })
        ->addColumn('amount', function ($data) {
            return '<div style="text-align:right;color:red;"> - Rp. '.number_format($data->amount,0,',','.').',-</div>';
        })
        ->rawColumns(['date_time', 'amount'])
        ->make(true);
    }
}
