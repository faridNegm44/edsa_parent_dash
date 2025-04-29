<form>
    @csrf
    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">
                <div class="col-md-6">
                    <label for="name">الإسم</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input class="form-control" id="name" name="name" placeholder="الإسم" type="text" value="" />
                    </div>
                    <p class="errors" id="errors-name"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="email">البريد الإلكتروني</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        </div>
                        <input class="form-control" id="email" name="email" placeholder="البريد الإلكتروني" type="email">
                    </div>
                    <p class="errors" id="errors-email"></p>
                </div>
                                
                <div class="col-md-6">
                    <label for="password">الرقم السري</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                        </div>
                        <input class="form-control" id="password" name="password" placeholder="الرقم السري" type="password">
                    </div>
                    <p class="errors" id="errors-password"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="confirm_password">تأكيد الرقم السري</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                        </div>
                        <input class="form-control" id="confirm_password" name="confirm_password" placeholder="تأكيد الرقم السري" type="password">
                    </div>
                    <p class="errors" id="errors-confirm_password"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn ripple btn-primary" id="save">حفظ</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">إلغاء</button>
    </div>
</form>

<script>
    $('.modal-title').html("إضافه مستخدم");

    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('.modal'),
        });

        $(".modal #save").click(function(e) {
            e.preventDefault();
            
            let act = "{{ url('dashboard/users/store') }}";
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
                        msg: "تمت الإضافه بنجاح",
                        type: "success",
                    });
                },
                error: function (res) {
                    if(res.responseJSON.errors.name){
                        $("form #errors-name").css('display' , 'block').text(res.responseJSON.errors.name);
                    }else{
                        $("form #errors-name").text('');
                    }
                    if(res.responseJSON.errors.email){
                        $("form #errors-email").css('display' , 'block').text(res.responseJSON.errors.email);
                    }else{
                        $("form #errors-email").text('');
                    }
                    if(res.responseJSON.errors.password){
                        $("form #errors-password").css('display' , 'block').text(res.responseJSON.errors.password);
                    }else{
                        $("form #errors-password").text('');
                    }
                    if(res.responseJSON.errors.confirm_password){
                        $("form #errors-confirm_password").css('display' , 'block').text(res.responseJSON.errors.confirm_password);
                    }else{
                        $("form #errors-confirm_password").text('');
                    }
                }
            });
            
        });
    });
    
</script>