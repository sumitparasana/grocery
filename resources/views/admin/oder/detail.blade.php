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
                                <span>rutvik</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 font-weight-bold">
                                <span>delivery address</span>
                            </div>
                            <div class="col-md-3">
                                <span>Ett Tower 2, 7th Floor Noida sector 132 Uttar Pradesh</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 font-weight-bold">
                                <span>phone</span>
                            </div>
                            <div class="col-md-3">
                                <span>1234567890</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 font-weight-bold">
                                <span>oder id</span>
                            </div>
                            <div class="col-md-3">
                                <span>1234560</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 font-weight-bold">
                                <span>oder date</span>
                            </div>
                            <div class="col-md-3">
                                <span>31-01-2025</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-secondary">View prescription</button>
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
                                        <tr>
                                            <th>apply</th>
                                            <th>4</th>
                                            <th>20</th>
                                            <th>image</th>
                                        </tr>

                                        <tr>
                                            <th>orage</th>
                                            <th>2</th>
                                            <th>10</th>
                                            <th>image</th>
                                        </tr>

                                        <tr>
                                            <th>banana</th>
                                            <th>12</th>
                                            <th>50</th>
                                            <th>image</th>
                                        </tr>
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
                            <p>5000/-</p>
                            <p>500/-</p>
                            <p>4500/-</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary">change status</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
