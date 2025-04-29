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
                  url: "{{ url('dashboard/parents_payments/destroy') }}"+'/'+res_id,
                  type: "get",
                  success: function(){
                    $('#example2').DataTable().ajax.reload( null, false );
                    
                    notif({
                        msg: "تم الحذف بنجاح",
                        type: "warning",
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