<form enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">
                <div class="col-md-6">
                    <label for="address">@lang('app.Address')</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                        </div>
                        <input class="form-control" id="address" name="address" placeholder="@lang('app.Address')" type="text">
                    </div>
                    <p class="errors" id="errors-address"></p>
                </div>

                <div class="col-md-6">
                    <label for="tags">@lang('app.Tags')</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-tags"></i></span>
                        </div>
                        <select class="form-control select2" id="tags" name="tags[]" multiple>
                            <option value="">-----</option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="errors" id="errors-tags"></p>
                </div>
                
                <div class="col-md-12">
                    <label for="description">@lang('app.Description')</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-text-height"></i></span>
                        </div>
                        <textarea class="form-control" name="description" id="description" placeholder="@lang('app.Description')"  cols="30" rows="5"></textarea>
                    </div>
                    <p class="errors" id="errors-description"></p>
                </div>

                <div class="col-md-12">
                    <div class="custom-file-container" data-upload-id="file">
                        <label>
                            @lang('app.File')
                            <a href="javascript:void(0)" class="custom-file-container__image-clear" title="@lang('app.Clear')">
                                <i class="fa fa-trash" style="color: #f35f5f;"></i>
                            </a>
                        </label>
                        <label class="custom-file-container__custom-file">
                            <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" aria-label="Choose File" name="file" />

                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                        </label>
                        <div class="custom-file-container__image-preview"></div>
                    </div>
                    <p class="errors" id="errors-image"></p>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn ripple btn-primary" id="save">@lang('app.Save')</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">@lang('app.Close')</button>
    </div>
</form>

<script>
    $('.modal-title').html("@lang('app.Add')");
    // File Upload
    var upload = new FileUploadWithPreview("file");

        
    $(document).ready(function(){

        $(".select2").select2({
            placeholder: "{{ trans('app.Select Tags') }}",
            dropdownParent: $('.modal'),
        });

        $(".modal #save").click(function(e) {
            e.preventDefault();
            let act = "{{ url('dashboard/posts/save') }}";
            
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
                        msg: "@lang('app.Completed Added Successfully')",
                        type: "success",
                    });
                },
                error: function (res) {
                    if(res.responseJSON.errors.address){
                        $("form #errors-address").css('display' , 'block').text(res.responseJSON.errors.address);
                    }else{
                        $("form #errors-address").text('');
                    }
                    if(res.responseJSON.errors.description){
                        $("form #errors-description").css('display' , 'block').text(res.responseJSON.errors.description);
                    }else{
                        $("form #errors-description").text('');
                    }
                    if(res.responseJSON.errors.tags){
                        $("form #errors-tags").css('display' , 'block').text(res.responseJSON.errors.tags);
                    }else{
                        $("form #errors-tags").text('');
                    }
                }
            });
            
        });
    });
    
</script>