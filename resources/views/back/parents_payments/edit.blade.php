<form enctype="multipart/form-data">
    @csrf
    <input id="res_id" type="hidden" value="{{ $find['ID'] }}">
    <input id="parent" name="parent" type="hidden" value="{{ $find['ParentID'] }}">
    
    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">
                @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                    <div class="col-md-12" style="margin-bottom: 10px;">
                        <label for="ParentID"> ولي الأمر</label>
                        <select name="ParentID" id="ParentID" class="form-control select2_select2" style="width: 100%;">
                            @foreach ($parents as $item)    
                                <option value="{{ $item->ID }}" {{ $item->ID  == $find['ParentID'] ? 'selected' : null }}>{{ $item->TheName0 }}</option>
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
                        <input class="form-control" id="TheDate" name="TheDate" placeholder="تاريخ الدفع" type="date" value="{{ $find['TheDate'] }}" />
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
                            <option value="حساب البنك الأهلي المصري" {{ $find['	ThePayType'] === 'حساب البنك الأهلي المصري' ? 'selected' : null }}>
                                حساب البنك الأهلي المصري
                            </option>
                            <option value="حساب البريد المصري" {{ $find['	ThePayType'] === 'حساب البريد المصري' ? 'selected' : null }}>
                                حساب البريد المصري
                            </option>
                            <option value="حساب بنك مصر" {{ $find['ThePayType'] === 'حساب بنك مصر' ? 'selected' : null }}>
                                حساب بنك مصر
                            </option>
                            <option value="حساب بنك CIB" {{ $find['ThePayType'] === 'حساب بنك CIB' ? 'selected' : null }}>
                                حساب بنك CIB
                            </option>
                            <option value="فودافون كاش" {{ $find['ThePayType'] === 'فودافون كاش' ? 'selected' : null }}>
                                فودافون كاش
                            </option>
                            <option value="تسليم نقدي" {{ $find['ThePayType'] === 'تسليم نقدي' ? 'selected' : null }}>
                                تسليم نقدي
                            </option>
                            <option value="CowPay" {{ $find['ThePayType'] === 'CowPay' ? 'selected' : null }}>
                                CowPay
                            </option>
                            <option value="غير ذلك" {{ $find['ThePayType'] === 'غير ذلك' ? 'selected' : null }}>
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
                        <input class="form-control" id="amount_by_currency" name="amount_by_currency" placeholder="المبلغ" type=number value="{{ $find['amount_by_currency'] }}"/>
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
                            <option value="ج مصري"  {{ $find['currency'] === 'ج مصري' ? 'selected' : null }}>
                                ج مصري
                            </option>
                            <option value="ريال" {{ $find['currency'] === 'ريال' ? 'selected' : null }}>
                                ريال
                            </option>
                            <option value="دينار" {{ $find['currency'] === 'دينار' ? 'selected' : null }}>
                                دينار
                            </option>
                            <option value="دولار" {{ $find['currency'] === 'دولار' ? 'selected' : null }}>
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
                        <input class="form-control" id="sender_name" name="sender_name" placeholder="إسم المرسل" type="text" value="{{ $find['sender_name'] }}" />
                    </div>
                    <p class="errors" id="errors-sender_name"></p>
                </div>

                <div class="col-md-6">
                    <label for="invoice_number">رقم الوصل</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                        </div>
                        <input class="form-control" id="invoice_number" name="invoice_number" placeholder="رقم الوصل" type="text" value="{{ $find['invoice_number'] }}" />
                    </div>
                    <p class="errors" id="errors-invoice_number"></p>
                </div>

                <div class="col-md-12">
                    <label for="TheNotes">ملاحظات ( ولي الأمر )</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                        </div>
                        <textarea class="form-control" id="TheNotes" name="TheNotes" rows="4" placeholder="ملاحظات ( ولي الأمر )" >{{ $find['TheNotes'] }}</textarea>
                    </div>
                    <p class="errors" id="errors-TheNotes"></p>
                </div>

                @if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                <div class="row" style="border: 1px solid red;border-radius: 10px 5px;padding: 10px 3px;margin: 20px 10px 30px;">
                    <div class="col-md-4">
                        <label for="status">الحاله</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-check"></i></span>
                            </div>
                            <select class="form-control" name="status" id="status">
                                <option value="مؤكد" {{ $find['status'] === 'مؤكد' ? 'selected' : null }}>
                                    مؤكد
                                </option>
                                <option value="غير مؤكد" {{ $find['status'] === 'غير مؤكد' ? 'selected' : null }}>
                                    غير مؤكد
                                </option>
                            </select>
                        </div>
                        <p class="errors" id="errors-status"></p>
                    </div>
                
                    <div class="col-md-4">
                        <label for="expense_price">سعر الصرف</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                            </div>
                            <input class="form-control" id="expense_price" name="expense_price" placeholder="سعر الصرف" type=number value="{{ $find['expense_price'] == null ? 1 : $find['expense_price'] }}"/>
                        </div>
                        <p class="errors" id="errors-expense_price"></p>
                    </div>
                                
                    <div class="col-md-4">
                        <label for="transfer_expense">القيمة المستلمة فعلياً</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                            </div>
                            <input class="form-control" id="transfer_expense" name="transfer_expense" placeholder="مبلغ التحويل" type="number" value="{{ $find['transfer_expense'] }}"/>
                        </div>
                        <p class="errors" id="errors-transfer_expense"></p>
                    </div>
                                
                    <div class="col-md-12">
                        <label for="TheAmount">مصاريف إدارية</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                            </div>
                            <input readonly class="form-control" id="TheAmount" name="TheAmount" placeholder="المبلغ النهائي" type="number" value="{{ $find['TheAmount'] == null ? $find['amount_by_currency'] : $find['TheAmount'] }}" style="background: #fff;"/>
                        </div>
                        <p class="errors" id="errors-TheAmount"></p>
                    </div>

                    <div class="col-md-12">
                        <label for="admin_notes">ملاحظات ( الإداره )</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4" placeholder="ملاحظات ( الإداره )">{{ $find['admin_notes'] }}</textarea>
                        </div>
                        <p class="errors" id="errors-admin_notes"></p>
                    </div>
                </div>
                @elseif (auth()->user()->user_status == 3)
                <div class="row" style="width: 100%;border: 1px solid red;border-radius: 10px 5px;padding: 10px 3px;margin: 20px 10px 30px;">
                    <div class="col-md-12">
                        <label for="admin_notes">ملاحظات ( الإداره للقراءه فقط !! )</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <textarea disabled readonly class="form-control" id="admin_notes" name="admin_notes" rows="4" style="background: #fff;">{{ $find['admin_notes'] }}</textarea>
                        </div>
                        <p class="errors" id="errors-admin_notes"></p>
                    </div>
                </div>
                @endif
                <div class="col-md-12">
                    <div class="custom-file-container" data-upload-id="file">
                        <label>
                            تحديث صوره الوصل
                            <a href="javascript:void(0)" class="custom-file-container__image-clear" title="حذف">
                                <i class="fa fa-trash" style="color: #f35f5f;margin: 0px 10px;"></i>
                            </a>
                        </label>
                        <label class="custom-file-container__custom-file">
                            <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" aria-label="Choose File" name="file" />
                            
                            <input type="hidden" name="default_file" value="{{ $find['image'] }}"/>

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
    @if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
        <div class="modal-footer">
            <button class="btn ripple btn-success" id="update">تعديل</button>
            <button class="btn ripple btn-default" data-dismiss="modal" type="button">إلغاء</button>
        </div>
    @else
        @if($find['status'] === 'غير مؤكد')
            <div class="modal-footer">
                <button class="btn ripple btn-success" id="update">تعديل</button>
                <button class="btn ripple btn-default" data-dismiss="modal" type="button">إلغاء</button>
            </div>
        @endif
    @endif
    
</form>

<style>
    table tbody tr{
        padding-top: 100px;
    }
</style>
<script>
    $('.modal-title').html("تعديل");
    var upload = new FileUploadWithPreview("file");
    
    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('#modaldemo8'),
        });

        // Change And Key Up expense_price
        $("#expense_price").change(function(){
            var this_val = $(this).val();
            var amount_by_currency = $("#amount_by_currency").val();
            var transfer_expense = $("#transfer_expense").val();

            $("#TheAmount").val(this_val*amount_by_currency-transfer_expense);

        });
        
        $("#expense_price").keyup(function(){
            var this_val = $(this).val();
            var amount_by_currency = $("#amount_by_currency").val();
            var transfer_expense = $("#transfer_expense").val();

            $("#TheAmount").val(this_val*amount_by_currency-transfer_expense);

        });

        // Change And Key Up transfer_expense
        $("#transfer_expense").change(function(){
            var this_val = $(this).val();
            var amount_by_currency = $("#amount_by_currency").val();
            var expense_price = $("#expense_price").val();

            $("#TheAmount").val(expense_price*amount_by_currency-this_val);

        });
        
        $("#transfer_expense").keyup(function(){
            var this_val = $(this).val();
            var amount_by_currency = $("#amount_by_currency").val();
            var expense_price = $("#expense_price").val();

            $("#TheAmount").val(expense_price*amount_by_currency-this_val);

        });
        
        // Change And Key Up amount_by_currency
        $("#amount_by_currency").change(function(){
            var this_val = $(this).val();
            var transfer_expense = $("#transfer_expense").val();
            var expense_price = $("#expense_price").val();

            $("#TheAmount").val(this_val*expense_price-transfer_expense);

        });
        
        $("#amount_by_currency").keyup(function(){
            var this_val = $(this).val();
            var transfer_expense = $("#transfer_expense").val();
            var expense_price = $("#expense_price").val();

            $("#TheAmount").val(this_val*expense_price-transfer_expense);

        });



        $(".modal #update").click(function(e) {
            e.preventDefault();
            let id = $('#res_id').val();            
            let act = "{{ url('dashboard/parents_payments/update') }}"+"/"+id;

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
                        msg: "تم التعديل بنجاح",
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