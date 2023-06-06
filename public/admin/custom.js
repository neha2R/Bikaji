function adminchangedepartmentstatus(id,status){
    // console.log(id,status)
    $.ajax('/admin/departmentchangestatus', {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data:{'id':id,'status':status},
        success: function (data, status, xhr) {
            console.log(data)
            if (data.status == 200) {
                Swal.fire({
                    title: data.message,
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                }).then((result)=>{
                    if (result.value) {
                        window.location.reload()
                    }
                })
            }
        },
        error: function (jqXhr, textStatus, errorMessage) {

        }
    });
}

function admindepartmentdelete(id){
    // console.log(id)
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax('/admin/department/delete/' + id, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                success: function (data, status, xhr) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: 'Deleted Successfully',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then((result)=>{
                            if (result.value) {
                                window.location.reload()
                            }
                        })
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) {

                }
            });

        }
    })
}


function adminchangeinquirytype(id,status){
    $.ajax('/admin/inquirytype/changestatus', {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data:{'id':id,'status':status},
        success: function (data, status, xhr) {
            console.log(data)
            if (data.status == 200) {
                Swal.fire({
                    title: data.message,
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                }).then((result)=>{
                    if (result.value) {
                        window.location.reload()
                    }
                })
            }
        },
        error: function (jqXhr, textStatus, errorMessage) {

        }
    });
}

function admininquirytypedelete(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax('/admin/inquirytype/delete/' + id, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                success: function (data, status, xhr) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: 'Deleted Successfully',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then((result)=>{
                            if (result.value) {
                                window.location.reload()
                            }
                        })
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    
                }
            });

        }
    })
}


function adminchangecomplainttype(id,status){
    $.ajax('/admin/complainttype/changestatus', {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data:{'id':id,'status':status},
        success: function (data, status, xhr) {
            console.log(data)
            if (data.status == 200) {
                Swal.fire({
                    title: data.message,
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                }).then((result)=>{
                    if (result.value) {
                        window.location.reload()
                    }
                })
            }
        },
        error: function (jqXhr, textStatus, errorMessage) {

        }
    });
}

function admincomplainttypedelete(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax('/admin/complainttype/delete/' + id, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                success: function (data, status, xhr) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: 'Deleted Successfully',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then((result)=>{
                            if (result.value) {
                                window.location.reload()
                            }
                        })
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    
                }
            });

        }
    })
}