<script>
    $(document).on("click" , "table .delete" ,function(e){
      e.preventDefault();
      var res_id = $(this).attr("res_id");

    //   سيتم حذف جميع التعليقات الخاصة بهذا الطلب

      swal({
        title: "تحذير !!",
        text: "هل أنت متأكد من عمليه الحذف ",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
                  url: "{{ url('dashboard/parent_problems/destroy') }}"+'/'+res_id,
                  type: "get",
                  success: function(){
                        $('#example2').DataTable().ajax.reload( null, false );
                        $('#urgent').DataTable().ajax.reload( null, false );
                        $('#resolved').DataTable().ajax.reload( null, false );
                        $('#waiting').DataTable().ajax.reload( null, false );
                        $('#canceled').DataTable().ajax.reload( null, false );
                        $('#parent_table').DataTable().ajax.reload( null, false );

                    notif({
                        msg: "تم الحذف بنجاح",
                        type: "error",
                    });

                    swal("تم الحذف بنجاح", {
                       icon: "success",
                    });

                  },
                  error: function(){

                  }
      });

      } else {
        return false;
      }
    });
  });
</script>
