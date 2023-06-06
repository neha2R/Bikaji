<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12">
        <div class="card">
            <div class="card-block tab-icon">
                <div class="col-lg-12 col-xl-12 col-md-12">
                    <div class="sub-title">Change Password</div>
                    <div class="card">
                        <div class="card-header">
                            <h5>Create New Password</h5>
                        </div>
                        <div class="card-block">
                            @if (session()->has('message'))
                            <div class="alert alert-danger" id="message">
                                {{session()->get('message')}}
                            </div>
                            @endif
                            @if (session()->has('msg'))
                            <div class="alert alert-success" id="msg">
                                {{session()->get('msg')}}
                            </div>
                            @endif
                        <form method="POST" action="{{route('userchangepassword')}}">
                            @csrf
                                
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Old Password</label>
                                    <div class="col-sm-7">
                                    <input type="password" name="oldpass" id="oldpass" placeholder="Enter old password" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-7">
                                    <input id="newpass" type="password" name="newpass" placeholder="Enter new password" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-7">
                                    <input id="confirmpass" type="password" name="conpass" placeholder="Enter new password again" required class="form-control">
                                    <p id="matched" style="display:none; color:green;">Password matched !!</p>
                                    <p id="notmatched" style="display:none; color:red;">Password not matched !!</p>    
                                </div>
                                </div>
                                
                                <button type="submit" id="changepassbtn" class="btn btn-primary">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $("#changepassbtn").prop("disabled", true);
        $("#confirmpass").keyup(function () {
            var newpass = $("#newpass").val();
            var confirmpass = $("#confirmpass").val();
            if (newpass === confirmpass) {
                $("#notmatched").hide();
                $("#matched").show();
                $("#changepassbtn").prop("disabled", false);
            } else {
                $("#matched").hide();
                $("#notmatched").show();
                $("#changepassbtn").prop("disabled", true);
            }
        });
    });
</script>