


<!-- Validation -->

<!-- Bootstrap Material Design JavaScript -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/material.js"></script>
<!-- Bootbox -->
<script type="text/javascript" src="{{url('/')}}/public/js/bootbox.js"></script>

<!-- ezdz -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/jquery.ezdz.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/jquery.min.js"></script>

<!-- tag -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/tag-input.min.js"></script>
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/dropdown-ui/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/dropdown-ui/jquery.quicksearch.js"></script>

<!-- Jasny  js  -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
<script>
// SideNav init
$(".button-collapse").sideNav();
  $(document).ready(function(){

	  $('#users').multiSelect({
          selectableOptgroup: true,

			selectableHeader: "<a href='#' id='select-all'>Select all</a><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search by Name or Tag'>",
  selectionHeader: "<a href='#' id='deselect-all'>Deselect all</a><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search to Unselect'>",
          afterInit: function(ms){

              var that = this,

                  $selectableSearch = that.$selectableUl.prev(),
                  $selectionSearch = that.$selectionUl.prev(),
                  selectableSearchString = '#'+that.$container.attr('id')+'  .ms-elem-selectable:not(.ms-selected)',
                  selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

              that.qs1 = $selectableSearch.quicksearch(selectableSearchString,{
                  'show': function () {
                     // alert('show');
                      $(this).prev(".ms-optgroup-label").show();
                      $(this).show();
                  },
                  'hide': function () {
                  //    alert('hide');
                      $(this).prev(".ms-optgroup-label").hide();
                      $(this).hide();
                  }
              })
                  .on('keydown', function(e){
                      if (e.which === 40){
                          that.$selectableUl.focus();
                          return false;
                      }
                  });

              that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                  .on('keydown', function(e){
                      if (e.which == 40){
                          that.$selectionUl.focus();
                          return false;
                      }
                  });
          },


  afterSelect: function(){
    this.qs1.cache();
    this.qs2.cache();
  },
  afterDeselect: function(){
    this.qs1.cache();
    this.qs2.cache();
  }
		});
	})
  $(document).on('click','#select-all',function(){
  $('#users').multiSelect('select_all');
  return false;
});
$(document).on('click','#deselect-all',function(){
  $('#users').multiSelect('deselect_all');
  return false;
});
// Custom scrollbar init
var el = document.querySelector('.custom-scrollbar');
Ps.initialize(el);
</script>

<!-- Toastr Script -->
<script>
toastr.options = {
"closeButton": true, // true/false
"debug": false, // true/false
"newestOnTop": false, // true/false
"progressBar": false, // true/false
"positionClass": "toast-top-right", // toast-top-right / toast-top-left / toast-bottom-right / toast-bottom-left
"preventDuplicates": false,
"onclick": null,
"showDuration": "2000", // in milliseconds
"hideDuration": "1000", // in milliseconds
"timeOut": "2000", // in milliseconds
"extendedTimeOut": "1000", // in milliseconds
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut"
}

</script>

{{-- <script src="{{ asset ('public/scripts/js/jquery.min.js')  }}" type="text/javascript"></script> --}}
<script src="{{ asset ('public/scripts/js/datatables.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/datatables.bootstrap.js')  }}" type="text/javascript"></script>
<script src="{{ asset('public/scripts/js/table-datatables-fixedheader.min.js')}}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/jquery.slimscroll.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/jquery.blockui.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/bootstrap-switch.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/morris.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/raphael-min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/app.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/dashboard.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/layout.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/demo.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/quick-sidebar.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset ('public/scripts/js/quick-nav.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset('public/scripts/js/ui-modals.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset('public/scripts/js/form-samples.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/scripts/js/lock.min.js') }}" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="{{ asset('public/scripts/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/scripts/js/components-select2.min.js') }}" type="text/javascript"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  {{-- <script src="{{ url('/public') }}/js/jquery.min.js" type="text/javascript"></script> --}}
  {{-- <script src="{{ url('/public') }}/js/material.js" type="text/javascript"></script> --}}
<script type="text/javascript">

</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN" : $('meta[name="csrf_token"]').attr('content'),
        },
        cache: false
    })

    $(document).ready(function(){
        $( "#datepicker" ).datepicker({
          showButtonPanel: true,
           "showAnim" : 'slideDown',
           "dateFormat":'mm/dd/yy',
        });
        $( "#edit_datepicker" ).datepicker({
          showButtonPanel: true,
           "showAnim" : 'slideDown',
           "dateFormat":'mm/dd/yy',
        });
        $('#send_push #schedule_dropdown').change(function(){
          $('#add-MN-schedule').toggle();
        })
        $('#edit_push #schedule_dropdown').change(function(){
          $('#schedule').toggle();
        })
    })
    function updateTemplate(){
            title = $('input[name="title"]').val()
            notification = $('textarea[name="notification"]').val()
            if(title == '' && notification == ''){
              $('#getTemplateDropdown').val($("#getTemplateDropdown option:first").val());
            }
        }
</script>
