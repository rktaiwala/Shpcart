<?php


#############################################################
############ This file is for the examples only! ############
#############################################################


Route::controller('cartview/{any}', 'Madlymint\Shpcart\ShpcartViewController');
Route::controller('shpcart', 'Madlymint\Shpcart\ShpcartHomeController');
Route::controller('wishlist', 'Madlymint\Shpcart\ShpcartWishlistController');
Route::controller('cart', 'Madlymint\Shpcart\ShpCartController');