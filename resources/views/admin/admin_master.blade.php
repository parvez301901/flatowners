<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('backend/images/favicon.ico')}}">

    <title>Flat Owners - Dashboard</title>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" >

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('backend/css/vendors_css.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/skin_color.css') }}">

</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">

<div class="wrapper">

    @include('admin.body.header');

    <!-- Left side column. contains the logo and sidebar -->
    @include('admin.body.sidebar');

    @yield('admin');

    @include('admin.body.footer');

    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->


<!-- Vendor JS -->
<script src="{{asset('backend/js/vendors.min.js')}}"></script>
<script src="{{asset('assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>

<script src="{{asset('assets/icons/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('assets/vendor_components/easypiechart/dist/jquery.easypiechart.js')}}"></script>

<script src="{{asset('assets/vendor_components/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/backend/js/pages/data-table.js')}}"></script>

<!-- Sunny Admin App -->
<script src="{{asset('backend/js/template.js')}}"></script>
<script src="{{asset('backend/js/pages/dashboard.js')}}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"
    switch(type){
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    @endif
    /*for select2 active */
    jQuery('.select2').select2();
    /*image upload*/
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

    /*Search Maintenance*/
    $(document).on('click','#search_maintenance',function(){
        var year_id = $('#maintenanceMonthYear').val();
        $('#search_maintenance').addClass('disabled');
        console.log(year_id);
        $.ajax({
            url: "{{ route('maintenance.search')}}",
            type: "get",
            data: {'year_id':year_id},
            beforeSend: function() {
            },
            success: function (data) {
                $('#search_maintenance').removeClass('disabled');
                var source = $("#document-template").html();
                var template = Handlebars.compile(source);
                var html = template(data);
                $('#DocumentResults').html(html);
            }
        });
    });

    /*Search Service Charge*/
    $(document).on('click','#search_serviceCharge',function(){
        var year_id = $('#serviceChargeMonthYear').val();
        $('#search_serviceCharge').addClass('disabled');
        console.log(year_id);
        $.ajax({
            url: "{{ route('servicecharge.search')}}",
            type: "get",
            data: {'year_id':year_id},
            beforeSend: function() {
            },
            success: function (data) {
                console.log(data);
                $('#search_serviceCharge').removeClass('disabled');
                var source = $("#document-template").html();
                var template = Handlebars.compile(source);
                var html = template(data);
                $('#DocumentResults').html(html);
                //$('[data-toggle="tooltip"]').tooltip();
            }
        });
    });

    /*Show Service Charge - RECEIPT*/
    $(document).on('click','.show_receipt',function(e) {
        e.preventDefault();
        var serviceChargeId = $(this).data( "servicechargeid" );

        console.log(serviceChargeId);
        $.ajax({
            url: "{{ route('servicecharge.receipt')}}",
            type: "get",
            data: {'serviceChargeId':serviceChargeId},
            beforeSend: function() {
            },
            success: function (data) {
                console.log(data);
                $('.receipt-holder').html(data);
            }
        });

    });

    /*Search Service Charge*/
    $(document).on('click','#search_serviceCharge',function(){
        var year_id = $('#serviceChargeMonthYear').val();
        $('#search_serviceCharge').addClass('disabled');
        console.log(year_id);
        $.ajax({
            url: "{{ route('servicecharge.search')}}",
            type: "get",
            data: {'year_id':year_id},
            beforeSend: function() {
            },
            success: function (data) {
                console.log(data);
                $('#search_serviceCharge').removeClass('disabled');
                var source = $("#document-template").html();
                var template = Handlebars.compile(source);
                var html = template(data);
                $('#DocumentResults').html(html);
                //$('[data-toggle="tooltip"]').tooltip();
            }
        });
    });

    /*Search Service Charge*/
    $(document).on('click','#search_balance_btn',function(){
        var year_id = $('#reportMonthYear').val();
        $('#search_balance_btn').addClass('disabled');
        console.log(year_id);
        $.ajax({
            url: "{{ route('report.monthly.balancesheet.search')}}",
            type: "get",
            data: {'year_id':year_id},
            beforeSend: function() {
            },
            success: function (data) {
                $('#search_balance_btn').removeClass('disabled');
                var source = $("#document-template").html();
                var template = Handlebars.compile(source);
                var html = template(data);
                $('#DocumentResults').html(html);
                //$('[data-toggle="tooltip"]').tooltip();
            }
        });
    });

    /*Search Service Charge*/
    $(document).on('change','input[name="serviceChargeMonthYear"]',function(){
        var year_id = $(this).val();
        console.log(year_id);
        $.ajax({
            url: "{{ route('servicecharge.search')}}",
            type: "get",
            data: {'year_id':year_id},
            beforeSend: function() {
            },
            success: function (data) {
                console.log(data);
                $('#search_serviceCharge').removeClass('disabled');
                var source = $("#document-template").html();
                var template = Handlebars.compile(source);
                var html = template(data);
                $('#DocumentResults').html(html);
                //$('[data-toggle="tooltip"]').tooltip();
            }
        });
    });

    /*on change - add user*/
    $(document).on('change','#on_select_floor',function(){
        var floor_id = $('#on_select_floor').val();
        console.log(floor_id);
        $.ajax({
            url:"{{ route('byfloor.getunit') }}",
            type:"GET",
            data:{floor_id:floor_id},
            success:function(data){
                var html = '<option value="">Select Flat</option>';
                $.each( data, function(key, v) {
                    html += '<option value="'+v.id+'">'+v.name+'</option>';
                });
                $('#assign_subject_id').html(html);
            }
        });
    });

    /*Check user already assigned*/
    $(document).on('change','.assign_unit',function(){
        var user_id = $('#user_id').val();
        var floor_id = $('#on_select_floor').val();
        var unit_id = $('.assign_unit').val();
        console.log(floor_id);
        $.ajax({
            url:"{{ route('byunit.getonwerid') }}",
            type:"GET",
            data:{floor_id:floor_id, user_id:user_id, unit_id:unit_id},
            success:function(data){
                console.log(data);
                if ( data.length > 0 ) {
                    $('.message').addClass('d-block').removeClass('d-none');
                } else {
                    $('.message').addClass('d-none').removeClass('d-block');
                }
            }
        });
    });

    /*Check user already assigned*/
    $(document).on('change','.find_user_by_unit',function(){
        var floor_id = $('#on_select_floor').val();
        var unit_id = $('.find_user_by_unit').val();
        console.log(floor_id);
        $.ajax({
            url:"{{ route('byunit.findonwerid') }}",
            type:"GET",
            data:{floor_id:floor_id, unit_id:unit_id},
            success:function(data){
                console.log(data);
                let html = '<option value="' + data.id + '">' + data.name + '</option>';
                $('#flatowner_info').html(html);
            }
        });
    });

    /*salary total*/
    function calc_total(){
        var sum = 0;
        $(".total").each(function(){
            sum += parseFloat($(this).val());
        });
        $('.final-salary').text(sum);
    }

    calc_total();

    $(".bonus_or_deduction").on('keyup', function(){
        var parent = $(this).closest('tr');
        var price  = parseFloat($('.basic_salary',parent).text());
        console.log(price);
        var choose = parseFloat($('.bonus_or_deduction',parent).val());
        console.log(choose);
        $('.total',parent).val(choose+price);

        calc_total();
    });

    $(document).on('click','.insert-salary-expense',function(e){
        e.preventDefault();
        $(this).addClass('disabled-link ');
        var total_salary = $('.final-salary').text();
        console.log(total_salary);

        $.ajax({
            url:"{{ route('salary.disburse') }}",
            type:"GET",
            data:{total_salary:total_salary},
            success:function(data){
                console.log(data);
                if ( data.length > 0 ) {
                    $('.message').addClass('d-block').removeClass('d-none');
                } else {
                    $('.message').addClass('d-none').removeClass('d-block');
                }
            }
        });
    });

    $(document).on('click','.due-money',function(e){
        e.preventDefault();
        var catch_element = $(this);
        catch_element.addClass('disabled-link');
        var phone = $(this).data( "phone" );
        var text = $(this).data( "text" );
        console.log(phone);
        $.ajax({
            url:"{{ route('sms.due_remind') }}",
            type:"GET",
            data:{phone:phone,text:text},
            success:function(data){
                console.log(data);
                if ( data === '1101' ) {
                    catch_element.children('i.ti-check').addClass('d-block').removeClass('d-none');
                    catch_element.siblings('p').addClass('d-block').removeClass('d-none');
                } else {
                    $('.smsmessage').addClass('d-none').removeClass('d-block');
                }

            }
        });
    });

    $(document).on('click','.thank-you',function(e){
        e.preventDefault();
        var catch_element = $(this);
        catch_element.addClass('disabled-link');
        var phone = $(this).data( "phone" );
        var text = $(this).data( "text" );
        console.log(phone);
        $.ajax({
            url:"{{ route('sms.thankyou') }}",
            type:"GET",
            data:{phone:phone,text:text},
            //context: this,
            success:function(data){
                console.log(data);
                if ( data == '1101' ) {
                    catch_element.children('i.ti-check').addClass('d-block').removeClass('d-none');
                    catch_element.siblings('p').addClass('d-block').removeClass('d-none');
                } else {
                    //$('.smsmessage').addClass('d-none').removeClass('d-block');
                    //$(this).siblings('smsmessage').addClass('d-block').removeClass('d-none');
                }
                catch_element.removeClass('disabled-link');

            }
        });

    });


    /*Search Service Charge*/
    $(document).on('click','#show_project_balance_btn',function(){

        var project_id = $('.project_id').val();
        $('#show_project_balance_btn').addClass('disabled');
        console.log(project_id);
        $.ajax({
            url: "{{ route('project.balance')}}",
            type: "get",
            data: {'project_id':project_id},
            beforeSend: function() {
            },
            success: function (data) {
                $('#show_project_balance_btn').removeClass('disabled');
                var source = $("#document-template-project").html();
                var template = Handlebars.compile(source);
                var html = template(data);
                $('#projectDetail').html(html);
                //$('[data-toggle="tooltip"]').tooltip();
            }
        });
    });

    function printDiv() {
        var printContents = document.getElementById('printableArea').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

</script>

</body>
</html>
