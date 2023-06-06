$(function(){
    $('#homelink').click(function(){
        $('#profile7').removeClass('active');
        $('#profile7').attr('aria-expanded', false);
        $('#home7').addClass('active');
        $('#home7').attr('aria-expanded', true);
        $('#profilelink').removeClass('active');
        $('#profilelink').attr('aria-expanded', false);
        $('#homelink').addClass('active');
        $('#homelink').attr('aria-expanded', true);
    });
    $('#profilelink').click(function(){
        $('#home7').removeClass('active');
        $('#home7').attr('aria-expanded', false);
        $('#profile7').addClass('active');
        $('#profile7').attr('aria-expanded', true);
        $('#homelink').removeClass('active');
        $('#homelink').attr('aria-expanded', false);
        $('#profilelink').addClass('active');
        $('#profilelink').attr('aria-expanded', true);
    });
})