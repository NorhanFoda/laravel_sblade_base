<!--   Core JS Files   -->
<script src="{{asset('UI/assets/v1/js/core/popper.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('UI/assets/v1/js/core/bootstrap.min.js')}}"></script>
<script src="{{asset('UI/assets/v1/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('UI/assets/v1/js/plugins/smooth-scrollbar.min.js')}}"></script>
<script>
  var win = navigator.platform.indexOf("Win") > -1;
  if (win && document.querySelector("#sidenav-scrollbar")) {
    var options = {
      damping: "0.5",
    };
    Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
  }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{asset('UI/assets/v1/js/material-dashboard.min.js?v=3.1.0')}}"></script>

{{-- select2 --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

{{-- toaster --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
    
  $(document).ready(function() {
      $('.select2').select2({
          placeholder: "Select an option", // Optional: Add a placeholder
          allowClear: true                  // Optional: Add a clear button
      });
  });

</script>