</div>
<!-- BEGIN PAGA BACKDROPS-->
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
    <div class="page-preloader">Loading</div>
</div>
<!-- END PAGA BACKDROPS-->
<!-- CORE PLUGINS-->

<script src="{{asset('/assets/admin/vendors/popper.js/dist/umd/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/vendors/metisMenu/dist/metisMenu.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/vendors/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript">
</script>

<!-- PAGE LEVEL PLUGINS-->


<!-- CORE SCRIPTS-->
<script src="{{asset('/assets/admin/js/app.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/admin/js/BsMultiSelect.bs4.min.js') }}" type="text/javascript"></script>
<!-- PAGE LEVEL SCRIPTS-->

<script>
    $('form').submit(function(e) {
            $('form button').attr('disabled', true);
        });

        // $(document).ready(function() {
        //     $(".alertMessage").delay(2000).slideUp(500);
        // });

</script>

</body>

</html>
