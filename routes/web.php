<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function() {
    //Admin Login Route
    Route::match(['get', 'post'], 'login', 'AdminController@login');

    Route::group(['middleware'=>['admin']], function() {
        //Admin Dashboard Route
        Route::get('dashboard', 'AdminController@dashboard');
        //Update Admin Password
        Route::match(['get', 'post'], 'update-admin-password', 'AdminController@updateAdminPassword');
        //Check Admin Password
        Route::post('check-admin-password', 'AdminController@checkAdminPassword');
        //Update Admin Details
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');
        //Update Vendor Details
        Route::match(['get', 'post'], 'update-vendor-details/{slug}', 'AdminController@updateVendorDetails');
        //View Admin / Subadmins / Vendors
        Route::get('admins/{type?}', 'AdminController@admins');
        //View Vendor Details
        Route::get('view-vendor-details/{id}', 'AdminController@viewVendorDetails');
        //Update Admin Status
        Route::post('update-admin-status', 'AdminController@updateAdminStatus');
        //Admin Logout Route
        Route::get('logout', 'AdminController@logout');

        //Sections
        Route::get('sections', 'SectionController@sections');
        //Update Section Status
        Route::post('update-section-status', 'SectionController@updateSectionStatus');
        //Delete Section
        Route::get('delete-section/{id}', 'SectionController@deleteSection');
        //Add Edit Section
        Route::match(['get', 'post'], 'add-edit-section/{id?}', 'SectionController@addEditSection');

        //Brands
        Route::get('brands', 'BrandController@brands');
        //Update Brand Status
        Route::post('update-brand-status', 'BrandController@updateBrandStatus');
        //Delete Brand
        Route::get('delete-brand/{id}', 'BrandController@deleteBrand');
        //Add Edit Brand
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');


        //Categories
        Route::get('categories', 'CategoryController@categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        //Add Category
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        Route::get('append-categories-level', 'CategoryController@appendCategoryLevel');
        Route::get('delete-category/{id}', 'CategoryController@deleteCategory');
        Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');

        //Products
        Route::get('products', 'ProductsController@products');
        Route::post('update-product-status', 'ProductsController@updateProductStatus');
        Route::get('delete-product/{id}', 'ProductsController@deleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductsController@addEditProduct');
        Route::get('delete-product-image/{id}', 'ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}', 'ProductsController@deleteProductVideo');

        //Attributes
        Route::match(['get', 'post'], 'add-attributes/{id}', 'ProductsController@addAttributes');
        Route::post('update-attribute-status', 'ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}', 'ProductsController@deleteAttribute');
        Route::post('edit-attributes/{id}', 'ProductsController@editAttributes');

        //Filters
        Route::get('filters', 'FilterController@filters');
        Route::get('filters-values', 'FilterController@filtersValues');
        Route::post('update-filter-status', 'FilterController@updateFilterStatus');
        Route::post('update-filter-values-status', 'FilterController@updateFilterValueStatus');
        Route::match(['get', 'post'], 'add-edit-filter/{id?}', 'FilterController@addEditFilter');
        Route::match(['get', 'post'], 'add-edit-filter-value/{id?}', 'FilterController@addEditFilterValue');
        Route::post('category-filters', 'FilterController@categoryFilters');

        //Images
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductsController@addImages');
        Route::post('update-image-status', 'ProductsController@updateImageStatus');
        Route::get('delete-image/{id}', 'ProductsController@deleteImage');

        //Banners
        Route::get('banners', 'BannersController@banners');
        Route::post('update-banner-status', 'BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}', 'BannersController@deleteBanner');
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannersController@addEditBanner');
    });
}); 

Route::namespace('App\Http\Controllers\Front')->group(function() {
    Route::get('/', 'IndexController@index');

    // Listing/Categories Routes
    $categoriesUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    //dd($categoriesUrls);
    foreach ($categoriesUrls as $key => $url) {
        Route::match(['get', 'post'],'/'.$url, 'ProductsController@listing');
    } 

    //Product Detail Page
    Route::get('/product/{id}', 'ProductsController@detail');

    //Vendor Register/login
    Route::get('vendor/login-register', 'VendorController@loginRegister');

    //Vendor Register
    Route::post('vendor/register', 'VendorController@vendorRegister');

    //Confirm Vendor Account
    Route::get('vendor/confirm/{code}', 'VendorController@confirmVendor');
});
