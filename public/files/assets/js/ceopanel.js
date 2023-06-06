$(function(){
    // clear notifications
    $('.clearnotification').click(function(){
        var id = $(this).attr('data-id');
        $.ajax({
            type:'GET',
            url:'/clearnotification/'+id,
            success:function(data) {
               if (data.status == 1) {
                $('#badge').html(0);
                $('.allnotibox').html('');
               } else {
                   
               }
            }
         });
    });

    $('.tab-table').DataTable();
    var comp = document.getElementById('complaintchart').getContext('2d');
    var resolvedcom = $('#resolvedcomplaints').val();
    var pendingcom = $('#pendingcomplaints').val();
    var highpricom = $('#highprioritycomplaints').val();
    var crossedtlcom = $('#crossedtlcomplaints').val();
    var comarr = [];
    comarr.push(resolvedcom);
    comarr.push(pendingcom);
    comarr.push(highpricom);
    comarr.push(crossedtlcom);
    var comchart = new Chart(comp, {
        // The type of chart we want to create
        type: 'pie',

        // The data for our dataset
        data : {
            datasets: [{
                data: comarr,
                backgroundColor: [
                    '#0ac282',
                    '#fe9365',
                    '#8C00FA',
                    '#EA4335',
                ]
            }],
        
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Resolved',
                'Pending',
                'Highest Priority',
                'Crossed Timeline'
            ],
           
        },

        // Configuration options go here
        options: {}
    });

    var inq = document.getElementById('inquirychart').getContext('2d');
    var resolvedinq = $('#resolvedinquiries').val();
    var pendinginq = $('#pendinginquiries').val();
    var inqarr = [];
    inqarr.push(resolvedinq);
    inqarr.push(pendinginq);
    var inqchart = new Chart(inq, {
        // The type of chart we want to create
        type: 'pie',

        // The data for our dataset
        data : {
            datasets: [{
                data: inqarr,
                backgroundColor: [
                    '#0ac282',
                    '#EA4335',
                ]
            }],
        
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Resolved',
                'Pending'
            ],
           
        },

        // Configuration options go here
        options: {}
    });

    


});