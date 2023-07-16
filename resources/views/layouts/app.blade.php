<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{--@if (Auth::user() && Auth::user()->isactive == '1')--}}
@include('layouts.header')
{{--    @include('layouts.sidebar')--}}
{{--@endif--}}
<body>
<div class="container-scroller">
    @include('layouts.sidebar')
    <div class="container-fluid page-body-wrapper">
        @include('layouts.nav')
        <div class="main-panel">
            <div class="content-wrapper">
{{--                <div class="page-header">--}}
{{--                    <h3 class="page-title">Form elements</h3>--}}
{{--                    <nav aria-label="breadcrumb">--}}
{{--                        <ol class="breadcrumb">--}}
{{--                            <li class="breadcrumb-item"><a--}}
{{--                                    href="https://www.bootstrapdash.com/demo/breeze-free/template/pages/forms/basic_elements.html#">Forms</a>--}}
{{--                            </li>--}}
{{--                            <li class="breadcrumb-item active" aria-current="page"> Form elements</li>--}}
{{--                        </ol>--}}
{{--                    </nav>--}}
{{--                </div>--}}
{{--                <div class="row">--}}

{{--                    <main class="py-4">--}}
                        @yield('content')
{{--                    </main>--}}
{{--                </div>--}}
            </div>
            @include('layouts.footer')
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"--}}
{{--        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"--}}
{{--        crossorigin="anonymous"></script>--}}
<script src="js/vendor.bundle.base.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/typeahead.bundle.min.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/misc.js"></script>
<script src="js/file-upload.js"></script>
<script src="js/typeahead.js"></script>
<script src="js/select2.js"></script>
</body>
</html>
