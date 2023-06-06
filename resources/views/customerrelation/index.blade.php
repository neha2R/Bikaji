@extends('customerrelation.layout.app')
@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Register a Ticket</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="http://127.0.0.1:8001/frontoffice/createcomplaint" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="GJChplboTfIfNkABqUpXmD2I7HgXhbtdOEwCCAF6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-10">
                                    <select name="ct" class="form-control">
                                        <option value="11">Complaint</option>
                                        <option value="12">Enquiry</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Customer Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="customername" placeholder="Customer Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Mobile Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="mobile" placeholder="Mobile Number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Complaint Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" placeholder="Complaint Title">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Details</label>
                                <div class="col-sm-10">
                                    <textarea rows="5" cols="5" class="form-control" name="details" placeholder="Details"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Upload File</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="file">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Complaint Department</label>
                                <div class="col-sm-10">
                                    <select name="ct" class="form-control">
                                        <option value="11">Production</option>
                                        <option value="12">Managment</option>
                                        <option value="13">IT</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-primary">Create Complaint</button>
                
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
   
    <div class="col-md-5">
        <div class="card"> 
            <div class="card-header">
                <h4>Track Your Ticket</h4>
            </div>
            <div class="card-body">
                <div class="row ">
                    <div class="col-lg-12  col-sm-12 col-xs-12">
                        <div class="input-group input-group-button input-group-primary">
                            <input type="text" class="form-control" placeholder="Search here...">
                            <button class="btn btn-primary input-group-addon">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection
