@extends('layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">product</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">product</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Blank</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">product</h4>
                        <a href="/products/create"><button type="button" class="btn btn-primary">create</button></a>
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
                                        @if (auth()->user()->role == 1)
                                        <th>store name</th>
                                        @endif
                                        <th>categories name</th>
                                        <th>product name</th>
                                        @if (auth()->user()->role == 1)
                                        <th>store type</th>
                                        @endif
                                        <th>description</th>
                                        <th>price</th>
                                        <th>discount_price</th>
                                        <th>capacity</th>
                                        <th>available_qty</th>
                                        <th>deliverable</th>
                                        <th>image</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        @if (auth()->user()->role == 1)
                                        <td>{{$d->store_name}}</td>
                                        @endif
                                        <td>{{$d->categorie_name}}</td>
                                        <td>{{$d->name}}</td>
                                        @if (auth()->user()->role == 1)
                                        <td>{{$d->store_type}}</td>
                                        @endif
                                        <td>{{$d->description}}</td>
                                        <td>{{$d->price}}</td>
                                        <td>{{$d->discount_price}}</td>
                                        <td>{{$d->capacity}}</td>
                                        <td>{{$d->available_qty}}</td>
                                        <td>{{$d->deliverable}}</td>
                                        <td>{{$d->image}}</td>
                                        <td>
                                            <a href="/products/{{$d->id}}/edit"><button type="button" class="btn btn-primary btn-xs">Edit</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        @if (auth()->user()->role == 1)
                                        <th>store name</th>
                                        @endif
                                        <th>categories name</th>
                                        <th>product name</th>
                                        @if (auth()->user()->role == 1)
                                        <th>store type</th>
                                        @endif
                                        <th>description</th>
                                        <th>price</th>
                                        <th>discount_price</th>
                                        <th>capacity</th>
                                        <th>available_qty</th>
                                        <th>deliverable</th>
                                        <th>image</th>
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
