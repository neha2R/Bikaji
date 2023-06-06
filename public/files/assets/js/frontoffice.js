$(function(){
    $('.assignbtn').click(function(){
        $('#complaintid').val('');
        var id = $(this).attr('data-id');
        $('#complaintid').val(id);
    });
    $('.closecomplaintbtn').click(function(){
        $('#complaintid').val('');
        var id = $(this).attr('data-id');
        $('#complaintid').val(id);
    });

    

    $('.transferinquiry').change(function () {
        var inquiryid = $(this).closest('tr').find('select').attr('id'); // table row ID 
        var userid = $(this).closest('tr').find('select').val(); // table row ID 
        Swal.fire({
            title: 'Do You Want To Transfer Request',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off',
                placeholder: 'State the Reason For the Transfer'
            },
            showCancelButton: true,
            confirmButtonText: 'Transfer Request',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
               /* if (login.length < 50) {
                    Swal.showValidationMessage("Minimum character limit for this is 50 characters!");
                    return false;
                }*/
                if (login) {
                    return fetch(`/frontoffice/transferinquiry/${login}/${inquiryid}/${userid}`)
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
            console.log(result);
            if (result.value.status == 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Inquiry Transfered Successfully',
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
});
