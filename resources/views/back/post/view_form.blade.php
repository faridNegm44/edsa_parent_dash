<div class="col-xl-12">
    <div class="row">
        <div class="col-md-8 data">
            1111
        </div>
        
        <div class="col-md-4 file">
            <div class="card overflow-hidden">
                <img class="card-img-top" src="{{ url('back/images/posts/'.$find->image) }}" alt="img">
            </div>
        </div>
    </div>
</div>


<script>
    $('.modal-title').html("@lang('app.View')");
    // File Upload
    // var upload = new FileUploadWithPreview("file");

        
    // $(document).ready(function(){

    //     $(".select2").select2({
    //         placeholder: "{{ trans('app.Select Tags') }}",
    //         dropdownParent: $('.modal'),
    //     });

    //     $(".modal #save").click(function(e) {
    //         e.preventDefault();
    //         let act = "{{ url('dashboard/posts/save') }}";
            
    //         $.ajax({
    //             type: "post",
    //             headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
    //             url: act,
    //             processData: false,
    //             contentType: false,
    //             data: new FormData($(".modal form")[0]),
    //             success: function (res) {
    //                 $('input').val('');
    //                 $('.modal').modal('hide');
    //                 $('#example2').DataTable().ajax.reload( null, false );
                    
    //                 notif({
    //                     msg: "@lang('app.Completed Added Successfully')",
    //                     type: "success",
    //                 });
    //             },
    //             error: function (res) {
    //                 if(res.responseJSON.errors.address){
    //                     $("form #errors-address").css('display' , 'block').text(res.responseJSON.errors.address);
    //                 }else{
    //                     $("form #errors-address").text('');
    //                 }
    //                 if(res.responseJSON.errors.description){
    //                     $("form #errors-description").css('display' , 'block').text(res.responseJSON.errors.description);
    //                 }else{
    //                     $("form #errors-description").text('');
    //                 }
    //                 if(res.responseJSON.errors.tags){
    //                     $("form #errors-tags").css('display' , 'block').text(res.responseJSON.errors.tags);
    //                 }else{
    //                     $("form #errors-tags").text('');
    //                 }
    //             }
    //         });
            
    //     });
    // });
    
</script>