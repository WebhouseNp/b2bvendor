<!-- START HEADER-->
@include('admin.section.header')
<!-- END HEADER-->
<!-- START SIDEBAR-->
@include('admin.section.left-sidebar')
<!-- END SIDEBAR-->
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    @yield('content')
    <!-- END PAGE CONTENT-->
    @include('admin.section.copy-right')
</div>


@include('admin.section.footer')
@yield('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer {{ auth()->user()->api_token }}');
            }
        });
    });

</script>
@stack('push_scripts')
