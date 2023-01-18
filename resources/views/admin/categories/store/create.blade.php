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
                        <h4 class="card-title">categories create</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/store/categories" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>categorie name</label>
                                        <input type="text" class="form-control" name="name" placeholder="categories">
                                    </div>
                                    @if (auth()->user()->role == 1)
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
                                        <label>store</label>
                                        <select id="store_id" class="form-control" name="store_id">
                                            <option selected="">Choose...</option>
                                        </select>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>active</label>
                                        <select id="inputState" class="form-control" name="is_active">
                                            <option>Choose...</option>
                                            <option value="1">yes</option>
                                            <option value="0">no</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>in oder</label>
                                        <input type="text" name="oder" class="form-control">
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
    })
});
</script>
@endsection
