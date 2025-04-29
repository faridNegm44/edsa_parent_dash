$(document).on('click', '#example2 #delete', function(e){
    e.preventDefault();
    let res_id = $(this).attr('res_id');
    let url = "{{ url('/delete') }}"+"/"+res_id;

    alert(url);

    {{-- $.ajax({
        type: 'delete',
        headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        url: url,
        success: function(){

        }
    }); --}}
});
