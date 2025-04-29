<form>
    @csrf
    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">
                <div class="col-md-6">
                    <label for="name">إسم التصنيف</label>
                    <div class="input-group mb-3">
                        <input class="form-control" id="name" name="name" placeholder="إسم التصنيف" type="text" value="" />
                    </div>
                    <p class="errors" id="errors-name"></p>
                </div>

                <div class="col-md-6">
                    <label for="rate">تقيم الطلب</label>
                    <select class="form-control rate" name="rate">
                        <option value="">---</option>
                        <option value="30">
                            سهلة
                        </option>
                        <option value="40">
                            أقل من المتوسط
                        </option>
                        <option value="50">
                            متوسط
                        </option>
                        <option value="90">
                            صعبـة
                        </option>
                        <option value="100">
                            صعبـة جدآ
                        </option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label style="" for="readed">إظهار لولي الأمر</label>
                    <input type="checkbox" name="show_to_parent" id="readed" value="1" style="position: relative;top: 5px; right: 10px;width: 20px;height: 20px;">
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
    $('.modal-title').html("إضافه تصنيف");

    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('.modal'),
        });

        $(".modal #save").click(function(e) {
            e.preventDefault();

            let act = "{{ url('dashboard/problem_types/store') }}";
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
                }
            });

        });
    });

</script>
