@extends('shpcart::layouts.template')

<!-- Page Content -->
@section('content')
<div class="row">
	<div class="span9">
		<h1>{{ $product['name'] }}</h1>
	</div>
</div>

<hr>

<div class="row">
	<div class="span3">
		<img src="{{ asset('packages/madlymint/shpcart/products/' . $product['image']) }}" />
	</div>

	<div class="span6">
		<div class="span6">
			<address>
				<strong>Product Code:</strong> <span>{{ $product['id'] }}</span><br />
				<strong>Availability:</strong> <span>In Stock</span><br />
			</address>
		</div>

		<div class="span6">
			<h2>
				<strong>Price: ${{ format_number($product['price']) }}</strong><br /><br />
			</h2>
		</div>

		<div class="span8">
			<form class="form-horizontal" method="post" action="">
				<input type="hidden" name="item_id" id="item_id" value="{{ $product['id']}}" />

				@if (isset($product['options']))
					@foreach ($product['options'] as $option => $options)
					<div class="control-group">
						<label class="control-label text-align-left" for="options_{{ $option }}">{{ $option }}:</label>
					    <div class="controls">
							{{ Form::select('options[' . $option . ']', $options, null, array('id' => 'options_' . $option)) }}
						</div>
					</div>
					@endforeach
				@endif

				<div class="control-group">
    				<label class="control-label text-align-left" for="qty">Quantity:</label>
				    <div class="controls">
						<input type="text" class="span1" name="qty" id="qty" value="1">
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" name="action" value="add_to_cart" class="btn btn-primary">Add to Cart</button>
					<button type="submit" name="action" value="add_to_wishlist" class="btn btn-warning">Add to Wishlist</button>
				</div>
			</form>
		</div>
	  </div>
  </div>
  @endsection
