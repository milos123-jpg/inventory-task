<!DOCTYPE html>
<html>
<head><title>Product Stock</title></head>
<body style="padding: 20px; font-family: sans-serif;">
    <h1>Product Inventory</h1>
    <hr>
    @foreach($products as $product)
        <div style="margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;">
            <h3>{{ $product->name }}</h3>
            <p>Stock: <strong>{{ $product->stock_quantity }}</strong></p>
            <form action="/buy/{{ $product->id }}" method="POST">
                @csrf
                <button type="submit">Buy Item</button>
            </form>
        </div>
    @endforeach
</body>
</html>