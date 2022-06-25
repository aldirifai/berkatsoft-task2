 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>

 @if ($errors->any())
     <div id="ERROR_COPY" style="display: none;" class="alert alert-danger">
         @foreach ($errors->all() as $error)
             <h6>{{ $error }}</h6>
         @endforeach
     </div>
 @endif


 <script>
     $(document).ready(function() {
         var cekError = {{ $errors->any() > 0 ? 'true' : 'false' }};
         var ht = $("#ERROR_COPY").html();
         if (cekError) {
             Swal.fire({
                 title: 'Errors',
                 icon: 'error',
                 html: ht,
                 showCloseButton: true,
             });
         }
     });

     function fungsiHapus(form) {
         event.preventDefault(); // prevent form submit

         Swal.fire({
             title: 'Apakah kamu yakin ?',
             text: "Data akan dihapus dari database",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: "Ya, Hapus !",
             cancelButtonText: "Batal",
             closeOnConfirm: false,
             closeOnCancel: false
         }).then((result) => {
             if (result.value) {
                 form.submit();
             } else if (
                 /* Read more about handling dismissals below */
                 result.dismiss === Swal.DismissReason.cancel
             ) {
                 Swal.fire(
                     'Dibatalkan !',
                     'Data tidak berhasil terhapus',
                     'error'
                 )
             }
         });
     }
 </script>
