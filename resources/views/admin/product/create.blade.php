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
                            <form action="/products" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>product name</label>
                                        <input type="text" name="name" class="form-control" placeholder="1234 Main St">
                                    </div>
                                    @if(auth()->user()->role == 1)
                                    <div class="form-group col-md-4">
                                        <label>store type</label>
                                        <select id="vendor_id" name="vendor_type_id" class="form-control">
                                            <option selected="">Choose...</option>
                                            <option value="1">supar market</option>
                                            <option value="2">pharmacy</option>
                                            <option value="3" >restaurant</option>
                                        </select>
                                    </div>
                                        <div class="form-group col-md-4">
                                            <label>store name</label>
                                            <select id="store_id" name="store_id" class="form-control">
                                                <option>Choose...</option>
                                                {{-- @foreach ($data['stores'] as $s)
                                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    @endif
                                    <div class="form-group col-md-6">
                                        <label>categories name</label>
                                        <select id="categorie_id" name="categorie_id" class="form-control">
                                            <option selected="">Choose...</option>
                                            @foreach ($data['categories'] as $c)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>price</label>
                                        <input type="text" name="price" class="form-control" placeholder="12">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>discount price</label>
                                        <input type="text" name="discount_price" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>capacity</label>
                                        <input type="text" name="capacity" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>available qty</label>
                                        <input type="text" name="available_qty" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>deliverable</label>
                                        <select id="inputState" name="deliverable" class="form-control">
                                            <option value="1" selected>yes</option>
                                            <option value="0">no</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>description</label>
                                        <input type="text" name="description" class="form-control" placeholder="address">
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

@section('js')
<script>
$(document).ready(function () {
    $('#vendor_id').change(function () {
        var vendor_id = $(this).val();
        console.log(vendor_id);
        $.ajax({
            type: "get",
            url: "/vendor/"+vendor_id+"/getStore",
            data: "data",
            success: function (response) {
                var html = '';
                $.each(response, function (k, v) {
                    html += '<option value="'+v.id+'">'+v.name+'</option>';
                });
                $('#store_id').html(html);
            }
        });
    });

    $('#store_id').change(function () {
        var store_id = $(this).val();
        console.log(store_id);
        $.ajax({
            type: "get",
            url: "/store/"+store_id+"/getCategorie",
            data: "data",
            success: function (response) {
                var html = '';
                $.each(response, function (k, v) {
                    html += '<option value="'+v.id+'">'+v.name+'</option>';
                });
                $('#categorie_id').html(html);
            }
        });
    });
});
</script>
@endsection
