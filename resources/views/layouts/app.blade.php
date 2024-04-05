<!DOCTYPE html>
<html lang="en">

@include('layouts.includes.header')

<body>
    @include('layouts.includes.nav')

    @yield('content')

    @include('layouts.includes.footer')
</body>

</html>