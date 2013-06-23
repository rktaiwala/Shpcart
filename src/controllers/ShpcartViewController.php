<?php namespace Madlymint\Shpcart;

#############################################################
############ This file is for the examples only! ############
#############################################################


/**
 * Libraries we can use.
 */
use Shpcart\Model\Products;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
/**
 * The product information page.
 */
class ShpcartViewController extends \Illuminate\Routing\Controllers\Controller
{
	/**
	 * Flag for whether the controller is RESTful.
	 *
	 * @access   public
	 * @var      boolean
	 */
	public $restful = true;

	/**
	 * Shows the product information page.
	 *
	 * @access   public
	 * @param    string
	 * @return   Redirect
	 */
	public function getIndex($product_slug = null)
	{
		// Check if the product exists.
		//
		if ( ! $product = Products::find($product_slug))
		{
			// Redirect back to the home page.
			//
			return Redirect::to('shpcart')->with('error', 'The product does not exist!');
		}

		// Show the page.
		//
		return View::make('shpcart::view')->with('product', $product);
		//return "hello";
	}

	/**
	 * Adds a product to the shopping cart or to the wishlist.
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function postIndex()
	{
		// Get the action, this basically tells what button was pressed.
		//
		$action = Input::get('action');

		// Get the static list of products.
		//
		$products = Products::all();

		// Retrieve some data.
		//
		$item_id = Input::get('item_id');
		$qty     = Input::get('qty');
		$options = Input::get('options', array());

		// Get the product information.
		//
		$info = $products[ $item_id ];

		// Populate a proper item array.
		//
		$item = array(
			'id'      => $info['id'],
			'qty'     => $qty,
			'price'   => $info['price'],
			'name'    => $info['name'],
			'image'   => $info['image'],
			'options' => $options
		);

		// Do we want to add the item to the wishlist?
		//
		if ($action === 'add_to_wishlist')
		{
			try
			{
				// Add the item to the wishlist.
				//
				Shpcart::wishlist()->insert($item);
			}

			// Check if we have invalid data passed.
			//
			catch (Shpcart\CartInvalidDataException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'Invalid data passed.');
			}

			// Check if we a required index is missing.
			//
			catch (Shpcart\CartRequiredIndexException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', $e->getMessage());
			}

			// Check if the quantity is invalid.
			//
			catch (Shpcart\CartInvalidItemQuantityException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'Invalid item quantity.');
			}

			// Check if the item row id is invalid.
			//
			catch (Shpcart\CartInvalidItemRowIdException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'Invalid item row id.');
			}

			// Check if the item name is invalid.
			//
			catch (Shpcart\CartInvalidItemNameException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'Invalid item name.');
			}

			// Check if the item price is invalid.
			//
			catch (Shpcart\CartInvalidItemPriceException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'Invalid item price.');
			}

			// Maybe we want to catch all the errors? Sure.
			//
			catch (Shpcart\CartException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'An unexpected error occurred!');
			}

			// Redirect to the wishlist page.
			//
			return Redirect::to('wishlist')->with('success', 'The item was added to your wishlist!');
		}

		// Do we want to add the item to the shopping cart?
		//
		elseif ($action === 'add_to_cart')
		{
			try
			{
				// Add the item to the shopping cart.
				//
				Shpcart::cart()->insert($item);
			}

			// Check if we have invalid data passed.
			//
			catch (Shpcart\CartInvalidDataException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'Invalid data passed.');
			}

			// Check if we a required index is missing.
			//
			catch (Shpcart\CartRequiredIndexException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', $e->getMessage());
			}

			// Check if the quantity is invalid.
			//
			catch (Shpcart\CartInvalidItemQuantityException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'Invalid item quantity.');
			}

			// Check if the item row id is invalid.
			//
			catch (Shpcart\CartInvalidItemRowIdException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'Invalid item row id.');
			}

			// Check if the item name is invalid.
			//
			catch (Shpcart\CartInvalidItemNameException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'Invalid item name.');
			}

			// Check if the item price is invalid.
			//
			catch (Shpcart\CartInvalidItemPriceException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'Invalid item price.');
			}

			// Maybe we want to catch all the errors? Sure.
			//
			catch (Shpcart\CartException $e)
			{
				// Redirect back to the home page.
				//
				return Redirect::to('shpcart')->with('error', 'An unexpected error occurred!');
			}

			// Redirect to the cart page.
			//
			return Redirect::to('cart')->with('success', 'The item was added to your shopping cart!');
		}

		// Invalid action, redirect to the home page.
		//
		return Redirect::to('shpcart');
	}
}