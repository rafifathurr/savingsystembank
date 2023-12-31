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
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <form id="form_add" action="{{route('type.'.$url)}}" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-11">
                                                    <label class="col-md-3">Type Transaction <span style="color: red;">*</span></label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="type" id="type" class="form-control" autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-11">
                                                    <label class="col-md-3">Debit / Credit <span style="color: red;">*</span></label>
                                                    <div class="col-md-10">
                                                        <select class="form-control" id="status" style="pointer-events:none;"
                                                            name="status" required>
                                                            <option value="" selected disabled hidden></option>
                                                            @foreach($status as $stat)
                                                                <option value="{{$stat->id}}">{{$stat->status_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="modal-footer">
                                                <div style="float:right;">
                                                    <div class="col-md-12" style="margin-right: 20px;">
                                                        <a href="{{ route('type.index')}}" type="button" class="btn btn-danger">
                                                            <i class="fa fa-arrow-left"></i>&nbsp;
                                                            Back
                                                        </a>
                                                        <button type="submit" class="btn btn-primary" style="margin-left:10px;">
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
    </body>
</html>
