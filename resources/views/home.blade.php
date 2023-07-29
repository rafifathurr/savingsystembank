<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
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
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4 v-center" >
                                                        <i class="fa fa-money-bill" style="font-size:50px;"></i>
                                                    </div>
                                                    <div class="col-md-8">
                                                    <div class="card-title"><h5><b>Current Balance</b></h5></div>
                                                        <div class="card-body">
                                                            <h4 style="text-align:right;" id="counter_all">
                                                                Rp. {{number_format($total_balance,0,',','.')}},-
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card" id="total_income">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4 v-center" >
                                                        <i class="fa fa-plus" style="font-size:50px;"></i>
                                                    </div>
                                                    <div class="col-md-8">
                                                    <div class="card-title"><h5><b>Total Income</b></h5></div>
                                                        <div class="card-body">
                                                            <h4 style="text-align:right;color:green;" id="counter_all">
                                                               + Rp. {{number_format($total_in,0,',','.')}},-
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card" id="total_outcome">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4 v-center" >
                                                        <i class="fa fa-minus" style="font-size:50px;"></i>
                                                    </div>
                                                    <div class="col-md-8">
                                                    <div class="card-title"><h5><b>Total Outcome</b></h5></div>
                                                        <div class="card-body">
                                                            <h4 style="text-align:right;color:red;" id="counter_all">
                                                               - Rp. {{number_format($total_out,0,',','.')}},-
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                $('#total_income').on('click', function(){
                    window.open('{{ route("transactions.report.income") }}')
                })
                $('#total_outcome').on('click', function(){
                    window.open('{{ route("transactions.report.outcome") }}')
                })
            });
        </script>
    </body>
</html>
