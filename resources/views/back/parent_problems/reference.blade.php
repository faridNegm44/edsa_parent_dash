<form style="padding: 0px 30px;">
    @csrf
    <input id="res_id" type="hidden" value="{{ $find['id'] }}">

    <div class="form-group">
        <label style="margin: 10px 15px;">إسناد إلي</label>
        <select name="staff_id" id="staff_id" class="form-control select2_select2" style="width: 100%;">
                @if (auth()->user()->user_status == 4)
                    <option value="{{ auth()->user()->id }}">
                        {{ auth()->user()->name }}
                        ( موظف )
                    </option>
                @elseif (auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                    @foreach ($stuff as $item)
                        <option value="{{ $item->id }}" {{ $find['staff_id'] == $item->id ? 'selected' : null }}>
                            {{ $item->name }}
                                
                            @if ($item->user_status == 1)
                                ( سوبر أدمن	 )
                            @elseif ($item->user_status == 2)
                                ( أدمن )
                            @elseif ($item->user_status == 4)
                                ( موظف )
                            @endif
                        </option>
                    @endforeach
                @endif
        </select>
        <p class="errors" id="errors-staff_id"></p>
    </div>

    @if (auth()->user()->user_status == 1)
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label style="margin: 10px 15px;">تاريخ الإسناد</label>
                    <input type="datetime-local" class="form-control" name="date_reference" value="{{ $find['date_reference'] }}"/>
                    <p class="errors" id="errors-date_reference"></p>
                </div>

                <div class="col-md-6">
                    <label style="margin: 10px 15px;">تاريخ تسليم الطلب</label>
                    <input type="datetime-local" class="form-control" name="deadline" value="{{ $find['deadline'] == null ? "" : $find['deadline'] }}"/>
                    <p class="errors" id="errors-deadline"></p>
                </div>
        </div>
    @endif

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
                    $('#urgent').DataTable().ajax.reload( null, false );
                    $('#resolved').DataTable().ajax.reload( null, false );
                    $('#waiting').DataTable().ajax.reload( null, false );
                    $('#canceled').DataTable().ajax.reload( null, false );
                    $('#deadline_table').DataTable().ajax.reload( null, false );
                    $('#parent_table').DataTable().ajax.reload( null, false );

                    notif({
                        msg: "تم الإسناد بنجاح",
                        type: "success",
                    });

                    location.reload();

                },
                error: function (res) {
                    if(res.responseJSON.errors.staff_id){
                        $("form #errors-staff_id").css('display' , 'block').text(res.responseJSON.errors.staff_id);
                    }else{
                        $("form #errors-staff_id").text('');
                    }
                    if(res.responseJSON.errors.date_reference){
                        $("form #errors-date_reference").css('display' , 'block').text(res.responseJSON.errors.date_reference);
                    }else{
                        $("form #errors-date_reference").text('');
                    }
                    if(res.responseJSON.errors.deadline){
                        $("form #errors-deadline").css('display' , 'block').text(res.responseJSON.errors.deadline);
                    }else{
                        $("form #errors-deadline").text('');
                    }
                }
            });

        });
    });

</script>
