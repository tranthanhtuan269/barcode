@extends('backend.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 main-content">
                <div class="panel panel-default">
                    <div class="panel-heading font-weight-bold text-uppercase"><h3><strong>Create new Aff</strong></h3></div>
                    <div class="panel-body">
                        <script src="{{ url('/') }}/templateEditor/ckeditor/ckeditor.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.15/js/jquery.Jcrop.min.js"></script>
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.15/css/jquery.Jcrop.min.css" type="text/css" />
                        <script src="https://gospeedcheck.com/backend/js/moment.min.js"></script>
                        <script src="https://gospeedcheck.com/backend/js/bootstrap-datetimepicker.min.js"></script>
                        <div class="card-body">
                            <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><h4><strong>CONTENT</strong></h4></li>
                            </ol>
                            </nav>
                            <div class="form-group clearfix">
                                {!! Form::label('slug', 'Slug', ['class' => 'col-md-1 control-label font-weight-600']) !!}
                                <div class="col-md-10">
                                    {!! Form::text('slug', old('slug', isset($data->slug) ? $data->slug : ''), ['class' => 'form-control']) !!}
                                <p class="alert-errors" id="slug-error" role="alert" style="display: none;"></p>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('name', 'Name', ['class' => 'col-md-1 control-label font-weight-600']) !!}
                                <div class="col-md-10">
                                    {!! Form::text('name', old('name', isset($data->name) ? $data->name : ''), ['class' => 'form-control']) !!}
                                <p class="alert-errors" id="name-error" role="alert" style="display: none;"></p>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary" id="save-change" data-action="@if(\Request::is('admincp/affs/create'))create @endif">Save</button>
                                </div>
                            </div> 
                        </div>
                        <script>
                            $(document).ready(function(){
                                $('#save-change').click(function(){
                                    url = baseURL + '/admincp/affs';
                                    var method = "POST";
                                    if ($(this).attr('data-action') != 'create ') {
                                        url += '/{{ Request::route("affs") }}';
                                        method = "PUT";
                                    }  

                                    var data    = {
                                        _method           : method,
                                        slug: $('input[name=slug]').val().trim(),
                                        name : $('input[name=name]').val(),
                                    };

                                    $.ajaxSetup({
                                        headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: data,
                                        dataType: 'json',
                                        beforeSend: function() {
                                            $('.alert-errors').hide();
                                        },
                                        complete: function(data) {
                                            if(data.responseJSON.status == 200){
                                                $().toastmessage('showSuccessToast', data.responseJSON.Message);
                                            }else{
                                                if(data.status == 422){
                                                    $.each(data.responseJSON.errors, function( index, value ) {
                                                        $('#' + index + '-error').show();
                                                        $('#' + index + '-error').html(value);
                                                    });
                                                    $().toastmessage('showErrorToast', 'Errors');
                                                }else{
                                                    if(data.status == 401){
                                                    window.location.replace(baseURL);
                                                    }else{
                                                    $().toastmessage('showErrorToast', errorConnect);
                                                    }
                                                }
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
