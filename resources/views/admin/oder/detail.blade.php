@extends('layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">

            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">oder </a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">detail</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Oder Detail</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 font-weight-bold">
                                <span>user name</span>
                            </div>
                            <div class="col-md-3">
                                <span>{{$data['oder']->user_name}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 font-weight-bold">
                                <span>delivery address</span>
                            </div>
                            <div class="col-md-3">
                                <span>{{$data['oder']->address}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 font-weight-bold">
                                <span>phone</span>
                            </div>
                            <div class="col-md-3">
                                <span>{{$data['oder']->delivery_phone}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 font-weight-bold">
                                <span>oder id</span>
                            </div>
                            <div class="col-md-3">
                                <span>{{$data['oder']->id}}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 font-weight-bold">
                                <span>oder date</span>
                            </div>
                            <div class="col-md-3">
                                <span>{{$data['oder']->creation_date}}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                @if($data['oder']->vendor_type_id == 3)
                                    <button type="button" class="btn btn-secondary">View prescription</button>
                                @endif
                                <button type="button" class="btn btn-secondary">add product</button>
                            </div>
                        </div>
                        <hr>
                        <h4 class="card-title">oder product</h4>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive-sm" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>product name</th>
                                            <th>qunty</th>
                                            <th>price</th>
                                            <th>image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['oder_product'] as $op)
                                            <tr>
                                                <th>{{$op->product_name}}</th>
                                                <th>{{$op->product_count}}</th>
                                                <th>{{$op->product_price}}</th>
                                                <th>{{$op->product_image}}</th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4 class="card-title">payment detail</h4>
                    <div class="row">
                        <div class="col-md-2">
                            <p>total</p>
                            <p>discount</p>
                            <p>grind total</p>
                        </div>
                        <div class="col-md-6">
                            <p>{{$data['total_price']}}/-</p>
                            <p>{{$data['product_discount']}}/-</p>
                            <p>{{$data['grant_total']}}/-</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="/oder/{{$data['oder']->id}}/changeStatus" method="get">
                            <label for="">chnage status</label>
                            <select name="status" id="" onchange="this.form.submit()">
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </form>
                        {{-- <button type="button" class="btn btn-secondary">change status</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
