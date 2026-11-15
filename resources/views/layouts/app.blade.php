<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Northstar Shop')</title>
    <style>
        :root{font-family:system-ui,-apple-system,Segoe UI,sans-serif;color:#172033;background:#f6f7fb}*{box-sizing:border-box}body{margin:0}header{background:#14213d;color:white;padding:1rem max(1.25rem,calc((100% - 1100px)/2));display:flex;justify-content:space-between;align-items:center}header a{color:white;text-decoration:none;margin-left:1rem}main{max-width:1100px;margin:2rem auto;padding:0 1.25rem}.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1rem}.card,.panel{background:white;border-radius:12px;padding:1rem;box-shadow:0 2px 12px #17203312}.card img{width:100%;height:160px;object-fit:cover;border-radius:8px}.btn,button{display:inline-block;background:#1769aa;color:#fff;border:0;border-radius:7px;padding:.65rem 1rem;text-decoration:none;cursor:pointer}.muted{color:#697386}.row{display:flex;justify-content:space-between;gap:1rem;align-items:center}.field{display:block;margin:.8rem 0}.field input,.field textarea,.field select{display:block;width:100%;padding:.7rem;border:1px solid #ccd2dd;border-radius:6px}table{width:100%;border-collapse:collapse}td,th{text-align:left;padding:.75rem;border-bottom:1px solid #e5e8ef}.alert{padding:.8rem;background:#e8f5e9;border-radius:7px;margin-bottom:1rem}.error{color:#b42318}footer{text-align:center;padding:2rem;color:#697386}@media(max-width:600px){header{display:block}header nav{margin-top:.7rem}table{font-size:.9rem}}
    </style>
</head>
<body>
<header><a href="{{ route('store.index') }}"><strong>Northstar Shop</strong></a><nav><a href="{{ route('store.index') }}">Shop</a><a href="{{ route('cart.index') }}">Cart ({{ array_sum(session('cart', [])) }})</a></nav></header>
<main>
    @if (session('status'))<div class="alert">{{ session('status') }}</div>@endif
    @if ($errors->any())<div class="alert error"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @yield('content')
</main>
<footer>Northstar Shop · Secure checkout</footer>
</body>
</html>
