@extends('layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">

            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">oder</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">main</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">oders on going</h4>
                        {{-- <a href="/users/create"><button type="button" class="btn btn-primary">create</button></a> --}}
                    </div>
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-primary solid">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger  solid">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>oder id</th>
                                        <th>booking date</th>
                                        <th>amount</th>
                                        <th>user name</th>
                                        <th>delvery address</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{$d->id}}</td>
                                            <td>{{$d->creation_date}}</td>
                                            <td>{{$d->amount}}</td>
                                            <td>{{$d->user_name}}</td>
                                            <td>{{$d->address}}</td>
                                            <td>
                                                <a href="/oder/detail/{{$d->id}}"><button type="button" class="btn btn-info btn-xs">detail</button></a>
                                                {{-- <a href="/oder/{{$d->id}}/changeStatus?status=7"><button type="button" class="btn btn-primary btn-xs">change status</button></a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>oder id</th>
                                        <th>booking date</th>
                                        <th>amount</th>
                                        <th>user name</th>
                                        <th>delvery address</th>
                                        <th>action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        Card footer
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
