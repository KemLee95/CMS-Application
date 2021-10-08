<script src="/assets/js/jquery.min.js"></script>

{{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> --}}

<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/toastr.min.js"></script>
<script src="/assets/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "10000",
            "extendedTimeOut": "10000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "slideDown",
            "hideMethod": "fadeOut",
        };

        if($('meta[name="error"]').length) {
            toastr.error($("meta[name='error']").attr('message'), $("meta[name='error']").attr('message_title'));
        }

        if($('meta[name="success"]').length) {
            toastr.success($('meta[name="success"]').attr('message'));
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
  });

</script>