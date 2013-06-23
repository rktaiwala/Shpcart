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
 * The wishlist page.
 */
class ShpcartWishlistController extends \Illuminate\Routing\Controllers\Controller
{
	/**
	 * Flag for whether the controller is RESTful.
	 *
	 * @access   public
	 * @var      boolean
	 */
	public $restful = true;

	/**
	 * Show a list of the products on the wishlist.
	 *
	 * @access   public
	 * @return   void
	 */
	public function getIndex()
	{
		// Show the page.
		//
		return View::make('shpcart::wishlist');
	}

	/**
	 * Empties the wishlist contents.
	 *
	 * @access   public
	 * @return   void
	 */
	public function postIndex()
	{
		// If we are emptying the wishlist.
		//
		if (Input::get('empty'))
		{
			// Let's make the cart empty!
			//
			Shpcart::wishlist()->destroy();

			// Redirect back to the cart home.
			//
			return Redirect::to('wishlist')->with('warning', 'Your wishlist was cleared!');
		}

		// Redirect back to the wishlist page.
		//
		return Redirect::to('wishlist');
	}

	/**
	 * Removes an item from the wishlist.
	 *
	 * @access   public
	 * @param    string
	 * @return   void
	 */
	public function getRemove($rowid = null)
	{
		try
		{
			// Remove the item from the wishlist.
			//
			Shpcart::wishlist()->remove($rowid);
		}

		// Is the Item Row ID valid?
		//
		catch (Shpcart\CartInvalidItemRowIdException $e)
		{
			// Redirect back to the wishlist page.
			//
			return Redirect::to('shpcart/wishlist')->with('error', 'Invalid Item Row ID!');
		}

		// Does this item exists on the wishlist?
		//
		catch (Shpcart\CartItemNotFoundException $e)
		{
			// Redirect back to the wishlist page.
			//
			return Redirect::to('wishlist')->with('error', 'Item was not found in your wishlist!');
		}

		// Redirect back to the wishlist page.
		//
		return Redirect::to('wishlist')->with('success', 'The item was removed from the wishlist.');
	}

	/**
	 * Adds an item from the wishlist to the shopping cart.
	 *
	 * @access   public
	 * @param    string
	 * @return   Redirect
	 */
	public function get_add_to_cart($rowid = null)
	{
		try
		{
			// Get the item information from the wishlist cart.
			//
			$item = Shpcart::wishlist()->item($rowid);

			// Make sure the quantity is 1, since we can add the item to the wishlist multiple times!
			//
			$item['qty'] = 1;

			// Add the item to the shopping cart.
			//
			Shpcart::cart()->insert($item);
		}
		catch (Shpcart\CartInvalidItemIdException $e)
		{
			// Redirect back to the wishlist page.
			//
			return Redirect::to('wishlist')->with('error', 'Invalid Item Row ID!');
		}
		catch (Shpcart\CartItemNotFoundException $e)
		{
			// Redirect back to the wishlist page.
			//
			return Redirect::to('wishlist')->with('error', 'Item was not found in your wishlist!');
		}

		// Redirect to the shopping cart page.
		//
		return Redirect::to('cart')->with('success', 'The item was added to your shopping cart!');
	}
}