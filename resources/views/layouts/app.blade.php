<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.header')
</head>
<body>
    <!-- Header & Menu -->
    @include('layouts.menu')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.footer')
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>