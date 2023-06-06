$(function () {
    $('#subdetailscomplaint').hide();
    $('#subdetailsinquiry').hide();
})
$("#complaint").click(function () {
    $('#subdetailscomplaint').show();
    $('#subdetailsinquiry').hide();
})
$("#inquiry").click(function () {
    // alert('hello');
    $('#subdetailscomplaint').hide();
    $('#subdetailsinquiry').show();
})


$(function () {
    
    $('.onfff').change(function () {
        var complaintid = $(this).closest('tr').find('select').attr('id'); // table row ID 
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
                /*if (login.length < 50) {
                    Swal.showValidationMessage("Minimum character limit for this is 50 characters!");
                    return false;
                }*/
                if (login) {
                    return fetch(`/jassociates/transfer/${login}/${complaintid}/${userid}`)
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
            // console.log(result);
            if (result.value.status == 200) {
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
                if (login) {
                    return fetch(`/jassociates/transferinquiry/${login}/${inquiryid}/${userid}`)
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
$('.inquirytable').on('click','.inquiryresolvebtn',function () {
// $('.inquiryresolvebtn').click(function(){
    var id = $(this).attr('data-id');
    var fromuser = $(this).attr('data-fromuser');
    var departmentid = $(this).attr('data-departmentid');
    $('#inquiryid').val(id);
    $('#fromuser').val(fromuser);
    $('#departmentid').val(departmentid);
});


$('.complainttable').on('click','.complaintresolvebtn',function () {
    // console.log('hello');
    var id = $(this).attr('data-id');
    var fromuser = $(this).attr('data-fromuser');
    var departmentid = $(this).attr('data-departmentid');
    $('#complaintid').val(id);
    $('#fromuser').val(fromuser);
    $('#departmentid').val(departmentid);
});



    // $('.resolvebtn').click(function () {
    //     var complaintid = $(this).prev().attr('id'); 
    //     console.log(complaintid) 
        // Swal.fire({
        //     title: 'Do You Want To Transfer Request',
        //     input: 'text',
        //     inputAttributes: {
        //         autocapitalize: 'off',
        //         placeholder: 'State the Reason For the Transfer'
        //     },
        //     showCancelButton: true,
        //     confirmButtonText: 'Transfer Request',
        //     showLoaderOnConfirm: true,
        //     preConfirm: (login) => {
        //         if (login) {
        //             return fetch(`/jassociates/transfer/${login}/${complaintid}/${userid}`)
        //                 .then(response => {
        //                     return response.json()
        //                 })
        //                 .catch(error => {
        //                     console.log(error)
        //                 })
        //         } else {
        //             Swal.showValidationMessage(
        //                 'Please Input Value'
        //             )
        //         }

        //     },
        //     allowOutsideClick: () => !Swal.isLoading()
        // }).then((result) => {
        //     Swal.fire({
        //         icon: 'success',
        //         title: 'Compaint Transfered Successfully',
        //         allowOutsideClick:false,
        //         allowEscapeKey:false,
        //         confirmButtonText: 'OK'
        //       }).then((result)=>{
        //           window.location.reload()
        //       })
        // })
    // });

});

$(function(){
    // $.noConflict();
    $('.readmorediv').readmore();
    $('.readmorediv').readmore({
    speed: 75,
    collapsedHeight: 40,
    maxHeight: 100,
    moreLink: '<a href="#" style="color:#ffb600;">Read more</a>',
    lessLink: '<a href="#" style="color:#ffb600;">Read less</a>'
    });
 });
