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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">categories</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">create</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">product categories create</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="basic-form">
                            <form action="/product/categories" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>categorie name</label>
                                        <input type="text" class="form-control" name="name" placeholder="categories">
                                    </div>
                                    @if (auth()->user()->role == 1)
                                    <div class="form-group col-md-4">
                                        <label>store</label>
                                        <select id="store_id" name="store_id" class="form-control">
                                            <option >Choose...</option>
                                            @foreach ($data['store'] as $s)
                                                <option value="{{$s->id}}">{{$s->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>product name</label>
                                        <select id="product_id" name="product_id" class="form-control">
                                            <option selected="">Choose...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>price</label>
                                        <input type="text" name="price" class="form-control">
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
    $('#store_id').change(function () {
        var store_id = $(this).val();
        console.log(store_id);
        $.ajax({
            type: "get",
            url: "/store/"+store_id+"/getProduct",
            data: "data",
            success: function (response) {
                var html = '';
                $.each(response, function (k, v) {
                    html += '<option value="'+v.id+'">'+v.name+'</option>';
                });
                $('#product_id').html(html);
            }
        });
    });
});
</script>
@endsection
