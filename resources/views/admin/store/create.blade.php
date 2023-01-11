@extends('layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">Your business dashboard template</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">store</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">create</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">store create</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/stores" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>store Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="1234 Main St">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>users</label>
                                        <select id="inputState" name="user_id" class="form-control">
                                            <option selected="">Choose...</option>
                                            @foreach ($data['user'] as $u)
                                                <option value="{{$u->id}}">{{$u->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>image</label>
                                        <input type="file" name="image" class="form-control" placeholder="file">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>free delivery</label>
                                        <select id="inputState" name="free_delivery" class="form-control">
                                            <option selected="">Choose...</option>
                                            <option value="1">yes</option>
                                            <option value="0" >no</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>description</label>
                                        <input type="text" class="form-control" name="description" placeholder="address">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label>address</label>
                                        <input type="text" class="form-control" name="address" placeholder="address">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Zip</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>location</label>
                                        <input type="text" class="form-control" name="location" placeholder="address">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>delivery prize</label>
                                        <input type="text" name="delivery_prize" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>delivery time</label>
                                        <input type="text" name="delivery_time" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>teg</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" name="teg1" id="" class="form-control" placeholder="teg 1">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="teg2" id="" class="form-control" placeholder="teg 2">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="teg3" id="" class="form-control" placeholder="teg 3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
