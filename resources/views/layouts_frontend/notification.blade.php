<script>
  $(document).ready(function() {
  
    @if (session('flash_message_err') != '')
    var errors = '<?php echo session("flash_message_err"); ?>';
        swal({
          html: '<div class="alert-danger">'+errors+'</div>',
        }).then((result) => {
          if (result.value) {
            window.history.back(); 
          }
        });
    @endif
    
    @if (session('flash_message_err_and_reload') != '')
    var errors = '<?php echo session("flash_message_err_and_reload"); ?>';
        swal({
          html: '<div class="alert-danger">'+errors+'</div>',
        }).then((result) => {
          if (result.value) {
            window.history.back();
          }
        });
    @endif
    
    @if (session('flash_message_err_special') != '')
    var errors = '<div class="alert-danger"><?php echo session("flash_message_err_special"); ?></div>';
    swal({
      html: errors,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'YES',
      cancelButtonText: 'NO',
    })
    .then((result) => {
      if (result.value) {
        window.location.href = baseURL + '/payment';
      }
    });
    @endif
    
    @if (session('flash_message_succ') != '')
    var success = '<?php echo session("flash_message_succ"); ?>';
        swal({
          html: '<div class="alert-success">'+success+'</div>',
        })
    @endif
    
    @if (session('flash_message_succ_special') != '')
    var success = '<?php echo session("flash_message_succ_special"); ?>';
      swal({
        html: '<div class="alert-success">'+success+'</div>',
      })
    .then((result) => {
      if (result.value) {
        window.location.href = baseURL + '/barcode/list/{{ Auth::user()->id }}';
      }
    });
    @endif
  
    @if(count($errors) > 0)
    var tempArray = <?php echo json_encode($errors->all()); ?>;
    var errors = '';
    $.each( tempArray, function( key, value) {
      errors += '<div class="alert-danger">'+value+'</div>';
    });
    swal({
      html: errors,
    }).then((result) => {
      if (result.value) {
        window.history.back(); 
      }
    });
    @endif
  })
</script>

@if(count($errors) > 0)
<div class="alert-danger" role="alert">
    <ul>
    </ul>
</div>
@endif

