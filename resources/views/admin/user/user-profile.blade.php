@extends('layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">users</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">profile</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" placeholder="1234 Main St" value="{{auth()->user()->name}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email" value="{{auth()->user()->email}}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>phone</label>
                                        <input type="text" class="form-control" placeholder="phone" value="{{auth()->user()->phone}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>image</label>
                                        <input type="file" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>address</label>
                                        <input type="text" class="form-control" placeholder="address" value="{{auth()->user()->phone}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Business Name</label>
                                        <input type="test" class="form-control" placeholder="Business Name">
                                    </div>
                                </div>
                                <hr>
                                <h4 class="card-title">change password</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>password</label>
                                        <input type="password" class="form-control" placeholder="password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>re password</label>
                                        <input type="password" class="form-control" placeholder="re password">
                                    </div>
                                </div>
                                <hr>
                                <h4 class="card-title">bank detail</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>account Number</label>
                                        <input type="text" class="form-control" placeholder="account number">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>IFSC code</label>
                                        <input type="text" class="form-control" placeholder="IFSC code">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>account holder name</label>
                                        <input type="text" class="form-control" placeholder="account holder name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>bank address</label>
                                        <input type="text" class="form-control" placeholder="bank address">
                                    </div>
                                </div>

                                <hr>
                                <h4 class="card-title">KYC detail</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Upload GST Certificates</label>
                                        <input type="file" class="form-control" placeholder="account holder name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Upload adharcard</label>
                                        <input type="file" class="form-control" placeholder="bank address">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Upload other</label>
                                        <input type="file" class="form-control" placeholder="account holder name">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
