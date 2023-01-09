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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">product</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">create</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">product create</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>product name</label>
                                        <input type="text" class="form-control" placeholder="1234 Main St">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>store name</label>
                                        <select id="inputState" class="form-control">
                                            <option selected="">Choose...</option>
                                            <option>store 1</option>
                                            <option>store 2</option>
                                            <option>store 3</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>categories name</label>
                                        <select id="inputState" class="form-control">
                                            <option selected="">Choose...</option>
                                            <option>categories 1</option>
                                            <option>categories 2</option>
                                            <option>categories 3</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>image</label>
                                        <input type="file" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>price</label>
                                        <input type="text" class="form-control" placeholder="12">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>discount price</label>
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>capacity</label>
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>available qty</label>
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>deliverable</label>
                                        <select id="inputState" class="form-control">
                                            <option selected>yes</option>
                                            <option>no</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>description</label>
                                        <input type="text" class="form-control" placeholder="address">
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
