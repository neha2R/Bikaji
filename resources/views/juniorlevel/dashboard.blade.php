@extends('juniorlevel.layout.jlevelapp')
@section('content')

<div class="container row">
    <a class="col-xl-6 col-md-6" href="{{route('jdashboard')}}">
        <div class="card bg-c-pink text-white">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="m-b-5">Active Complaints</p>
                        <h4 class="m-b-0">{{$countactive}}</h4>
                    </div>
                    <div class="col col-auto text-right">
                        <i class="feather icon-user f-50 text-c-pink"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a class="col-xl-6 col-md-6" href="{{route('jdashboard',['type'=>'closed'])}}">
        <div class="card bg-c-green text-white">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="m-b-5">Resolved Complaints</p>
                        <h4 class="m-b-0">{{$countresolved}}</h4>
                    </div>
                    <div class="col col-auto text-right">
                        <i class="feather icon-user f-50 text-c-yellow"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>


<div class="row">
    <div class="col-sm-12">
        <!-- Zero config.table start -->
        <div class="card">
            <div class="card-header">
                <h5>Complaint</h5>
            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap complainttable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>C.No</th>
                                <th>Customer Name</th>
                                <th>Mob</th>
                                <th>Complaint Details</th>
                                <th>Created at</th>
                                <th>Remaining Days</th>
                                <th>Transfer</th>
                                <th>Resolve</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            {{-- {{dd($item)}} --}}
                            @if(!is_null($item->complaint))

                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$item->complaint->uuid ?? 'N/A'}}</td>
                                <td>{{$item->complaint->customername ?? 'N/A'}}</td>
                                <td>{{$item->complaint->mobile ?? 'N/A'}}</td>
                                <th>{{$item->complaint->details ?? 'N/A'}}</th>
                                <th>{{$item->complaint->created_at ?? 'N/A'}}</th>
                                <td>{{today()->diffInDays($item->created_at->addDays(7))}}</td>
                                <td>
                                    @if (checkifresolved(optional($item->complaint)->id))
                                        Resolved
                                    @else
                                    <select class="js-example-basic-single col-sm-12 onfff" id="{{$item->id}}">
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
                                    @endif
                                </td>
                                <td>
                                    @if (checkifresolved(optional($item->complaint)->id))
                                        Resolved
                                    @else

                                    <button type="button" class="btn btn-primary waves-effect complaintresolvebtn"
                                    data-id="{{$item->complaintid}}" data-fromuser="{{$item->fromuser}}"
                                    data-departmentid="{{$item->departmentid}}" data-toggle="modal"
                                    data-target="#resolve-Modal">
                                        Resolve
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endif
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
            <form method="POST" enctype="multipart/form-data" action="{{ route('resolvecomplaint') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Resolution</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <input type="hidden" name="id" id="complaintid">
                        <input type="hidden" name="fromuser" id="fromuser">
                        <input type="hidden" name="departmentid" id="departmentid">
                        <div class="form-group">
                                        <label>Document</label>
                                            <input style="margin-left: 130px;" type="file" id="document" name="document"  />
                                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Details of resolution</label>
                            <div class="col-sm-9">
                                <textarea rows="5" cols="5" class="form-control" name="resolution"
                                    id="resolution" minlength="140" required ></textarea>
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
