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
 * The products page.
 */
class ShpcartHomeController extends  \Illuminate\Routing\Controllers\Controller
{
	/**
	 * Flag for whether the controller is RESTful.
	 *
	 * @access   public
	 * @var      boolean
	 */
	public $restful = true;

	/**
	 * Show a list of the products on the page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function getIndex()
	{
		// Get the products.
		//
		$products = Products::all();

		// Show the page.
		//
		return View::make('shpcart::home')->with('products', $products);
	}
}