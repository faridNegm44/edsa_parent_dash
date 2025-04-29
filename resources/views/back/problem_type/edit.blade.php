<form>
    @csrf
    <input id="res_id" type="hidden" value="{{ $find['id'] }}">

    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">
                <div class="col-md-6">
                    <label for="name">إسم التصنيف</label>
                    <div class="input-group mb-3">
                        <input class="form-control" id="name" name="name" placeholder="إسم التصنيف" type="text" value="{{ $find['name'] }}" />
                    </div>
                    <p class="errors" id="errors-name"></p>
                </div>

                <div class="col-md-6">
                    <label for="rate">تقيم الطلب</label>
                    <select class="form-control rate" name="rate">
                        <option value="">---</option>
                        <option value="30" {{ $find['rate'] == 30 ? 'selected' : null }}>
                            سهلة
                        </option>
                        <option value="40" {{ $find['rate'] == 40 ? 'selected' : null }}>
                            أقل من المتوسط
                        </option>
                        <option value="50" {{ $find['rate'] == 50 ? 'selected' : null }}>
                            متوسط
                        </option>
                        <option value="90" {{ $find['rate'] == 90 ? 'selected' : null }}>
                            صعبـة
                        </option>
                        <option value="100" {{ $find['rate'] == 100 ? 'selected' : null }}>
                            صعبـة جدآ
                        </option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label style="" for="readed">إظهار لولي الأمر</label>
                    <input type="checkbox" name="show_to_parent" id="readed" value="1" style="position: relative;top: 5px; right: 10px;width: 20px;height: 20px;" {{ $find['show_to_parent']  == 1 ? 'checked' : null }}>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn ripple btn-success" id="update">تعديل</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">إلغاء</button>
    </div>
</form>


<script>
    $('.modal-title').html("تعديل تصنيف طلب");

    $(document).ready(function(){

        $(".modal #update").click(function(e) {
            e.preventDefault();
            let id = $('#res_id').val();
            let act = "{{ url('dashboard/problem_types/update') }}"+"/"+id;

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
