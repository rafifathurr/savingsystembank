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
                    <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <form id="form_add" action="{{ route('transactions.' . $url) }}" method="post"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="transactions_id" value="{{ $transactions_id }}">
                                        <input type="hidden" name="account_id" value="{{ $nasabah->accountId }}">
                                        <input type="hidden" id="status">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-11">
                                                <label class="col-md-3">Jenis Transaksi <span
                                                        style="color: red;">*</span></label>
                                                <div class="col-md-10">
                                                    <select class="form-control" id="type"
                                                        onchange="jenis(this.value)" name="type" required>
                                                        <option value="" selected disabled hidden>- Pilih
                                                            Transaksi -</option>
                                                        @foreach ($type as $ty)
                                                            <option value="{{ $ty->id }}">
                                                                {{ $ty->type_transaction }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div id="transfer-section" style="display:none;">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-11">
                                                    <label class="col-md-3">Transfer To <span
                                                            style="color: red;">*</span></label>
                                                    <div class="col-md-10">
                                                        <select class="form-control" id="transferto" name="transferto">
                                                            <option value="" selected disabled hidden>- Pilih
                                                                Nasabah -</option>
                                                            @foreach ($customer as $cust)
                                                                @if ($nasabah->id_user != $cust->id_user)
                                                                    <option value="{{ $cust->accountId }}">
                                                                        {{ $cust->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-11">
                                                <label class="col-md-3">Amount (Rp.) <span
                                                        style="color: red;">*</span></label>
                                                <div class="col-md-10">
                                                    <input type="text" oninput="check(this.value)" name="amount" id="amount"
                                                        class="form-control numeric" autocomplete="off" required disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="alert" style="display:none">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-11">
                                                    <label class="col-md-12" style="color:red;"><b>Your Balance Limit!</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-11">
                                                <label class="col-md-12"><b>Your Balance</b><span
                                                        style="color: red;">*</span></label>
                                                <div class="col-md-10">
                                                    <input type="hidden" id="balance" value="{{ $total_amount }}">
                                                    <div class="form-control" style="text-align:right;">
                                                        <b>Rp. {{number_format($total_amount,0,',','.')}},-</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div id="note-section" style="display:none;">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-11">
                                                    <label class="col-md-3">Note <span
                                                            style="color: red;">*</span></label>
                                                    <div class="col-md-10">
                                                        <textarea class="form-control" name="note" id="note" cols="10" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="modal-footer">
                                            <div style="float:right;">
                                                <div class="col-md-12" style="margin-right: 20px;">
                                                    <a href="{{ route('transactions.index') }}" type="button"
                                                        class="btn btn-danger">
                                                        <i class="fa fa-arrow-left"></i>&nbsp;
                                                        Back
                                                    </a>
                                                    <button type="submit" id="submit" class="btn btn-primary"
                                                        style="margin-left:10px;" disabled>
                                                        <i class="fa fa-check"></i>&nbsp;
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.scripts')
    <script>
        $(document).ready(function() {
            var token = '{{csrf_token()}}';

            $('.numeric').inputmask({
                alias: "numeric",
                prefix: "Rp.",
                digits: 0,
                repeat: 20,
                digitsOptional: false,
                decimalProtect: true,
                groupSeparator: ".",
                placeholder: '0',
                radixPoint: ",",
                radixFocus: true,
                autoGroup: true,
                autoUnmask: false,
                clearMaskOnLostFocus: false,
                onBeforeMask: function(value, opts) {
                    return value;
                },
                removeMaskOnSubmit: true
            });

            jenis = function(val) {
                if (val == 7) {
                    document.getElementById("transfer-section").style.display = "block";
                    document.getElementById("transferto").attributes.required = "required";
                    document.getElementById("note-section").style.display = "block";
                } else {
                    document.getElementById("transfer-section").style.display = "none";
                    document.getElementById("transferto").attributes.required = "";
                    document.getElementById("note-section").style.display = "none";
                }

                document.getElementById("amount").disabled = false;
                document.getElementById("amount").value = "";

                $.ajax({
                    type: 'POST',
                    url: "{{ route('transactions.getStatus') }}",
                    data: {
                        '_token' : token,
                        'type' : val
                    },
                    success: function(data) {
                        $('#status').val(data);
                    }
                });
            }

            check = function(val){
                let amount = 0;
                let status = $('#status').val();
                let balance = $('#balance').val();

                val = val.split("Rp.").pop();
                val = val.split(".").join('');
                amount = parseInt(val);

                if(status==2){
                    if(balance < amount || balance < 50000){
                        $('#alert').css('display', 'block');
                        $('#submit').attr('disabled', 'disabled')
                    }else{

                        let result = balance - amount;

                        if(result < 50000){
                            $('#alert').css('display', 'block');
                            $('#submit').attr('disabled', 'disabled')
                        }else{

                            $('#submit').attr('disabled', 'disabled')
                            if(amount == 0){
                                $('#submit').attr('disabled', 'disabled')
                            }else{
                                $('#submit').attr('disabled', false)
                            }

                        }

                    }
                }else{
                    $('#submit').attr('disabled', false)
                }

            }
        })
    </script>
</body>

</html>
