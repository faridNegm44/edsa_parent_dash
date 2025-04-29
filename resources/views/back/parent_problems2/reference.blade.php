<form>
    @csrf
    <input id="res_id" type="hidden" value="{{ $find['id'] }}">

    <div class="form-group">
        <select name="staff_id" id="staff_id" class="form-control select2_select2" style="width: 100%;">
            @foreach ($stuff as $item)
                <option value="{{ $item->id }}" {{ $find['staff_id'] == $item->id ? 'selected' : null }}>
                    {{ $item->name }}
                        --
                    @if ($item->user_status == 1)
                        ( سوبر أدمن	 )
                    @elseif ($item->user_status == 2)
                        ( أدمن )
                    @elseif ($item->user_status == 4)
                        ( موظف )
                    @endif
                </option>
            @endforeach
        </select>
        <p class="errors" id="errors-staff_id"></p>
    </div>

    <div class="modal-footer">
        <button class="btn ripple btn-primary" id="save">إسناد</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">إلغاء</button>
    </div>
</form>


<script>
    $('.modal-title').html("إسناد إلي");

    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('.modal'),
        });

        $(".modal #save").click(function(e) {
            e.preventDefault();

            let id = $('#res_id').val();
            let act = "{{ url('dashboard/parent_problems/reference/store') }}"+"/"+id;

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
                        msg: "تم الإسناد بنجاح",
                        type: "success",
                    });
                },
                error: function (res) {
                    if(res.responseJSON.errors.staff_id){
                        $("form #errors-staff_id").css('display' , 'block').text(res.responseJSON.errors.staff_id);
                    }else{
                        $("form #errors-staff_id").text('');
                    }
                }
            });

        });
    });

</script>
