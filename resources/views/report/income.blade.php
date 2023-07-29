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
                        <input type="hidden" id="accountid" value="{{ $nasabah->accountId }}">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th><center>Date</center></th>
                                                    <th><center>Time</center></th>
                                                    <th><center>Type</center></th>
                                                    <th width="25%"><center>Amount</center></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
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

                let accountid = $('#accountid').val();
                var token = '{{csrf_token()}}';

                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    "ajax": {
                        "url": "{{ route('transactions.report.scopeIncome') }}",
                        "type": "POST",
                        "data": {
                            '_token': token,
                            'account_id': accountid
                        }
                    },
                    columns: [{
                            data: 'transaction_date',
                            name: 'transaction_date'
                        },
                        {
                            data: 'date_time',
                            name: 'date_time'
                        },
                        {
                            data: 'type.type_transaction',
                            name: 'type.type_transaction'
                        },
                        {
                            data: 'amount',
                            name: 'amount'
                        }
                    ],
                    order: [
                        [0, 'desc'],
                        [1, 'desc']
                    ],
                });
            });
        </script>
    </body>
</html>
