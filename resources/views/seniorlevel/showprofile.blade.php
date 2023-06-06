@extends('seniorlevel.layout.slevelapp')
@section('content')
    @component('components.common.updateprofile')

    @endcomponent
@endsection
@section('js')
<script>
    $('#image-file').on('change', function() {
  var numb = $(this)[0].files[0].size / 1024 / 1024;
  numb = numb.toFixed(2);
  if (numb > 2) {
    alert('to big, maximum is 2MiB. You file size is: ' + numb + ' MiB');
    $(this).val('');
  } else {
    // alert('it okey, your file has ' + numb + 'MiB')
  }
});
$('.text').on('keypress', function(e) {
          var regex = new RegExp("^[a-zA-Z ]*$");
          var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
          if (regex.test(str)) {
             return true;
          }
          e.preventDefault();
          return false;
         });

         $('#form').on('submit', function() {
        var mobileNum = $('#mobile').val();
var validateMobNum= /^\d*(?:\.\d{1,2})?$/;
if (validateMobNum.test(mobileNum ) && mobileNum.length == 10) {
}
 else {
           alert("Please Enter only 10 digit mobile no")
        $("#mobile").focus();
            return false;
       }


        });
</script>
@endsection
