<form>
    @csrf
    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">
                <div class="col-md-6">
                    <div class="col-x-12">
                        <label for="parent_id">
                            أولياء الأمور
                            <span style="float: left;position: absolute;left: 5px;">
                                <label for="check_all_parents"> إختيار الكل </label>
                                <input type="checkbox" class="check_all_parents" id="check_all_parents" style="margin: 0px 7px;position: relative;top: 3px;"/>
                            </span>
                        </label>
                        <select class="form-control select2_select2" id="parent_id" name="parent_id[]" multiple style="width: 100%;">
                            @foreach (\DB::table('tbl_parents')->get() as $item)
                            <option value="{{ $item->ID }}">
                                {{ $item->TheName0 }}
                            </option>
                            @endforeach
                        </select>
                        <p class="errors" id="errors-parent_id"></p>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="col-xs-12">
                        <label for="title">عنوان الرسالة</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <input class="form-control" id="title" name="title" placeholder="عنوان الرسالة" type="text" value="" />
                        </div>
                        <p class="errors" id="errors-title"></p>
                    </div>
                                    
                    <div class="col-xs-12">
                        <label for="description">وصف الرسالة</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                            <textarea class="form-control" id="description" name="description" placeholder="وصف الرسالة" rows="8"></textarea>
                        </div>
                        <p class="errors" id="errors-description"></p>
                    </div>              
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
    $('.modal-title').html("إضافه");

    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('.modal'),
        });


        $("#check_all_parents").click(function(){
            if($(this).is(':checked')){
                var selectedItems = [];
                var allOptions = $("#parent_id option");
                allOptions.each(function() {
                    selectedItems.push( $(this).val() );
                });
                $("#parent_id").val(selectedItems).trigger("change"); 

                notif({
                    msg: "تم إختيار جميع أولياء الأمور",
                    type: "success",
                });

            }else{
                var selectedItems = [];
                var allOptions = $("#parent_id option");
                allOptions.each(function() {
                    selectedItems.pop( $(this).val() );
                });
                $("#parent_id").val(selectedItems).trigger("change"); 

                notif({
                    msg: "تم حذف إختيارك لجميع أولياء الأمور",
                    type: "warning",
                });

            }
        });


        $(".modal #save").click(function(e) {
            e.preventDefault();
            
            let act = "{{ url('dashboard/noti_to_parent/store') }}";
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
                    if(res.responseJSON.errors.parent_id){
                        $("form #errors-parent_id").css('display' , 'block').text(res.responseJSON.errors.parent_id);
                    }else{
                        $("form #errors-parent_id").text('');
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