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
 * The cart main page.
 */
class ShpCartController extends \Illuminate\Routing\Controllers\Controller
{
	/**
	 * Flag for whether the controller is RESTful.
	 *
	 * @access   public
	 * @var      boolean
	 */
	public $restful = true;

	/**
	 * Shows the cart contents.
	 *
	 * @access   public
	 * @return   void
	 */
	public function getIndex()
	{
		// Get the cart contents.
		//
		$cart_contents = Shpcart::cart()->contents();

		// Show the page.
		//
		return View::make('shpcart::cart.index')->with('cart_contents', $cart_contents);
	}

	/**
	 * Updates or empties the cart contents.
	 *
	 * @access   public
	 * @return   void
	 */
	public function postIndex()
	{
		// If we are updating the items information.
		//
		if (Input::get('update'))
		{
			try
			{
				// Get the items to be updated.
				//
				$items = array();
				foreach(Input::get('items') as $rowid => $qty)
				{
					$items[] = array(
						'rowid' => $rowid,
						'qty'   => $qty
					);
				}

				// Update the cart contents.
				//
				Shpcart::cart()->update($items);
			}

			// Is the Item Row ID valid?
			//
			catch (Shpcart\CartInvalidItemRowIdException $e)
			{
				// Redirect back to the shopping cart page.
				//
				return Redirect::to('cart')->with('error', 'Invalid Item Row ID!');
			}

			// Does this item exists on the shopping cart?
			//
			catch (Shpcart\CartItemNotFoundException $e)
			{
				// Redirect back to the shopping cart page.
				//
				return Redirect::to('cart')->with('error', 'Item was not found in your shopping cart!');
			}

			// Is the item quantity valid?
			//
			catch (Shpcart\CartInvalidItemQuantityException $e)
			{
				// Redirect back to the shopping cart page.
				//
				return Redirect::to('cart')->with('error', 'Invalid item quantity!');
			}

			// Redirect back to the shopping cart page.
			//
			return Redirect::to('cart')->with('success', 'Your shopping cart was updated.');
		}

		// If we are emptying the cart.
		//
		elseif (Input::get('empty'))
		{
			// Let's clear the shopping cart!
			//
			Shpcart::cart()->destroy();

			// Redirect back to the shopping cart page.
			//
			return Redirect::to('cart')->with('success', 'Your shopping cart was cleared!');
		}
	}

	/**
	 * Removes an item from the shopping cart.
	 *
	 * @access   public
	 * @param    string
	 * @return   void
	 */
	public function getRemove($item_id = null)
	{
		try
		{
			// Remove the item from the cart.
			//
			Shpcart::cart()->remove($item_id);
		}

		// Is the Item Row ID valid?
		//
		catch (Shpcart\CartInvalidItemRowIdException $e)
		{
			// Redirect back to the shopping cart page.
			//
			return Redirect::to('cart')->with('error', 'Invalid Item Row ID!');
		}

		// Does this item exists on the shopping cart?
		//
		catch (Shpcart\CartItemNotFoundException $e)
		{
			// Redirect back to the shopping cart page.
			//
			return Redirect::to('cart')->with('error', 'Item was not found in your shopping cart!');
		}

		// Other error.
		//
		catch (Shpcart\CartException $e)
		{
			// Redirect back to the home page.
			//
			return Redirect::to('cart')->with('error', 'An unexpected error occurred!');
		}

		// Redirect back to the shopping cart page.
		//
		return Redirect::to('cart')->with('success', 'The item was removed from the shopping cart.');
	}
}