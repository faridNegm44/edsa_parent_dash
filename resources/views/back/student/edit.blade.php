<form>
    @csrf
    <input id="res_id" type="hidden" value="{{ $find['ID'] }}">
    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                <div class="row row-xs">
                    <div class="col-md-6">
                        <label for="ParentID"> ولي الأمر</label>
                        <select name="ParentID" id="ParentID" class="form-control select2_select2" style="width: 100%;">
                            @foreach ($parents as $item)    
                                <option value="{{ $item->ID }}" {{ $find['ParentID'] === $item->ID ? 'selected' : null }}>{{ $item->TheName0 }}</option>
                            @endforeach
                        </select>
                        <p class="errors" id="errors-ParentID"></p>
                    </div>

                    <div class="col-md-6">
                        <label for="TheName">اسم الطالب</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-child"></i></span>
                            </div>
                            <input class="form-control" id="TheName" name="TheName" placeholder="اسم الطالب" type="text "value="{{ $find['TheName'] }}">
                        </div>
                        <p class="errors" id="errors-TheName"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="TheEmail">البريد الإلكتروني</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input class="form-control" id="TheEmail" name="TheEmail" placeholder="البريد الإلكتروني" type="email "value="{{ $find['TheEmail'] }}">
                        </div>
                        <p class="errors" id="errors-TheEmail"></p>
                    </div>

                    <div class="col-md-6">
                        <label for="ThePhone">واتساب الطالب إن وجد</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-mobile-alt" aria-hidden="true"></i></span>
                            </div>
                            <input class="form-control" id="ThePhone" name="ThePhone" placeholder="واتساب الطالب إن وجد" type="text "value="{{ $find['ThePhone'] }}">
                        </div>
                        <p class="errors" id="errors-ThePhone"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="NatID">الجنسية</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="width: 100%;">
                                <span class="input-group-text"><i class="fa fa-flag"></i></span>
                            <select class="form-control select2_select2" id="NatID" name="NatID" style="width: 100%;">
                                @foreach (\DB::table('tbl_nat')->get() as $item)
                                    <option value="{{ $item->ID }}" {{ $find['NatID'] == $item->ID ? 'selected' : null }}>
                                        {{ $item->TheName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <p class="errors" id="errors-NatID"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="CityID">مكان الإقامة</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="width: 100%;">
                                <span class="input-group-text"><i class="fa fa-city"></i></span>
                                <select class="form-control select2_select2" id="CityID" name="CityID" style="width: 100%;">
                                    @foreach (\DB::table('tbl_cities')->get() as $item)
                                    <option value="{{ $item->ID }}" {{ $find['CityID'] == $item->ID ? 'selected' : null }}>
                                        دوله ( {{ $item->TheCountry }} ) مدينه ( {{ $item->TheCity }} )
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <p class="errors" id="errors-CityID"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="TheEduType">نظام التعليم</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-book-reader"></i></span>
                            </div>
                            <select class="form-control" id="TheEduType" name="TheEduType">
                                <option value="عربي" {{ $find['TheEduType'] == 'عربي' ? 'selected' : null }}>
                                    عربي
                                </option>
                                <option value="لغات" {{ $find['TheEduType'] == 'لغات' ? 'selected' : null }}>
                                    لغات
                                </option>
                                <option value="أزهري" {{ $find['TheEduType'] == 'أزهري' ? 'selected' : null }}>
                                    أزهري
                                </option>
                                <option value="مناهج خليجيه" {{ $find['TheEduType'] == 'مناهج خليجيه' ? 'selected' : null }}>
                                    مناهج خليجيه
                                </option>
                                <option value="International / American" {{ $find['TheEduType'] == 'International / American' ? 'selected' : null }}>
                                    International / American
                                </option>
                                <option value="International / Britsh" {{ $find['TheEduType'] == 'International / Britsh' ? 'selected' : null }}>
                                    International / Britsh
                                </option>
                                <option value="International / SABIS" {{ $find['TheEduType'] == 'International / SABIS' ? 'selected' : null }}>
                                    International / SABIS
                                </option>
                                <option value="International / SAT" {{ $find['TheEduType'] == 'International / SAT' ? 'selected' : null }}>
                                    International / SAT
                                </option>
                                <option value="International / IG" {{ $find['TheEduType'] == 'International / IG' ? 'selected' : null }}>
                                    International / IG
                                </option>
                                <option value="International / IB" {{ $find['TheEduType'] == 'International / IB' ? 'selected' : null }}>
                                    International / IB
                                </option>
                                <option value="غير ذلك" {{ $find['TheEduType'] == 'غير ذلك' ? 'selected' : null }}>
                                    غير ذلك
                                </option>
                            </select>
                        </div>
                        <p class="errors" id="errors-TheEduType"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="TheTestType">نظام الاختبارات</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-book-reader"></i></span>
                            </div>
                            <select class="form-control" id="TheTestType" name="TheTestType">
                                <option value="نظام التيرم في مصر" {{ $find['TheTestType'] == 'نظام التيرم في مصر' ? 'selected' : null }}>
                                    نظام التيرم في مصر
                                </option>
                                <option value="نظام التيرم مسار مصري" {{ $find['TheTestType'] == 'نظام التيرم مسار مصري' ? 'selected' : null }}>
                                    نظام التيرم مسار مصري
                                </option>
                                <option value="نظام اختبار السفاره تيرمين" {{ $find['TheTestType'] == 'نظام اختبار السفاره تيرمين' ? 'selected' : null }}>
                                    نظام اختبار السفاره تيرمين
                                </option>
                                <option value="نظام إختبار خليجي" {{ $find['TheTestType'] == 'نظام إختبار خليجي' ? 'selected' : null }}>
                                    نظام إختبار خليجي
                                </option>
                                <option value="International Exam" {{ $find['TheTestType'] == 'International Exam' ? 'selected' : null }}>
                                    International Exam
                                </option>
                                <option value="غير ذلك" {{ $find['TheTestType'] == 'غير ذلك' ? 'selected' : null }}>
                                    غير ذلك
                                </option>
                            </select>
                        </div>
                        <p class="errors" id="errors-TheTestType"></p>
                    </div>
                    
                    {{-- <div class="col-md-6">
                        <label for="TheStatus">حاله التسجيل</label>
                            <div class="input-group mb-3" style="background: #fff;border: 1px solid #e5e6f3;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="height: 39px;margin-left: 5px;"><i class="fa fa-check"></i></span>
                                </div>
                                <label for="1" style="margin: 10px 8px;">
                                    <input type="radio" value="1" name="TheStatus" id="1" {{ $find['TheStatus'] == 1 ? 'checked' : null }}> <span>جديد</span>
                                </label>
                                <label for="2" style="margin: 10px 8px;">
                                    <input type="radio" value="2" name="TheStatus" id="2" {{ $find['TheStatus'] == 2 ? 'checked' : null }}> <span>مفعل</span>
                                </label>
                                <label for="3" style="margin: 10px 8px;">
                                    <input type="radio" value="3" name="TheStatus" id="3" {{ $find['TheStatus'] == 3 ? 'checked' : null }}> <span>غير مفعل</span>
                                </label>
                            </div>
                                
                        <p class="errors" id="errors-TheStatus"></p>
                    </div> --}}
                    
                    <div class="col-md-6">
                        <label for="TheExplain">السجل الدراسي</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <textarea class="form-control" id="TheExplain" name="TheExplain" placeholder="السجل الدراسي للطالب. علي سبيل المثال الطالب محول من لغات إلي عربي أو الطالب محول من إنترناشيونال" rows="5" style="resize: none;">{{ $find['TheExplain'] }}</textarea>
                        </div>
                        <p class="errors" id="errors-TheExplain"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="TheNotes">ملاحظات</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <textarea class="form-control" name="TheNotes" id="TheNotes" placeholder="ملاحظات" rows="5" style="resize: none;">{{ $find['TheNotes'] }}</textarea>
                        </div>
                        <p class="errors" id="errors-TheNotes"></p>
                    </div>
                </div>
            @elseif(auth()->user()->user_status == 3)            
                <div class="row row-xs">
                    <div class="col-md-6">
                        <label for="ParentID">اسم ولي الأمر</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input class="form-control" disabled id="ParentID" name="ParentID" placeholder="اسم ولي الأمر" type="text" value="{{ auth()->user()->name }}" style="background: #FFF;">
                        </div>
                        <p class="errors" id="errors-ParentID"></p>
                    </div>

                    <div class="col-md-6">
                        <label for="TheName">اسم الطالب</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-child"></i></span>
                            </div>
                            <input class="form-control" id="TheName" name="TheName" placeholder="اسم الطالب" type="text "value="{{ $find['TheName'] }}">
                        </div>
                        <p class="errors" id="errors-TheName"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="TheEmail">البريد الإلكتروني</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input class="form-control" id="TheEmail" name="TheEmail" placeholder="البريد الإلكتروني" type="email "value="{{ $find['TheEmail'] }}">
                        </div>
                        <p class="errors" id="errors-TheEmail"></p>
                    </div>

                    <div class="col-md-6">
                        <label for="ThePhone">واتساب الطالب إن وجد</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-mobile-alt" aria-hidden="true"></i></span>
                            </div>
                            <input class="form-control" id="ThePhone" name="ThePhone" placeholder="واتساب الطالب إن وجد" type="text "value="{{ $find['ThePhone'] }}">
                        </div>
                        <p class="errors" id="errors-ThePhone"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="NatID">الجنسية</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="width: 100%;">
                                <span class="input-group-text"><i class="fa fa-flag"></i></span>
                            <select class="form-control select2_select2" id="NatID" name="NatID" style="width: 100%;">
                                @foreach (\DB::table('tbl_nat')->get() as $item)
                                    <option value="{{ $item->ID }}" {{ $find['NatID'] == $item->ID ? 'selected' : null }}>
                                        {{ $item->TheName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <p class="errors" id="errors-NatID"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="CityID">مكان الإقامة</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="width: 100%;">
                                <span class="input-group-text"><i class="fa fa-city"></i></span>
                                <select class="form-control select2_select2" id="CityID" name="CityID" style="width: 100%;">
                                    @foreach (\DB::table('tbl_cities')->get() as $item)
                                    <option value="{{ $item->ID }}" {{ $find['CityID'] == $item->ID ? 'selected' : null }}>
                                        دوله ( {{ $item->TheCountry }} ) مدينه ( {{ $item->TheCity }} )
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <p class="errors" id="errors-CityID"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="TheEduType">نظام التعليم</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-book-reader"></i></span>
                            </div>
                            <select class="form-control" id="TheEduType" name="TheEduType">
                                <option value="عربي" {{ $find['TheEduType'] == 'عربي' ? 'selected' : null }}>
                                    عربي
                                </option>
                                <option value="لغات" {{ $find['TheEduType'] == 'لغات' ? 'selected' : null }}>
                                    لغات
                                </option>
                                <option value="أزهري" {{ $find['TheEduType'] == 'أزهري' ? 'selected' : null }}>
                                    أزهري
                                </option>
                                <option value="مناهج خليجيه" {{ $find['TheEduType'] == 'مناهج خليجيه' ? 'selected' : null }}>
                                    مناهج خليجيه
                                </option>
                                <option value="International / American" {{ $find['TheEduType'] == 'International / American' ? 'selected' : null }}>
                                    International / American
                                </option>
                                <option value="International / Britsh" {{ $find['TheEduType'] == 'International / Britsh' ? 'selected' : null }}>
                                    International / Britsh
                                </option>
                                <option value="International / SABIS" {{ $find['TheEduType'] == 'International / SABIS' ? 'selected' : null }}>
                                    International / SABIS
                                </option>
                                <option value="International / SAT" {{ $find['TheEduType'] == 'International / SAT' ? 'selected' : null }}>
                                    International / SAT
                                </option>
                                <option value="International / IG" {{ $find['TheEduType'] == 'International / IG' ? 'selected' : null }}>
                                    International / IG
                                </option>
                                <option value="International / IB" {{ $find['TheEduType'] == 'International / IB' ? 'selected' : null }}>
                                    International / IB
                                </option>
                                <option value="غير ذلك" {{ $find['TheEduType'] == 'غير ذلك' ? 'selected' : null }}>
                                    غير ذلك
                                </option>
                            </select>
                        </div>
                        <p class="errors" id="errors-TheEduType"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="TheTestType">نظام الاختبارات</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-book-reader"></i></span>
                            </div>
                            <select class="form-control" id="TheTestType" name="TheTestType">
                                <option value="نظام التيرم في مصر" {{ $find['TheTestType'] == 'نظام التيرم في مصر' ? 'selected' : null }}>
                                    نظام التيرم في مصر
                                </option>
                                <option value="نظام التيرم مسار مصري" {{ $find['TheTestType'] == 'نظام التيرم مسار مصري' ? 'selected' : null }}>
                                    نظام التيرم مسار مصري
                                </option>
                                <option value="نظام اختبار السفاره تيرمين" {{ $find['TheTestType'] == 'نظام اختبار السفاره تيرمين' ? 'selected' : null }}>
                                    نظام اختبار السفاره تيرمين
                                </option>
                                <option value="نظام إختبار خليجي" {{ $find['TheTestType'] == 'نظام إختبار خليجي' ? 'selected' : null }}>
                                    نظام إختبار خليجي
                                </option>
                                <option value="International Exam" {{ $find['TheTestType'] == 'International Exam' ? 'selected' : null }}>
                                    International Exam
                                </option>
                                <option value="غير ذلك" {{ $find['TheTestType'] == 'غير ذلك' ? 'selected' : null }}>
                                    غير ذلك
                                </option>
                            </select>
                        </div>
                        <p class="errors" id="errors-TheTestType"></p>
                    </div>
                    
                    {{-- <div class="col-md-6">
                        <label for="TheStatus">حاله التسجيل</label>
                            <div class="input-group mb-3" style="background: #fff;border: 1px solid #e5e6f3;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="height: 39px;margin-left: 5px;"><i class="fa fa-check"></i></span>
                                </div>
                                <label for="1" style="margin: 10px 8px;">
                                    <input type="radio" value="1" name="TheStatus" id="1" {{ $find['TheStatus'] == 1 ? 'checked' : null }}> <span>جديد</span>
                                </label>
                                <label for="2" style="margin: 10px 8px;">
                                    <input type="radio" value="2" name="TheStatus" id="2" {{ $find['TheStatus'] == 2 ? 'checked' : null }}> <span>مفعل</span>
                                </label>
                                <label for="3" style="margin: 10px 8px;">
                                    <input type="radio" value="3" name="TheStatus" id="3" {{ $find['TheStatus'] == 3 ? 'checked' : null }}> <span>غير مفعل</span>
                                </label>
                            </div>
                                
                        <p class="errors" id="errors-TheStatus"></p>
                    </div> --}}
                    
                    <div class="col-md-6">
                        <label for="TheExplain">السجل الدراسي</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <textarea class="form-control" id="TheExplain" name="TheExplain" placeholder="السجل الدراسي للطالب. علي سبيل المثال الطالب محول من لغات إلي عربي أو الطالب محول من إنترناشيونال" rows="5" style="resize: none;">{{ $find['TheExplain'] }}</textarea>
                        </div>
                        <p class="errors" id="errors-TheExplain"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="TheNotes">ملاحظات</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <textarea class="form-control" name="TheNotes" id="TheNotes" placeholder="ملاحظات" rows="5" style="resize: none;">{{ $find['TheNotes'] }}</textarea>
                        </div>
                        <p class="errors" id="errors-TheNotes"></p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn ripple btn-success" id="update">تعديل</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">إلغاء</button>
    </div>
</form>

<script>
    $('.modal-title').html("تعديل طالب");

    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('#modaldemo8'),
        });

        $(".modal #update").click(function(e) {
            e.preventDefault();
            let id = $('#res_id').val();            
            let act = "{{ url('dashboard/students/update') }}"+"/"+id;

            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('form').serialize(),
                success: function (res) {
                    $('input').val('');
                    $('.modal').modal('hide');
                    $('#example2').DataTable().ajax.reload( null, false );
                    
                    notif({
                        msg: "تم التعديل بنجاح",
                        type: "success",
                    });

                    // location.reload();
                },
                error: function (res) {
                    if(res.responseJSON.errors.TheName){
                        $("form #errors-TheName").css('display' , 'block').text(res.responseJSON.errors.TheName);
                    }else{
                        $("form #errors-TheName").text('');
                    }
                    if(res.responseJSON.errors.ParentID){
                        $("form #errors-ParentID").css('display' , 'block').text(res.responseJSON.errors.ParentID);
                    }else{
                        $("form #errors-ParentID").text('');
                    }
                    if(res.responseJSON.errors.NatID){
                        $("form #errors-NatID").css('display' , 'block').text(res.responseJSON.errors.NatID);
                    }else{
                        $("form #errors-NatID").text('');
                    }
                    if(res.responseJSON.errors.CityID){
                        $("form #errors-CityID").css('display' , 'block').text(res.responseJSON.errors.CityID);
                    }else{
                        $("form #errors-CityID").text('');
                    }
                    if(res.responseJSON.errors.ThePhone){
                        $("form #errors-ThePhone").css('display' , 'block').text(res.responseJSON.errors.ThePhone);
                    }else{
                        $("form #errors-ThePhone").text('');
                    }
                    if(res.responseJSON.errors.TheEmail){
                        $("form #errors-TheEmail").css('display' , 'block').text(res.responseJSON.errors.TheEmail);
                    }else{
                        $("form #errors-TheEmail").text('');
                    }
                    if(res.responseJSON.errors.TheEduType){
                        $("form #errors-TheEduType").css('display' , 'block').text(res.responseJSON.errors.TheEduType);
                    }else{
                        $("form #errors-TheEduType").text('');
                    }
                    if(res.responseJSON.errors.TheTestType){
                        $("form #errors-TheTestType").css('display' , 'block').text(res.responseJSON.errors.TheTestType);
                    }else{
                        $("form #errors-TheTestType").text('');
                    }
                    if(res.responseJSON.errors.TheExplain){
                        $("form #errors-TheExplain").css('display' , 'block').text(res.responseJSON.errors.TheExplain);
                    }else{
                        $("form #errors-TheExplain").text('');
                    }
                    if(res.responseJSON.errors.TheNotes){
                        $("form #errors-TheNotes").css('display' , 'block').text(res.responseJSON.errors.TheNotes);
                    }else{
                        $("form #errors-TheNotes").text('');
                    }
                    if(res.responseJSON.errors.TheStatus){
                        $("form #errors-TheStatus").css('display' , 'block').text(res.responseJSON.errors.TheStatus);
                    }else{
                        $("form #errors-TheStatus").text('');
                    }
                    if(res.responseJSON.errors.TheStatusDate){
                        $("form #errors-TheStatusDate").css('display' , 'block').text(res.responseJSON.errors.TheStatusDate);
                    }else{
                        $("form #errors-TheStatusDate").text('');
                    }
                }
            });
            
        });
    });
    
</script>