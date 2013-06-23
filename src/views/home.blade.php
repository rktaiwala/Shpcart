@extends('shpcart::layouts.template')

<!-- Page Content -->
@section('content')
<h3>Products</h3>

<div class="thumbnails">
@foreach ($products as $product)
	<div class="span3">
		<div class="thumbnail">
			<a href="{{ URL::to('cartview/' . Str::slug($product['name'])) }}"><img src="{{ asset('packages/madlymint/shpcart/products/' . $product['image']) }}" /></a>
			<div class="caption">
				<a href="{{ URL::to('cartview/' . Str::slug($product['name'])) }}"> <h5>{{ $product['name']}}</h5></a> Price: ${{ format_number($product['price']) }}
			</div>
		</div>
	</div>
@endforeach
</div>
@stop
