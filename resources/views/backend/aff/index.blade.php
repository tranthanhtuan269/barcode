@extends('backend.master')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 main-content">
                <div class="panel panel-default">
                    <div class="panel-heading font-weight-bold text-uppercase"><h3><strong>Affiliate </strong></h3></div>
                    <div class="panel-body">
                        <div class="addAndSearch">
                            <div class="clearfix">
                                <a href="{{ url('/admincp/affs/create') }}" class="btn btn-success btn-sm" title="Add New Post">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add new
                                </a>
                            </div>
                            {!! Form::open(['method' => 'GET', 'url' => '/admincp/affs', 'class' => 'searchForm clearfix navbar-right', 'role' => 'search'])  !!}
                            <div class="input-group clearfix">
                                <input type="text" class="form-control" name="search" placeholder="Search ..." value="{{ Request::input('search') }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <br/>
                        <br/>
                        <div class="table-responsive infoTable">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-custom">
                                    <tr>
                                        <th>#</th>
                                        <th>Slug</th>
                                        <th>Name</th>
                                        <th>Current</th>
                                        <th>Today</th>
                                        <th>This Month</th>
                                        <th>This Year</th>
                                        <th>Created At</th>
                                        <th style="width: 15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                <?php 
                                  if( !isset($_GET['page']) || $_GET['page']==1 ){
                                    $stt = 1;
                                  }else{
                                    $stt = ( ($_GET['page'] - 1) * $affs->perPage() ) + 1;
                                  }
                                ?>
                                @foreach($affs as $item)
                                    <tr>
                                        <td>{{ $stt }}</td>
                                        <td class="text-left">
                                            <a href="{{ url('/admincp/affs/' . $item->id) }}" title="Edit province">{{ $item->slug }}</a>
                                        </td>
                                        <td class="text-left">
                                            {{ $item->name }}
                                        </td>
                                        <td class="text-left">
                                            {{ $item->last_hour }}
                                        </td>
                                        <td class="text-left">
                                            {{ $item->last_day }}
                                        </td>
                                        <td class="text-left">
                                            {{ $item->last_month }}
                                        </td>
                                        <td class="text-left">
                                            {{ $item->last_year }}
                                        </td>
                                        <td class="text-left">
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm create-link" data-slug="{{ $item->slug }}"><i class="fa fa-eye" aria-hidden="true"></i> Create Link</button>
                                            <a href="{{ url('/admincp/affs/' . $item->id . '/edit') }}" title="Edit province"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            <form method="POST" action="{{ url('/admincp/affs/'.$item->id) }}" accept-charset="UTF-8" id="confirm-delete-{{ $item->id }}" style="display:inline">
                                                <input type="hidden" name="_method" value="delete" />
                                                {!! csrf_field() !!}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Post"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php $stt++; ?>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $affs->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.create-link').click(function(){
                $('#create-link-modal').modal('toggle')
                $('#generate-btn').data('slug', $(this).data('slug'))
            })

            $('#generate-btn').click(function(){

                const url = new URL($('#link-txt').val());
                if (url.search) {
                  console.log("The link has parameters.");
                  $('#generated').html($('#link-txt').val()+ '&aff='+$(this).data('slug'))
                } else {
                  console.log("The link has no parameters.");
                  $('#generated').html($('#link-txt').val()+ '?aff='+$(this).data('slug'))
                }
                
            })
        })
    </script>

    <div class="modal" tabindex="-1" role="dialog" id="create-link-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Get Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Link</label>
                            <input type="text" class="form-control" id="link-txt" aria-describedby="emailHelp" placeholder="Enter link">
                            <small id="generated" class="form-text">We'll never share your email with anyone else.</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="generate-btn">Generate</button>
                </div>
            </div>
        </div>  
    </div>
@endsection
