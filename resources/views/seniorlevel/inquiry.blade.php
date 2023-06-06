@extends('seniorlevel.layout.slevelapp')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <!-- Zero config.table start -->
        <div class="card">
            <div class="card-header">
                <h5>Inquiry</h5>
                {{-- <span>DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</span> --}}
            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap inquirytable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>C.No</th>
                                <th>Customer Name</th>
                                <th>Mob</th>
                                <th>Inquiry Details</th>
                                {{-- <th>Remaining Days</th> --}}
                                {{-- <th>Transfer</th> --}}
                                <th>Resolve</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            {{-- {{dd($item)}} --}}
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$item->inquiry->uuid ?? 'N/A'}}</td>
                                <td>{{$item->inquiry->customername ?? 'N/A'}}</td>
                                <td>{{$item->inquiry->contact ?? 'N/A'}}</td>
                                <th>{{$item->inquiry->details ?? 'N/A'}}</th>
                                {{-- <td>{{today()->diffInDays($item->created_at->addDays(7))}}</td> --}}
                                {{-- <td>
                                    <select class="js-example-basic-single col-sm-12 transferinquiry" id="{{$item->id}}">
                                        <option>Click to Select</option>
                                        @foreach ($departments as $department)
                                        <optgroup label="{{$department->name}}">
                                            @foreach ($department->users as $user)
                                            @if ($user->id != auth()->user()->id)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endif
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>

                                </td> --}}
                                <td>
                                    @if (inquirycheckifresolved(optional($item->inquiry)->id))
                                    Resolved
                                    @else
                                    <button type="button" class="btn btn-primary waves-effect inquiryresolvebtn"
                                        data-id="{{$item->inquiryid}}" data-fromuser="{{$item->fromuser}}" data-departmentid="{{$item->departmentid}}" data-toggle="modal" data-target="#resolve-Modal">
                                        Resolve
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Zero config.table end -->
    </div>
</div>

<div class="modal fade" id="resolve-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" action="{{ route('resolveinquiryslevel') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Resolution</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <input type="hidden" name="id" id="inquiryid">
                        <input type="hidden" name="fromuser" id="fromuser">
                        <input type="hidden" name="departmentid" id="departmentid">

                        <div class="form-group row">
                        <div class="form-group">
                                                <label>Document</label>
                                                    <input type="file" id="document" name="document"  required/>
                                                </div>
                            <label class="col-sm-3 col-form-label">Details of resolution</label>
                            <div class="col-sm-9">
                                <textarea rows="5" cols="5" class="form-control" name="resolution"
                                    id="resolution" minlength="140" required></textarea>
                            </div>
                        </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light submitinquiryresolution">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
