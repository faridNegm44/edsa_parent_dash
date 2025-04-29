@if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
    <form>
        @csrf
        <input id="res_id" type="hidden" value="{{ $first['id'] }}">
        <div class="modal-body">
            <div class="pd-30 pd-sm-40 bg-gray-100">
                <div class="row row-xs">
                    <div class="col-md-6">
                        <label for="class_id">
                            الصفوف الدراسية
                        </label>
                        <select class="form-control select2_select2" id="class_id" name="class_id" style="width: 100%;">
                            @foreach ($the_year as $item)
                                <option value="{{ $item->YearID }}" {{ $first['class_id'] == $item->YearID ? 'selected' : null}}>
                                    {{ $item->TheMat . ' -'. $item->TheYear }}
                                </option>
                            @endforeach
                        </select>
                        <p class="errors" id="errors-class_id"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="status">
                            الحالة
                        </label>
                        <select class="form-control" id="status" name="status" style="width: 100%;">
                            <option value="1" {{ $first['status'] == 1 ? 'selected' : null}}>
                                مفعل
                            </option>
                            
                            <option value="2" {{ $first['status'] == 2 ? 'selected' : null}}>
                                غير مفعل
                            </option>
                        </select>
                        <p class="errors" id="errors-status"></p>
                    </div>
                    
                    <div class="col-md-12" style="margin-top: 15px;">
                        <label for="title">عنوان الرسالة</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <input class="form-control" id="title" name="title" placeholder="عنوان الرسالة" type="text" value="{{ $first['title'] }}" />
                        </div>
                        <p class="errors" id="errors-title"></p>
                    </div>

                    <div class="col-md-12">
                        <label for="description">وصف الرسالة</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <textarea class="form-control" id="description" name="description" placeholder="وصف الرسالة" rows="8">{{ $first['description'] }}</textarea>
                        </div>
                        <p class="errors" id="errors-description"></p>
                    </div>        

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn ripple btn-success" id="update">تعديل</button>
            <button class="btn ripple btn-default" data-dismiss="modal" type="button">إلغاء</button>
        </div>
    </form>
@elseif(auth()->user()->user_status == 3)
    <form>
        @csrf
        <input id="res_id" type="hidden" value="{{ $first['id'] }}">
        <div class="modal-body">
            <div class="pd-30 pd-sm-40 bg-gray-100">
                <div class="row row-xs">                    
                    <div class="col-md-12">
                        <label for="title">عنوان الرسالة</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <input class="form-control" id="title" name="title" readonly placeholder="عنوان الرسالة" type="text" value="{{ $first['title'] }}"  style="background: #fff;" />
                        </div>
                        <p class="errors" id="errors-title"></p>
                    </div>

                    <div class="col-md-12">
                        <label for="description">وصف الرسالة</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <textarea class="form-control" id="description" readonly ame="description" placeholder="وصف الرسالة" rows="8" style="background: #fff;" >{{ $first['description'] }}</textarea>
                        </div>
                        <p class="errors" id="errors-description"></p>
                    </div>        

                </div>
            </div>
        </div>
    </form>
@endif
<script>
    @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
        $('.modal-title').html("تعديل");
    @elseif(auth()->user()->user_status == 3)
        $('.modal-title').html("عرض");
    @endif
    
    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('.modal'),
        });

        $(".modal #update").click(function(e) {
            e.preventDefault();
            let id = $('#res_id').val();            
            let act = "{{ url('dashboard/noti_to_class/update') }}"+"/"+id;

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
                    if(res.responseJSON.errors.class_id){
                        $("form #errors-class_id").css('display' , 'block').text(res.responseJSON.errors.class_id);
                    }else{
                        $("form #errors-class_id").text('');
                    }
                    if(res.responseJSON.errors.title){
                        $("form #errors-title").css('display' , 'block').text(res.responseJSON.errors.title);
                    }else{
                        $("form #errors-title").text('');
                    }
                    if(res.responseJSON.errors.description){
                        $("form #errors-description").css('display' , 'block').text(res.responseJSON.errors.description);
                    }else{
                        $("form #errors-description").text('');
                    }
                }
            });
            
        });
    });
    
</script>