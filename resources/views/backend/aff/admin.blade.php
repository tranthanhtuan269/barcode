@extends('backend.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 main-content">
                <div class="panel panel-default">
                    <div class="panel-heading font-weight-bold text-uppercase"><h3><strong>Affiliate </strong></h3></div>
                    <div class="panel-body">
                        <div class="table-responsive infoTable">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-custom">
                                    <tr>
                                        <th>#</th>
                                        <th>Link</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                <?php 
                                  if( !isset($_GET['page']) || $_GET['page']==1 ){
                                    $stt = 1;
                                  }else{
                                    $stt = ( ($_GET['page'] - 1) * $requests->perPage() ) + 1;
                                  }
                                ?>
                                @foreach($requests as $item)
                                    <tr>
                                        <td>{{ $stt }}</td>
                                        <td class="text-left">
                                            {{ $item->link }}
                                        </td>
                                        <td class="text-left">
                                            {{ $item->created_at }}
                                        </td>
                                    </tr>
                                <?php $stt++; ?>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $requests->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
