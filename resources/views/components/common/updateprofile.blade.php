
<div class="row">
    <div class="row">
        <div class="col-lg-12">
            <div class="cover-profile">
                <div class="profile-bg-img">
                    <!-- <img class="profile-bg-img img-fluid" src="..\files\assets\images\user-profile\bg-img1.jpg" alt="bg-img"> -->
                    <section style="width: 1012px;height: 100%;float: none;margin-top: 135px;"></section>
                    <div class="card-block user-info" style="    background-color: #404e67;">
                        <div class="col-md-12">
                        <div class="media-left">
                            @if (auth()->user()->profileimage)
                                       @php  $image = auth()->user()->profileimage  @endphp
                                    @else
                                        @php  $image = 'profile.png' @endphp
                                        @endif
                                <a href="#" class="profile-image">
                                    <img class="user-img img-radius" style="height: 113px;" src="{{\Storage::disk('public')->url($image)}}" alt="user-img" >
                                </a>
                            </div>
                            <div class="media-body row">
                                <div class="col-lg-12">
                                    <div class="user-title">
                                        <h2>{{auth()->user()->name}}</h2>
                                        {{-- <span class="text-white">Web designer</span> --}}
                                    </div>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--profile cover end-->
    <div class="col-xl-12 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <h5>Profile Details</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                        <li><i class="fa fa-window-maximize full-card"></i></li>
                        <li><i class="fa fa-minus minimize-card"></i></li>
                        <li><i class="fa fa-refresh reload-card"></i></li>
                        <li><i class="fa fa-trash close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label class="label label-success">Name</label></td>
                                <td>{{auth()->user()->name}}</td>
                            </tr>
                            <tr>
                                <td><label class="label label-success">Email</label></td>
                                <td>{{auth()->user()->email}}</td>
                            </tr>
                            <tr>
                                <td><label class="label label-primary">Mobile</label></td>
                                <td>{{auth()->user()->mobile}}</td>
                            </tr>
                            <tr>
                                <td><label class="label label-danger">Role</label></td>
                                <td>{{auth()->user()->role}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center m-r-20">
                        {{-- <a href="#!" class=" b-b-primary text-primary">View all Projects</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Update Profile</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                        <li><i class="fa fa-window-maximize full-card"></i></li>
                        <li><i class="fa fa-minus minimize-card"></i></li>
                        <li><i class="fa fa-refresh reload-card"></i></li>
                        <li><i class="fa fa-trash close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif
            <form method="POST" id="form" action="{{route('adminupdateprofile')}}" enctype="multipart/form-data">
                @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Avtaar Upload</label>
                        <div class="col-sm-10">
                            <input type="file" id="image-file" name="file"  accept="image/png, image/jpeg"  >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control text"  maxlength="50" name="name" value="{{auth()->user()->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" maxlength="50" value="{{auth()->user()->email}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="mobile" id="mobile" value="{{auth()->user()->mobile}}">
                        </div>
                    </div>
                    <button type="submit"  class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
