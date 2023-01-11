@extends('layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">store</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">stores</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Blank</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">store</h4>
                        <a href="/stores/create"><button type="button" class="btn btn-primary">create</button></a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>user name</th>
                                        <th>store name</th>
                                        <th>vendor type</th>
                                        <th>image</th>
                                        <th>description</th>
                                        <th>free_delivery</th>
                                        <th>address</th>
                                        <th>zip_code</th>
                                        <th>delivery_prize</th>
                                        <th>delivery_time</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{$d->user_name}}</td>
                                            <td>{{$d->name}}</td>
                                            <td>{{$d->user_role}}</td>
                                            <td>{{$d->image}}</td>
                                            <td>{{$d->description}}</td>
                                            <td>{{$d->free_delivery}}</td>
                                            <td>{{$d->address}}</td>
                                            <td>{{$d->zip_code}}</td>
                                            <td>{{$d->delivery_prize}}</td>
                                            <td>{{$d->delivery_time}}</td>
                                            <td>
                                                <a href="/stores/{{$d->id}}/edit"><button type="button" class="btn btn-primary btn-xs">Edit</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>user name</th>
                                        <th>store name</th>
                                        <th>vendor type</th>
                                        <th>image</th>
                                        <th>description</th>
                                        <th>free_delivery</th>
                                        <th>address</th>
                                        <th>zip_code</th>
                                        <th>delivery_prize</th>
                                        <th>delivery_time</th>
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
