@extends('shpcart::layouts.template')

<!-- Page Content -->
@section('content')
	<h3>Wishlist Contents</h3>
	<table class="table table-hover table-striped table-bordered">
		<thead>
			<tr>
				<th width="6%"></th>
				<th width="60%">Name</th>
				<th width="12%">Price</th>
			</tr>
		</thead>
		<tbody>
			@foreach (Shpcart::wishlist()->contents() as $item)
			<!-- Get the product options, you should get product related options on your controller ! -->
			<?php $product_options = Shpcart\Model\Products::get_options($item['id']); ?>

			<tr>
				<td>
					<span class="span1 thumbnail"><img src="{{ asset('packages/madlymint/shpcart/products/' . $item['image']) }}" /></span>
				</td>
				<td>
					<strong><a href="{{ URL::to('shpcart/view/' . Str::slug($item['name'])) }}">{{ $item['name'] }}</a></strong>

					<span class="pull-right">
						<a href="{{ URL::to('wishlist/add_to_cart/' . $item['rowid']) }}" xdata-target="#AddToCartModel" data-rowid="{{ $item['rowid'] }}" data-toggle="modal" class="btn btn-mini btn-info add_to_cart" rel="tooltip" title="Add to the Shopping Cart"><i class="icon icon-white icon-shopping-cart"></i></a>
						<a href="{{ URL::to('wishlist/remove/' . $item['rowid']) }}" rel="tooltip" title="Remove the product." class="btn btn-mini btn-danger"><i class="icon icon-white icon-remove"></i></a>
					</span>

					<!-- Check if this cart item has options. -->
					@if (Shpcart::wishlist()->has_options($item['rowid']))
					<small>
						<ul class="unstyled">
						@foreach ($item['options'] as $option_name => $option_value)
							<li>- <small>{{ $option_name }}: {{ array_get($product_options, $option_name . '.' . $option_value) }}</small></li>
						@endforeach
						</ul>
					</small>
					@endif
				</td>
				<td>{{ format_number($item['price']) }}</td>
			</tr>
			@empty
			<tr>
				<td colspan="3">Your wishlist is empty.</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	@if (Shpcart::wishlist()->total())
	<form method="post" action="{{ URL::to('wishlist') }}" class="form-horizontal">
		<button type="submit" id="empty" name="empty" value="1" class="btn btn-warning">Empty your Wishlist</button>
	</form>
	@endif
@endsection
