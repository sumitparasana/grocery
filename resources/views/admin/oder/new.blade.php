@extends('layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">

            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">oder</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">main</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">oders</h4>
                        {{-- <a href="/users/create"><button type="button" class="btn btn-primary">create</button></a> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>oder id</th>
                                        <th>booking date</th>
                                        <th>amount</th>
                                        <th>user name</th>
                                        <th>delvery address</th>
                                        <th>image</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>2011/04/25</td>
                                        <td>
                                            <a href="/oder/detail"><button type="button" class="btn btn-info btn-xs">detail</button></a>
                                            <button type="button" class="btn btn-primary btn-xs">Accept</button>
                                            <button type="button" class="btn btn-danger btn-xs">Reject</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>63</td>
                                        <td>63</td>
                                        <td>2011/07/25</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs">detail</button>
                                            <button type="button" class="btn btn-primary btn-xs">Accept</button>
                                            <button type="button" class="btn btn-danger btn-xs">Reject</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ashton Cox</td>
                                        <td>Junior Technical Author</td>
                                        <td>San Francisco</td>
                                        <td>San Francisco</td>
                                        <td>66</td>
                                        <td>2009/01/12</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs">detail</button>
                                            <button type="button" class="btn btn-primary btn-xs">Accept</button>
                                            <button type="button" class="btn btn-danger btn-xs">Reject</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>oder id</th>
                                        <th>booking date</th>
                                        <th>amount</th>
                                        <th>user name</th>
                                        <th>delvery address</th>
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
