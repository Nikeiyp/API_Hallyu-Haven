<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <script src="{{ asset('asset/js/apps.js') }}" defer></script>
    
</head>
<body>
    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('components.footer')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function logout() {
            axios.post("{{ url('/logout') }}", {}, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                window.location.href = '/login';
            }).catch(error => {
                alert('Logout gagal!');
                console.error(error);
            });
        }
    </script>

    @stack('scripts')

</body>
</html>
