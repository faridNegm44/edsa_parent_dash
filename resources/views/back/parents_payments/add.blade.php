<form enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">
                @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                    <div class="col-md-12" style="margin-bottom: 10px;">
                        <label for="ParentID"> ولي الأمر</label>
                        <select name="ParentID" id="ParentID" class="form-control select2_select2" style="width: 100%;">
                            @foreach ($parents as $item)    
                                <option value="{{ $item->ID }}">{{ $item->TheName0 }}</option>
                            @endforeach
                        </select>
                        <p class="errors" id="errors-ParentID"></p>
                    </div>
                @endif
                
                <div class="col-md-6">
                    <label for="TheDate">تاريخ الدفع</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                        <input class="form-control" id="TheDate" name="TheDate" placeholder="تاريخ الدفع" type="date" value="{{ date('Y-m-d') }}" />
                    </div>
                    <p class="errors" id="errors-TheDate"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="ThePayType">طريقة الدفع</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                        </div>
                        <select class="form-control" name="ThePayType" id="ThePayType">
                            <option value="حساب البنك الأهلي المصري">
                                حساب البنك الأهلي المصري
                            </option>
                            <option value="حساب البريد المصري">
                                حساب البريد المصري
                            </option>
                            <option value="حساب بنك مصر">
                                حساب بنك مصر
                            </option>
                            <option value="حساب بنك CIB">
                                حساب بنك CIB
                            </option>
                            <option value="فودافون كاش">
                                فودافون كاش
                            </option>
                            <option value="تسليم نقدي">
                                تسليم نقدي
                            </option>
                            <option value="CowPay">
                                CowPay
                            </option>
                            <option value="غير ذلك">
                                غير ذلك
                            </option>
                        </select>
                    </div>
                    <p class="errors" id="errors-ThePayType"></p>
                </div>
                                
                <div class="col-md-6">
                    <label for="amount_by_currency">المبلغ</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                        </div>
                        <input class="form-control" id="amount_by_currency" name="amount_by_currency" placeholder="المبلغ" type=number />
                    </div>
                    <p class="errors" id="errors-amount_by_currency"></p>
                </div>
                                
                <div class="col-md-6">
                    <label for="currency">العملة</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                        </div>
                        <select class="form-control" name="currency" id="currency">
                            <option value="ج مصري" selected>
                                ج مصري
                            </option>
                            <option value="ريال">
                                ريال
                            </option>
                            <option value="دينار">
                                دينار
                            </option>
                            <option value="دولار">
                                دولار
                            </option>
                        </select>
                    </div>
                    <p class="errors" id="errors-currency"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="sender_name">إسم المرسل</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input class="form-control" id="sender_name" name="sender_name" placeholder="إسم المرسل" type="text" value="" />
                    </div>
                    <p class="errors" id="errors-sender_name"></p>
                </div>

                <div class="col-md-6">
                    <label for="invoice_number">رقم الوصل</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                        </div>
                        <input class="form-control" id="invoice_number" name="invoice_number" placeholder="رقم الوصل" type="text" value="" />
                    </div>
                    <p class="errors" id="errors-invoice_number"></p>
                </div>

                <div class="col-md-12">
                    <label for="TheNotes">ملاحظات ( ولي الأمر )</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                        </div>
                        <textarea class="form-control" id="TheNotes" name="TheNotes" rows="4" placeholder="ملاحظات ( ولي الأمر )" ></textarea>
                    </div>
                    <p class="errors" id="errors-TheNotes"></p>
                </div>

                <div class="col-md-12">
                    <div class="custom-file-container" data-upload-id="file">
                        <label>
                            صوره الوصل
                            <a href="javascript:void(0)" class="custom-file-container__image-clear" title="حذف">
                                <i class="fa fa-trash" style="color: #f35f5f;margin: 0px 10px;"></i>
                            </a>
                        </label>
                        <label class="custom-file-container__custom-file">
                            <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" aria-label="Choose File" name="file" />

                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            <span class="custom-file-container__custom-file__custom-file-control" style="padding: 7px 100px;"></span>
                        </label>
                        <div class="custom-file-container__image-preview"></div>
                    </div>
                    <p class="errors" id="errors-image"></p>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn ripple btn-primary" id="save">حفظ</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">إلغاء</button>
    </div>
</form>

<style>
    table tbody tr{
        padding-top: 100px;
    }
</style>
<script>
    $('.modal-title').html("إضافه");
    // File Upload
    var upload = new FileUploadWithPreview("file");
    
    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('#modaldemo8'),
        });

        $(".modal #save").click(function(e) {
            e.preventDefault();
            
            let act = "{{ url('dashboard/parents_payments/store') }}";
            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                processData: false,
                contentType: false,
                data: new FormData($(".modal form")[0]),
                success: function (res) {
                    $('input').val('');
                    $('.modal').modal('hide');
                    $('#example2').DataTable().ajax.reload( null, false );
                    
                    notif({
                        msg: "تمت الإضافه بنجاح",
                        type: "success",
                    });
                },
                error: function (res) {
                    if(res.responseJSON.errors.TheDate){
                        $("form #errors-TheDate").css('display' , 'block').text(res.responseJSON.errors.TheDate);
                    }else{
                        $("form #errors-TheDate").text('');
                    }
                    if(res.responseJSON.errors.amount_by_currency){
                        $("form #errors-amount_by_currency").css('display' , 'block').text(res.responseJSON.errors.amount_by_currency);
                    }else{
                        $("form #errors-amount_by_currency").text('');
                    }
                    if(res.responseJSON.errors.ThePayType){
                        $("form #errors-ThePayType").css('display' , 'block').text(res.responseJSON.errors.ThePayType);
                    }else{
                        $("form #errors-ThePayType").text('');
                    }
                    if(res.responseJSON.errors.currency){
                        $("form #errors-currency").css('display' , 'block').text(res.responseJSON.errors.currency);
                    }else{
                        $("form #errors-currency").text('');
                    }
                }
            });
            
        });
    });
    
</script>