<script>
    $(document).on("click" , "table .delete" ,function(e){
      e.preventDefault();
      var res_id = $(this).attr("res_id");

      swal({
        title: "تحذير !!",
        text: "هل أنت متأكد من عمليه الحذف",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
                  url: "{{ url('dashboard/noti_to_class/destroy') }}"+'/'+res_id,
                  type: "get",
                  success: function(){
                    $('#example2').DataTable().ajax.reload( null, false );
                    
                    notif({
                        msg: "تم الحذف بنجاح",
                        type: "warning",
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
    
  $(document).on("click" , "table .delete_group_id" ,function(e){
      e.preventDefault();
      var res_group_id = $(this).attr("res_group_id");

      swal({
        // title: "تحذير !!",
        text: "هل أنت متأكد من حذف هذة المجموعة",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
                  url: "{{ url('dashboard/noti_to_class/destroy_group_id') }}"+'/'+res_group_id,
                  type: "get",
                  success: function(){
                    $('#example2').DataTable().ajax.reload( null, false );
                    
                    notif({
                        msg: "تم حذف المجموعة بنجاح",
                        type: "warning",
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