$(document).ready(function(){
    var tabpane = $('#inquirytab').val();
    if (parseInt(tabpane)) {
        $('#home7').removeClass('active');
        $('#home7').attr('aria-expanded', false);
        $('#profile7').addClass('active');
        $('#profile7').attr('aria-expanded', true);
        $('#homelink').removeClass('active');
        $('#homelink').attr('aria-expanded', false);
        $('#profilelink').addClass('active');
        $('#profilelink').attr('aria-expanded', true);
    }
    $('#jcomplainttable tbody tr').each(function(){
        $(this).find('.resolvebtn').unbind('click').click(function(e){
            e.stopPropagation();
            var id = $(this).attr('data-id');
            // console.log(id)
            Swal.fire({
                title: 'How did you Resolve this issue',
                input: 'textarea',
                inputAttributes: {
                    autocapitalize: 'off',
                    placeholder: 'How did you Resolve this issue'
                },
                showCancelButton: true,
                confirmButtonText: 'Mark As Resolved',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    // console.log(login)
                    var formData = new FormData();
                    formData.append('compaintid', id);
                    formData.append('response', login);
                    if (login) {
                        return fetch('/jassociates/complainteresolve',{
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              },
                            body: formData
                        })
                            .then(response => {
                                return response.json()
                            })
                            .catch(error => {
                                console.log(error)
                            })
                    } else {
                        Swal.showValidationMessage(
                            'Please Input Value'
                        )
                    }
    
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Complaint Transfered Successfully',
                        allowOutsideClick:false,
                        allowEscapeKey:false,
                        confirmButtonText: 'OK'
                      }).then((result)=>{
                          window.location.reload()
                      })
                }
             
            })
        });
    });
});