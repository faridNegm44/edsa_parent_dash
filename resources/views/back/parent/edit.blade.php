<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<html lang="ar" dir="rtl">
<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Dashfox - Laravel Admin & Dashboard Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords" content="admin template, admin dashboard, bootstrap dashboard template, bootstrap 4 admin template, laravel, php framework, php laravel, laravel framework, php mvc, laravel admin panel, laravel admin panel, laravel template, laravel bootstrap, blade laravel, best php framework"/>
    <title>  تعديل بيانات ولي أمر </title>
    <link rel="icon" href="{{ url('back') }}/assets/img/brand/favicon.png" type="image/x-icon"/>
		<link href="{{ url('back') }}/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/plugins/icons/icons.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/plugins/sidebar/sidebar.css" rel="stylesheet">
		<link rel="stylesheet" href="{{ url('back') }}/assets/css-rtl/sidemenu.css">
		<link href="{{ url('back') }}/assets/css-rtl/style.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/css-rtl/style-dark.css" rel="stylesheet">
		<link id="theme" href="{{ url('back') }}/assets/css-rtl/colors/color.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">
        <link href="{{ url('back') }}/assets/plugins/jqvmap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/css-rtl/skin-modes.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/css-rtl/animate.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/switcher/css/switcher-rtl.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/switcher/demo.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/plugins/notify/css/notifIt.css" rel="stylesheet"/>

		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700&family=Tajawal:wght@200;300;500&display=swap" rel="stylesheet">


		@yield('header')

		<style>
			body{
				font-family: cairo;
			}
			.main-card-signin{
				max-width: 80%;
				min-width: 80%;
			}
			.required_icon{
				float: left;
				color: red;
				font-size: 6px;
				margin-top: 8px;
			}
			.page-signin-style:before{
				background: rgb(2 4 81);
			}
			.video_icon{
				padding: 8px 10px 8px;
                background: #ff6328;
                color: #fff;
                border-radius: 50%;
			}
			.video_icon:hover, .roles:hover{
				cursor: pointer;
			}
		</style>
</head>

    <body class="main-body light-theme">		
        <div class="my-auto page page-h">		
            
            <!-- main-signin-wrapper -->
            <div class="my-auto page page-h">
                <div class="main-signin-wrapper error-wrapper">
                    <div class="main-card-signin d-md-flex wd-100p col-xs-12">
                        <div class="row">
                    <div class="col-lg-4 page-signin-style p-5 text-white d-none d-sm-none d-md-none d-lg-block d-xl-block">
                        <div class="my-auto authentication-pages">
                            <div style="margin-top: -10px;">
                                <img src="{{ url('back') }}/images/settings/logo.png" class=" m-0 mb-4" alt="logo">
                                <h5 class="mb-4" style="text-decoration: underline;">المعلومات التي يتم تسجيلها هنا هي بيانات أولياء الأمور</h5>
                                <ul >
                                    <li style="padding: 5px;">جميع الحقول <strong>مطلوبه</strong></li> <hr />
                                    <li style="padding: 5px;">يرجي إدخال <strong>بريد إلكتروني</strong> صحيح</li> <hr />
                                    <li style="padding: 5px;">يرجي إدخال الاسم <strong>الأول والثاني والثالث</strong> بطريقه صحيحه</li> <hr />
                                    <li style="padding: 5px;">عند إدخال هاتف واتساب أو موبايل أخر للتواصل يجب كتابه <strong>مفتاح الدوله</strong></li> <hr />
                                    <li style="padding: 5px;">عند ادخال ارقام التليفونات يجب ان يكونوا  <strong>مختلفين</strong></li> <hr />
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 p-5 wd-md-50p">
                        <div class="main-signin-header">
                                <h2>مرحبًا</h2>
                            <h4>
                                هذة البيانات خاصة <bold style="color: rgb(238 69 4);font-weight: bold;text-decoration: underline;">( بولي الأمر فقط )</bold> وليست للطلبة
                            
                                <a href="{{ url('dashboard') }}" class="float-left video_icon" style="color: #fff;">
                                    <i class="fa fa-long-arrow-alt-left"></i>
                               </a>
                            </h4>
                            <br />
                            <form action="{{ url('dashboard/parents/update/'.$find['ID']) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>الاسم الأول</label>
                                        <i class="fa fa-star required_icon"></i>
                                        <input class="form-control" name="TheName1" placeholder="الاسم الأول من ولي الأمر" type="text" value="{{ $find['TheName1'] }}">
                                        <p style="display: none; color: red;" class='errors-TheName1'></p>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label>الاسم الثاني</label>
                                        <i class="fa fa-star required_icon"></i>
                                        <input class="form-control" name="TheName2" placeholder="الاسم الثاني من ولي الأمر" type="text" value="{{ $find['TheName2'] }}">
                                        <p style="display: none; color: red;" class='errors-TheName2'></p>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label>الاسم الثالث</label>
                                        <i class="fa fa-star required_icon"></i>
                                        <input class="form-control" name="TheName3" placeholder="الاسم الثالث من ولي الأمر" type="text" value="{{ $find['TheName3'] }}">
                                        <p style="display: none; color: red;" class='errors-TheName3'></p>
                                    </div>
                                                                    
                                    <div class="form-group col-md-6">
                                        <label>البريد الإلكتروني</label>
                                        <input class="form-control" name="TheEmail" placeholder="البريد الإلكتروني لولي الأمر" type="text" value="{{ $find['TheEmail'] }}">
                                        <p style="display: none; color: red;" class='errors-TheEmail'></p>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label>الرقم السري</label> 
                                        <i class="fa fa-star required_icon"></i>
                                        <input class="form-control" name="ThePass" placeholder="الرقم السري" type="password" value="">
                                        <input name="old_password" type="hidden" value="{{ $find['ThePass'] }}">
                                        <p style="display: none; color: red;" class='errors-ThePass'></p>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>تأكيد الرقم السري</label> 
                                        <i class="fa fa-star required_icon"></i>
                                        <input class="form-control" name="confirm_password" placeholder="تأكيد الرقم السري" type="password" value="">
                                        <p style="display: none; color: red;" class='errors-confirm_password'></p>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>الجنسية</label>
                                        <i class="fa fa-star required_icon"></i>
                                        <select class="form-control select2_select2" name="NatID" style="width: 100%;">
                                            @foreach (\DB::table('tbl_nat')->get() as $item)
                                            <option value="{{ $item->ID }}" @if ($item->ID == $find['NatID']) selected @else '' @endif>
                                                {{ $item->TheName }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <p style="display: none; color: red;" class='errors-NatID'></p>
                                    </div>
        
                                    <div class="form-group col-md-6">
                                        <label>مكان الإقامة</label>
                                        <i class="fa fa-star required_icon"></i>
                                        <select class="form-control select2_select2" name="CityID" style="width: 100%;">
                                            @foreach (\DB::table('tbl_cities')->get() as $item)
                                            <option value="{{ $item->ID }}" @if ($item->ID == $find['CityID']) selected @else '' @endif>
                                                دوله ( {{ $item->TheCountry }} ) --  مدينه ( {{ $item->TheCity }} )
                                            </option>
                                            @endforeach
                                        </select>
                                        <p style="display: none; color: red;" class='errors-CityID'></p>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>رقم واتس ولي الأمر</label> 
                                        <i class="fa fa-star required_icon"></i>
                                        <input class="form-control" name="ThePhone1" placeholder="لاتنس إضافه مفتاح الدوله خارج مصر" type="number" value="{{ $find['ThePhone1'] }}">
                                        <p style="display: none; color: red;" class='errors-ThePhone1'></p>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>رقم موبايل آخر لولي الأمر</label> 
                                        <i class="fa fa-star required_icon"></i>
                                        <input class="form-control" name="ThePhone2" placeholder="لاتنس إضافه مفتاح الدوله خارج مصر" type="number" value="{{ $find['ThePhone2'] }}">
                                        <p style="display: none; color: red;" class='errors-ThePhone2'></p>
                                    </div>

                                    @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                                        <div class="form-group col-md-12">
                                            <label>حالة ولي الأمر</label>
                                            <i class="fa fa-star required_icon"></i>
                                            <select class="form-control" name="TheStatus" style="width: 100%;">
                                                <option value="جديد" {{ $find['TheStatus'] == 'جديد' ? 'selected' : null }}>جديد</option>
                                                <option value="مفعل" {{ $find['TheStatus'] == 'مفعل' ? 'selected' : null }}>مفعل</option>
                                                <option value="غير مفعل" {{ $find['TheStatus'] == 'غير مفعل' ? 'selected' : null }}>غير مفعل</option>
                                            </select>
                                        </div>
                                    @endif

                                </div>

                                <button class="btn btn-main-primary btn-block" type="submit" style="background: rgb(2 4 81);">تعديل</button>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
                </div>
            </div>
            <!-- /main-signin-wrapper -->


        </div>

<script src="{{ url('back') }}/assets/plugins/jquery/jquery.min.js"></script>
<script src="{{ url('back') }}/assets/plugins/bootstrap/popper.min.js"></script>
<script src="{{ url('back') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ url('back') }}/assets/plugins/ionicons/ionicons.js"></script>
<script src="{{ url('back') }}/assets/plugins/moment/moment.js"></script>
<script src="{{ url('back') }}/assets/plugins/eva-icons/eva-icons.min.js"></script>
<script src="{{ url('back') }}/assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="{{ url('back') }}/assets/plugins/rating/jquery.barrating.js"></script>

<script src="{{ url('back') }}/assets/js/custom.js"></script>
    


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
        $('.select2_select2').select2();
    });
</script>
<script>

    $("form").submit(function(e){
        e.preventDefault();
        var url = $(this).attr('action');

        $.ajax({
            type: "post",
            headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            url: url,
            data: $('form').serialize(),
            success: function (res) {
                $('input').val('');
                // auth()->logout();
                window.location.href = "{{ url('dashboard/login') }}"
            },
            error: function (res) {
                if(res.responseJSON.errors.TheName1){
                    $("form .errors-TheName1").css('display' , 'block').text(res.responseJSON.errors.TheName1);
                }else{
                    $("form .errors-TheName1").text('');
                }
                if(res.responseJSON.errors.TheName2){
                    $("form .errors-TheName2").css('display' , 'block').text(res.responseJSON.errors.TheName2);
                }else{
                    $("form .errors-TheName2").text('');
                }
                if(res.responseJSON.errors.TheName3){
                    $("form .errors-TheName3").css('display' , 'block').text(res.responseJSON.errors.TheName3);
                }else{
                    $("form .errors-TheName3").text('');
                }
                if(res.responseJSON.errors.TheEmail){
                    $("form .errors-TheEmail").css('display' , 'block').text(res.responseJSON.errors.TheEmail);
                }else{
                    $("form .errors-TheEmail").text('');
                }
                if(res.responseJSON.errors.ThePass){
                    $("form .errors-ThePass").css('display' , 'block').text(res.responseJSON.errors.ThePass);
                }else{
                    $("form .errors-ThePass").text('');
                }
                if(res.responseJSON.errors.confirm_password){
                    $("form .errors-confirm_password").css('display' , 'block').text(res.responseJSON.errors.confirm_password);
                }else{
                    $("form .errors-confirm_password").text('');
                }
                if(res.responseJSON.errors.ThePhone1){
                    $("form .errors-ThePhone1").css('display' , 'block').text(res.responseJSON.errors.ThePhone1);
                }else{
                    $("form .errors-ThePhone1").text('');
                }
                if(res.responseJSON.errors.ThePhone2){
                    $("form .errors-ThePhone2").css('display' , 'block').text(res.responseJSON.errors.ThePhone2);
                }else{
                    $("form .errors-ThePhone2").text('');
                }
                if(res.responseJSON.errors.NatID){
                    $("form .errors-NatID").css('display' , 'block').text(res.responseJSON.errors.NatID);
                }else{
                    $("form .errors-NatID").text('');
                }
                if(res.responseJSON.errors.CityID){
                    $("form .errors-CityID").css('display' , 'block').text(res.responseJSON.errors.CityID);
                }else{
                    $("form .errors-CityID").text('');
                }
                if(res.responseJSON.errors.roles){
                    $("form .errors-roles").css('display' , 'block').text(res.responseJSON.errors.roles);
                }else{
                    $("form .errors-roles").text('');
                }
            }
        });
    });

</script>
	</body>

</html>