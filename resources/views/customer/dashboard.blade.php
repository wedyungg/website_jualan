<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
</head>
<body>
    <h1>Customer Dashboard - Fokuskesini</h1>
    <p>Welcome, {{ auth()->user()->name }}</p>
    <p>Role: {{ auth()->user()->role }}</p>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>