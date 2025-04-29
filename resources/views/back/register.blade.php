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
    <title> صفحه: تسجيل ولي أمر </title>
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
				padding: 6px 8px 4px;
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

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1000000;">
			<div class="modal-dialog modal-xl" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">فديو توضيحي لكيفيه تسجيل بيانات ولي أمر جديد</h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
					<iframe width="100%" height="400px" src="https://www.youtube.com/embed/Er9RjLovjpo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			  </div>
			</div>
		  </div>

        <div class="modal fade" id="modal_roles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1000000;">
			<div class="modal-dialog modal-xl" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">سياسة <span style="color: red;"> EduStage Academy </span> مع السادة المشتركين في خدمات الأكاديمية</h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body" style="font-size: 16px;padding: 20px;color: #000;">
					<p style="line-height: 30px;">
						نسعى في EduStage لتوفير أفضل خدمة تعليمية ممكنة قدر استطاعتنا للطلبة وأولياء الأمور, ولضمان جودة الخدمة نسرد لحضراتكم بنود سياسة التعامل بين إدارة الأكاديمية والمشتركين الأفاضل, يرجى مراجعة هذه الشروط والأحكام قبل استخدام أي من خدمات أكاديمية إديوستيدج لأنها تحكم العلاقة بين المستخدم والقائمين على الخدمة.
					</p>
					<br />
					<p style="color: red;font-weight: bold;">
						تخضع هذه الشروط والأحكام من حينٍ إلى آخر للتحديث أو التعديل أو التغيير، لذا يرجى مراجعتها بشكل مستمر للاطلاع على ما فيها أثناء استخدامك للخدمة.
					</p>
					<br />
					<p>
						بمجرد استخدامك لأي من الخدمات المقدمة من خلال الاكاديمية فهي بمثابة أنك قمت بقراءة هذه الشروط والموافقة عليها.
					</p>
					<ol>
						<li>
							يجب على الطالب، أو ولي أمره تقديم معلومات دقيقة وصحيحة لسهولة التواصل معه.
						</li> <hr />
						<li>
							يجب على الطالب أو ولي أمره عدم الخوض على جروبات الأكاديمية أو أثناء الحصص في أي مواضيع دينية، أو سياسية غير المادة العلمية محل الدرس.
						</li> <hr />
						<li>
							⚠️يتم سداد الاشتراكات ( مقدمًا ) مع ضرورة السداد في أسرع وقت ممكن خاصة للسادة المغتربين بسبب تأخر وصول التحويلات بين البنوك، وسيتم إخطاركم بفاتورة الحساب نهاية كل شهر لسداد الشهر الجديد.
						</li> <hr />
						<li>
							جميع المواعيد المتفق عليها لجدول الحصص هي بالتوقيت المصري فقط لا غير.
						</li> <hr />
						<li>
							إنشاء المجموعات لكل صف ومادة مشروط باستكمال الحد الأدنى من عدد المشتركين المطلوب في كل باقة من باقات الأسعار المختلفة، وإدارة الأكاديمية تسعى سعياً حثيثاً لإستكمال الجروبات بتحفيز مزيد من الطلبة للإشتراك بالأكاديمية بنشر الإعلانات المموله وتقديم عروض ومميزات للمشتركين.
						</li> <hr />
						<li>
							جدول حصص المدرسة الصباحية أو المسائية بنظام الحصص المتتابعة غير قابل للتغيير يلتزم به المعلم والطالب و الموافقة المسبقة على هذا الجدول شرط من شروط الالتحاق بخدمات الأكاديمية للعام الدراسي الجديد.
						</li> <hr />
						<li>
							زمن الحصة الرسمي ساعة واحدة لجميع الصفوف وقد يزيد إلى ساعة و ربع حسب حاجة المدرس لوقت إضافي، إلا لو تم الاتفاق على غير ذلك بين الأكاديمية والعميل أو حسب العروض المختلفة التي تقدمها الأكاديمية للكورسات والدروس.
						</li> <hr />
						<li>
							ضرورة احترام جدول الحصص المتفق عليه مع المدرس وحضور الدرس خلال 15 دقيقة من ميعاد الحصة ولو لم يتم تواجد الطالب برايفت أو على الأقل واحد من الطلبة في المجموعة خلال 15 دقيقة في الحصة، يتم إلغاء الحصة و احتساب الحصة على الطالب/الطلبة.
						</li> <hr />
						<li>
							الأكاديمية غير مسئولة عن تذكير الطلبة بمواعيد حصصهم، وأي تأخير عن الحصة يلتزم المدرس لو تأخر بتعويض زمن التأخير ولو الطالب تأخر يحتسب وقت التأخير من الحصة وللمدرس الحرية في تعويض زمن تأخير الطالب أو لأ.
						</li> <hr />
						<li>
							أي طالب يعتذر عن حضور الحصة في المجموعة، تعتبر الحصة محسوبة ومدفوعة الأجر طالما سيتم مشاركة فيديو الحصة مع الطالب؛ لأنها تعتبر شرح كامل ووافي للدرس بالإضافة للحصول على ملفات الدرس إن وجدت.
						</li> <hr />
						<li>
							الحصة التي يعتذر عنها الطالب، مُطالب بمذاكرة فيديو الحصة جيدًا وسؤال المدرس عن أي أمر غير مفهوم في الميعاد المناسب بالاتفاق مع المدرس، و من حق المدرس سؤال الطالب المتغيب في الحصة السابقة في أي جزئية فيما تم شرحه في الحصة التي اعتذر عنها.
						</li> <hr />
						<li>
							الاعتذارات عن الحصص لابد أن تكون في توقيت مبكر قبل الحصة بـ 24 ساعة قبل ميعاد الحصة، وليس قبل ميعاد الحصة مباشرة سواء من الطالب أو المدرس. إلا لو في حالة قهرية تمنع التواصل فلابد من تفهم الأمر ومراعاة الظروف ونتجاوز عن بعضنا البعض.
						</li> <hr />
						<li>
							يلتزم الطالب بتوفير أية أدوات مطلوبة لحضور الدروس أونلاين (كمبيوتر محمول أو ديسكتوب , إنترنت جيد ومستقر، هيدفون جيد).
						</li> <hr />
						<li>
							دروس الأكاديمية ستكون بث مباشر مع الطالب وسيحصل الطالب بعدها على فيديو مسجل للحصة بجودة عالية بالإضافة إلى ملازم وأوراق عمل لكل درس إن وجدت.
						</li> <hr />
						<li>
							فى حالة حضور الطالب للحصة وانقطاع الإنترنت عنه أثناء الحصة تحسب الحصة على الطالب ويتم الرجوع للفيديو المسجل والمدرس ملزم بالرد على أي أسئلة تقف أمام الطالب بأى شكل من الأشكال على حسب ما يراه المدرس مناسبًا له.
						</li> <hr />
						<li>
							يلتزم الطالب بدخول الغرفة باسمه الحقيقي ( وليس اسم أخيه أو والده أو باسم Galaxy أو iPhone ووضع صورة لائقة فى البروفايل الخاص به أو لا يضع صورة من الأصل.
						</li> <hr />
						<li>
							⚠️فيديوهات الحصص ملكية مشتركة بين الأكاديمية و الطالب، ممنوع مشاركة فيديوهات الشرح مع الآخرين إلا بإذن من إدارة الأكاديمية، علماً بإمكانية إدارة الأكاديمية بتتبع زيارات تشغيل فيديوهات الحصص وسهولة معرفة من شارك الفيديوهات بغير وجه حق.
						</li> <hr />
						<li>
							سيتم إرسال لينكات فيديوهات الحصص على جروبات الواتساب الخاصة بكل صف ومادة بعد الحصة على أن يتم تحميله على أجهزتكم في أسرع وقت ممكن لأنه سيتم حذف الفيديو من على سيرفر الأكاديمية بعد أيام محدودة.
						</li> <hr />
						<li>
							أي تبادل لبيانات شخصية أو محادثات على الخاص بين أفراد المجموعة وبعضها سواء بين أولياء أمور أو طلبة أو مع المدرس، الأكاديمية غير مسئولة عنها.
						</li> <hr />
						<li>
							يحظر التعامل أو النقاش بين ولي الأمر والمدرس في أي أمور إدارية أو مادية متعلقة بالحصص، أية معاملات مادية أو إدارية لابد أن تكون من خلال إدارة الأكاديمية فقط لا غير متمثلة في شريك مؤسس ومدير الأكاديمية الاستاذ تامر مرسي 01062808121.
						</li> <hr />
						<li>
							يحظر مشاركة أي إعلانات على صفحة الفيسبوك أو جروبات الواتساب الخاصة بالأكاديمية.
						</li> <hr />
						<li>
							يحظر مشاركة لينكات أو أكواد حضور الحصص مع غير المشتركين، ومن يخالف ذلك يعرض نفسه لإلغاء اشتراكه في المادة فورًا وربما من الأكاديمية تماماً.
						</li> <hr />
						<li>
							من كان لديه أية مشكلة بينه وبين ولي أمر أو بينه وبين المدرس فليتواصل على الخاص مع إدارة الأكاديمية، ولا يتجاوز في الحوار مع الطرف الأخر.
						</li> <hr />
						<li>
							طلب أي إجتماع من أولياء الأمور مع المدرس، مرحب به جدًا لكن لابد من الترتيب لهذا الاجتماع مع إدارة الأكاديمية أولاً حفاظاً على وقت الحصة والمدرس لأن الحصص متتابعة وقد يؤثر الاجتماع المفاجئ لولي الأمر مع المدرس على ميعاد الحصة التالية له.
						</li> <hr />
						<li>
							في حالة نشر أي استبيان من خلال الموقع أو قنوات التواصل الاجتماعي نرجو من حضراتكم الاهتمام بملء هذا الاستبيان فما هو إلا مشاركة من حضراتكم لتحسين الخدمة التي تنتهي في النهاية لصالح أبنائكم.
						</li> <hr />
						<li>
							تواصلكم وتعليقاتكم ذات أهمية بالغة ومحل تقدير من جانبنا حتى ولو كان بالنقد السلبي طالما كان النقد في إطار الاحترام المتبادل بيننا، فنحن نرحب دائمًا وأبدًا بالنقد البنّاء وسنسعى لحل أية مشكلة في سبيل توطيد علاقات التعاون المشترك بيننا لصالح أبنائنا الطلبة.
						</li> <hr />
						<li>
							في حالة خروج طالب أو أكثر من الجروب لن يتم تطبيق أي زيادة في سعر الحصة على باقي الطلبة.
						</li> <hr />
						<li>
							في حالة إنسحاب الطالب خلال أحد الشهور الدراسية من جروب مادة كان مستحق فيه لخصم، يرفع عنه ميزة الخصم في هذه الماده ((للحصص التي تمت في شهر الإنسحاب فقط)) وليس بأثر رجعي للشهور السابقه، الحكمة من التمتع بالخصم هو الاستمرار في الماده.
						</li> <hr />
						<li>
							إن لزم الأمر حسب تقدير إدارة الأكاديمية، يتم عمل حصة تجريبية للطالب وفى حالة قرار ولي الأمر باستكمال الدراسة ستحتسب هذه الحصة من قيمة الاشتراك بأنها الحصة الأولى وإذا لم يتم استكمال الدراسة فهي حصة مجانية للطالب.
						</li> <hr />
						<li>
							عزيزي ولي الأمر الفاضل، ما سبق هي بنود التعاون المشترك بينك و بين الأكاديمية، والمؤمنون عند شروطهم. عند الإخلال بهذه البنود من حق إدارة الأكاديمية وقف التعامل مع الطالب ومن حق الأكاديمية عدم إبداء أي أسباب. في حالة طلب إلغاء الاشتراك يمكننا رد المبلغ بالطريقة المناسبة لإدارة الأكاديمية وبالتنسيق مع المشترِك بعد خصم عدد الحصص التي حضرها الطالب، أو الاحتفاظ بها للطالب في رصيده لأي تعاون آخر.
						</li> <hr />
					</ol>
					<br /><br />
					<p class="text-center" style="color: red;font-weight: bold;font-size: 18px;">
						خدمتكم شرف لنا ونعدكم إن شاء الله تعالى بتقديم محتوى ومستوى تعليمي متميز لأبنائنا الطلبة
					</p>
					<br /><br />
				</div>
			  </div>
			</div>
		  </div>


		<div id="global-loader">
			<img src="{{ url('back') }}/assets/img/loader-2.svg" class="loader-img" alt="Loader">
		</div>

		
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
								<li style="padding: 5px;">يرجي إدخال <strong>بريد إالكتروني</strong> صحيح</li> <hr />
								<li style="padding: 5px;">يرجي إدخال الاسم <strong>الأول والثاني والثالث</strong> بطريقه صحيحه</li> <hr />
								<li style="padding: 5px;">عند إدخال هاتف واتساب أو موبايل أخر للتواصل يجب كتابه <strong>مفتاح الدوله</strong></li> <hr />
								<li style="padding: 5px;">عند ادخال ارقام التليفونات يجب ان يكونوا <strong>مختلفين</strong></li> <hr />
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-8 col-md-12 p-5 wd-md-50p">
					<div class="main-signin-header">
							<h2>مرحبًا</h2>
							<span class="float-left video_icon" data-effect="effect-flip-vertical" data-toggle="modal" data-target="#modal">
							     <i class="fa fa-video"></i>
							</span>
						<h4>هذة البيانات خاصة <bold style="color: rgb(238 69 4);font-weight: bold;text-decoration: underline;"> (بولي الأمر فقط)</bold> وليست للطلبة</h4>
						<br />
						<form action="{{ url('dashboard/parent/register') }}" method="post">
                            @csrf
							<div class="row">
								<div class="form-group col-md-6">
									<label>الاسم الأول</label>
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="TheName1" placeholder="الاسم الأول من ولي الأمر" type="text" value="">
									<p style="display: none; color: red;" class='errors-TheName1'></p>
								</div>
								
								<div class="form-group col-md-6">
									<label>الاسم الثاني</label>
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="TheName2" placeholder="الاسم الثاني من ولي الأمر" type="text" value="">
									<p style="display: none; color: red;" class='errors-TheName2'></p>
								</div>
								
								<div class="form-group col-md-6">
									<label>الاسم الثالث</label>
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="TheName3" placeholder="الاسم الثالث من ولي الأمر" type="text" value="">
									<p style="display: none; color: red;" class='errors-TheName3'></p>
								</div>
																
								<div class="form-group col-md-6">
									<label>البريد الإلكتروني</label>
									<input class="form-control" name="TheEmail" placeholder="البريد الإلكتروني لولي الأمر" type="text" value="">
									<p style="display: none; color: red;" class='errors-TheEmail'></p>
								</div>
								
								<div class="form-group col-md-6">
									<label>الرقم السري</label> 
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="ThePass" placeholder="الرقم السري" type="password" value="">
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
										<option value="{{ $item->ID }}" @if ($item->ID == 1) selected @else '' @endif>
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
										<option value="{{ $item->ID }}">
											دوله ( {{ $item->TheCountry }} ) --  مدينه ( {{ $item->TheCity }} )
										</option>
										@endforeach
									</select>
									<p style="display: none; color: red;" class='errors-CityID'></p>
								</div>

								<div class="form-group col-md-6">
									<label>رقم واتس ولي الأمر</label> 
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="ThePhone1" placeholder="لاتنس إضافه مفتاح الدوله خارج مصر" type="number" value="">
									<p style="display: none; color: red;" class='errors-ThePhone1'></p>
								</div>

								<div class="form-group col-md-6">
									<label>رقم موبايل آخر لولي الأمر</label> 
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="ThePhone2" placeholder="لاتنس إضافه مفتاح الدوله خارج مصر" type="number" value="">
									<p style="display: none; color: red;" class='errors-ThePhone2'></p>
								</div>

								<div class="form-group col-md-12">
									<input class="" name="roles" type="checkbox" style="margin-left: 10px;width: 20px;height: 20px;position: relative;top: 5px;">
									{{-- <label class="roles" data-effect="effect-flip-vertical" data-toggle="modal" data-target="#modal_roles" style="text-decoration: underline;color: red;font-weight: bold;">سياسة EduStage Academy مع السادة المشتركين في خدمات الأكاديمية</label>  --}}
									<a href="https://edustage.net/_site/policy/" target="_blank" style="text-decoration: underline;color: red;font-weight: bold;">سياسة EduStage Academy مع السادة المشتركين في خدمات الأكاديمية</a>
									<p style="display: none; color: #000;" class='errors-roles'></p>
								</div>
							</div>

							<button class="btn btn-main-primary btn-block" type="submit" style="background: rgb(2 4 81);">تسجيل</button>
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