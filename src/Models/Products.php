<?php
namespace Shpcart\Model;


#############################################################
############ This file is for the examples only! ############
#############################################################


/**
 * Products, static model.
 */
class Products
{
	/**
	 * Returns a list of all products.
	 *
	 * @access   public
	 * @return   array
	 */
	public static function all()
	{
		// Declare our static products, this is just for the example !!!
		//
		return array(
			// Product 1
			//
			'sku_123ABC' => array(
				'id'      => 'sku_123ABC',
				'price'   => 39.95,
				'name'    => 'T-Shirt',
				'image'   => 'tshirt.jpg',
				'options' => array(
					'Size'  => array(
						's' => 'S',
						'm' => 'M',
						'l' => 'L'
					),
					'Color' => array(
						'red'    => 'Red',
						'blue'   => 'Blue',
						'yellow' => 'Yellow',
						'white'  => 'White'
					),
					'Style' => array(
						'unisex' => 'Unisex',
						'womens' => 'Womens'
					)
				)
			),

			// Product 2
			//
			'sku_567ZYX' => array(
				'id'      => 'sku_567ZYX',
				'price'   => 9.95,
				'name'    => 'Coffee Mug',
				'image'   => 'coffee_mug.jpg',
				'options' => array(
					'Design' => array(
						'design 1'=> 'Design 1',
						'design xpt0' => 'Design XpT0'
					)
				)
			),

			// Product 3
			//
			'sku_965QRS' => array(
				'id'      => 'sku_965QRS',
				'price'   => 29.95,
				'name'    => 'Shot Glass',
				'image'   => 'shot_glass.jpg'
			)
		);
	}

	/**
	 * Returns the options of a product.
	 *
	 * @access   public
	 * @param    string
	 * @return   array
	 */
	public static function get_options($item_id)
	{
		// Get the list of products.
		//
		$products = static::all();

		// Return the product options.
		//
		return array_get($products, $item_id . '.options', array());
	}

	/**
	 * Returns the information about a product.
	 *
	 * @access   public
	 * @param    string
	 * @return   mixed
	 */
	public static function find($product_slug = null)
	{
		// Get the list of products.
		//
		$products = static::all();

		// Loop through the products.
		//
		foreach ($products as $product)
		{
			// Check if this the product we are looking for.
			//
			if (\Str::slug($product['name']) === $product_slug)
			{
				// Return the product information.
				//
				return $product;
			}
		}

		// Product was not found.
		//
		return false;
	}
}