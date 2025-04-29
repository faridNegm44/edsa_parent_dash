<form method="POST">
    @csrf
    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">
                <div class="col-md-12">
                    <label for="name">@lang('app.Name')</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                        </div>
                        <input class="form-control" id="name" name="name" placeholder="@lang('app.Name')" type="text" value="{{ $find->name }}">
                        <input type="hidden" id="res_id" value="{{ $find->id }}">
                    </div>
                    <p class="errors" id="errors-name"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn ripple btn-success" type="submit" id="update">@lang('app.Update')</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">@lang('app.Close')</button>
    </div>
</form>

<script>
    $('.modal-title').html("@lang('app.Edit')");

    $(document).ready(function(){
        $(".modal #update").click(function(e) {
            e.preventDefault();
            let id = $('#res_id').val();
            let act = "{{ url('dashboard/tags/update') }}"+"/"+id;

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
                        msg: "@lang('app.Completed Edit Successfully')",
                        type: "primary",
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