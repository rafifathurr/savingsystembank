<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
    <style>
        .table-bordered th{
            vertical-align: middle !important;
        }
    </style>
    <body id="page-top">
        <div id="wrapper">
            @include('layouts.sidebar')
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    @include('layouts.navbar')
                    <div class="container-fluid">
                        <h1 class="h3 mb-2 text-gray-800">{{$title}}</h1>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{route('transactions.create')}}" class="btn btn-success">
                                            <i class="fa fa-plus"></i>
                                            Add Transaction
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th width="20%"><center>Transaction ID</center></th>
                                                <th width="10%"><center>Date</center></th>
                                                <th width="10%"><center>Time</center></th>
                                                <th width="10%"><center>Type</center></th>
                                                <th width="10%"><center>Transfer To</center></th>
                                                <th width="5%"><center>Debit/Credit</center></th>
                                                <th width="20%"><center>Amount</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($transaction as $transacts)
                                            <tr>
                                                <td><center>{{$transacts->id}}</center></td>
                                                <td><center>{{$transacts->transaction_date}}</center></td>
                                                <td><center>{{ date('H:i:s', strtotime($transacts->created_at))}}</center></td>
                                                <td><center>{{$transacts->type->type_transaction}}</center></td>
                                                <td><center>
                                                    @isset($transacts->transfer_to)
                                                        {{$transacts->transfer_to}}
                                                    @else
                                                        -
                                                    @endisset
                                                </center></td>
                                                <td><center>{{$transacts->status_name->status_name}}</center></td>
                                                <td style="text-align:right;">Rp. {{number_format($transacts->amount,0,',','.')}},-</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.scripts')
        @include('layouts.swal')
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    order: [[1, 'desc'],
                            [2, 'desc']],
                });
            });
        </script>
    </body>
</html>
