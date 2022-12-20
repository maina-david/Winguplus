<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'Auth\LoginController@showLoginForm')->name('home.page');

Auth::routes(['verify' => true]);
Route::get('logout', 'Auth\LoginController@logout');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('signup/account', 'Auth\RegisterController@signup')->name('signup');
Route::get('signup', 'Auth\RegisterController@signup_form')->name('signup.page');

Route::get('/verify/account/{code}', 'Auth\LoginController@verify_account')->name('account.verify');
Route::get('/verify/business/email/{code}/{email}', 'Auth\LoginController@verify_business_email')->name('verify.business.email');

Route::prefix('dashboard')->middleware('auth')->group(function(){
   Route::get('/', 'app\dashboard\dashboardController@dashboard')->name('wingu.dashboard');
});


/*
|--------------------------------------------------------------------------
| Finance
|--------------------------------------------------------------------------
|
| Erp Financial section
*/
Route::prefix('finance')->middleware('auth')->group(function () {
   Route::get('/dashboard',['uses' => 'app\finance\dashboard\dashboardController@home','as' => 'finance.index']);
   Route::post('/ajax/price','app\finance\products\productController@productPrice')->name('finance.ajax.product.price');

   /* === customer === */
   Route::get('customer',['uses' => 'app\finance\contact\contactController@index','as' => 'finance.contact.index']);
   Route::get('customer/create',['uses' => 'app\finance\contact\contactController@create','as' => 'finance.contact.create']);
   Route::post('post-customer',['uses' => 'app\finance\contact\contactController@store','as' => 'finance.contact.store']);
   Route::get('customer/{code}/edit',['uses' => 'app\finance\contact\contactController@edit','as' => 'finance.contact.edit']);
   Route::post('customer/{code}/update',['uses' => 'app\finance\contact\contactController@update','as' => 'finance.contact.update']);
   Route::get('customer/{code}/show',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.contact.show']);
   Route::get('customer/{code}/delete',['uses' => 'app\finance\contact\contactController@delete','as' => 'finance.contact.delete']);

   Route::get('delete-contact-person/{code}',['uses' => 'app\finance\contact\contactController@delete_contact_person','as' => 'finance.contactperson.delete']);

   //express customer
   Route::get('/express/customer',['uses' => 'app\finance\contact\contactController@express_list','as' => 'finance.contact.express']);
   Route::post('/express/customer/create',['uses' => 'app\finance\contact\contactController@express_store','as' => 'finance.contact.express.store']);

   //client comments
   Route::get('customer/{code}/comments',['uses' => 'app\finance\contact\commentsController@index','as' => 'finance.customers.comments']);
   Route::post('customer/comments/post',['uses' => 'app\finance\contact\commentsController@store','as' => 'finance.customers.comments.post']);
   Route::get('customer/comments/{code}/delete',['uses' => 'app\finance\contact\commentsController@delete','as' => 'finance.customers.comments.delete']);

   //client invoices
   Route::get('customer/{code}/invoices',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.invoices']);

   //client subscriptions
   Route::get('customer/{code}/subscriptions',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.subscriptions']);

   //client quotes
   Route::get('customer/{code}/quotes',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.quotes']);

   //client creditnotes
   Route::get('customer/{code}/creditnotes',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.creditnotes']);

   //client lpos
   Route::get('customer/{code}/lpos',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.lpos']);

   //client projects
   Route::get('customer/{code}/projects',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.projects']);

   //statement
   Route::get('customer/{code}/statement',['uses' => 'app\finance\contact\statementController@index','as' => 'finance.customers.statement']);
   Route::get('customer/{code}/statement/convert/{format}',['uses' => 'app\finance\contact\statementController@convert','as' => 'finance.customers.statement.convert']);
   Route::get('customer/{code}/statement/mail',['uses' => 'app\finance\contact\statementController@mail','as' => 'finance.customers.statement.mail']);
   Route::post('customer/{code}/statement/send',['uses' => 'app\finance\contact\statementController@send','as' => 'finance.customers.statement.send']);

   //customer mail
   Route::get('/customer/{code}/mail', ['uses' => 'app\finance\contact\mailController@index','as' => 'finance.customer.mail']);
   Route::get('/customer/{code}/mail/{customerID}/details', ['uses' => 'app\finance\contact\mailController@details','as' => 'finance.customer.mail.details']);
   Route::get('/customer/{code}/send', ['uses' => 'app\finance\contact\mailController@send','as' => 'finance.customer.send']);
   Route::post('/customer/mail/store', ['uses' => 'app\finance\contact\mailController@store','as' => 'finance.customer.mail.store']);

   //customer documents
   Route::get('/customer/{code}/documents', ['uses' => 'app\finance\contact\documentsController@index','as' => 'finance.customer.documents']);
   Route::post('/customer/documents/store', ['uses' => 'app\finance\contact\documentsController@store','as' => 'finance.customer.documents.store']);
   Route::post('/customer/documents/{code}/update', ['uses' => 'app\finance\contact\documentsController@update','as' => 'finance.customer.documents.update']);
   Route::get('/customer/documents/{code}/{leadID}/delete', ['uses' => 'app\finance\contact\documentsController@delete','as' => 'finance.customer.documents.delete']);

   //customer sms
   Route::get('/customer/{code}/sms', ['uses' => 'app\finance\contact\smsController@index','as' => 'finance.customer.sms']);
   Route::post('/customer/sms/send', ['uses' => 'app\finance\contact\smsController@send','as' => 'finance.customer.sms.send']);

   //customer notes
   Route::get('/customer/{code}/notes', ['uses' => 'app\finance\contact\notesController@index','as' => 'finance.customer.notes']);
   Route::post('/customer/notes/store', ['uses' => 'app\finance\contact\notesController@store','as' => 'finance.customer.notes.store']);
   Route::post('/customer/{code}/notes/update', ['uses' => 'app\finance\contact\notesController@update','as' => 'finance.customer.notes.update']);
   Route::get('/customer/{code}/notes/delete', ['uses' => 'app\finance\contact\notesController@delete','as' => 'finance.customer.notes.delete']);

   //customer call logs
   Route::get('/customer/{code}/calllogs', ['uses' => 'app\finance\contact\calllogController@index','as' => 'finance.customer.calllog']);
   Route::post('/customer/calllog/store', ['uses' => 'app\finance\contact\calllogController@store','as' => 'finance.customer.calllog.store']);
   Route::post('/customer/{code}/calllog/update', ['uses' => 'app\finance\contact\calllogController@update','as' => 'finance.customer.calllog.update']);
   Route::get('/customer/{code}/calllog/store', ['uses' => 'app\finance\contact\calllogController@delete','as' => 'finance.customer.calllog.delete']);

   //customer events
   Route::get('/customer/{code}/events', ['uses' => 'app\finance\contact\eventsController@index','as' => 'finance.customer.events']);
   Route::post('/customer/events/store', ['uses' => 'app\finance\contact\eventsController@store','as' => 'finance.customer.events.store']);
   Route::post('/customer/events/{code}/update', ['uses' => 'app\finance\contact\eventsController@update','as' => 'finance.customer.events.update']);
   Route::get('/customer/events/{code}/delete', ['uses' => 'app\finance\contact\eventsController@delete','as' => 'finance.customer.events.delete']);

   //import customer
   Route::get('customer/import',['uses' => 'app\finance\contact\importController@import','as' => 'finance.contact.import']);
   Route::post('customer/import/store',['uses' => 'app\finance\contact\importController@import_contact','as' => 'finance.contact.import.store']);
   Route::get('customer/download/import/sample/',['uses' => 'app\finance\contact\importController@download_import_sample','as' => 'finance.customer.download.sample.import']);

   //export customer list
   Route::get('customer/export/{type}',['uses' => 'app\finance\contact\importController@export','as' => 'finance.contact.export']);

   //customer category
   Route::get('customer/category',['uses' => 'app\finance\contact\groupsController@index','as' => 'finance.contact.groups.index']);
   Route::post('customer/category/store',['uses' => 'app\finance\contact\groupsController@store','as' => 'finance.contact.groups.store']);
   Route::get('customer/category/{code}/edit',['uses' => 'app\finance\contact\groupsController@edit','as' => 'finance.contact.groups.edit']);
   Route::post('customer/category/{code}/update',['uses' => 'app\finance\contact\groupsController@update','as' => 'finance.contact.groups.update']);
   Route::get('customer/category/{code}/delete',['uses' => 'app\finance\contact\groupsController@delete','as' => 'finance.contact.groups.delete']);


   /* === supplier === */
   Route::get('supplier',['uses' => 'app\finance\supplier\supplierController@index','as' => 'finance.supplier.index']);
   Route::get('supplier/create',['uses' => 'app\finance\supplier\supplierController@create','as' => 'finance.supplier.create']);
   Route::post('post-supplier',['uses' => 'app\finance\supplier\supplierController@store','as' => 'finance.supplier.store']);
   Route::get('supplier/{code}/edit',['uses' => 'app\finance\supplier\supplierController@edit','as' => 'finance.supplier.edit']);
   Route::post('supplier/{code}/update',['uses' => 'app\finance\supplier\supplierController@update','as' => 'finance.supplier.update']);
   Route::get('supplier/{code}/show',['uses' => 'app\finance\supplier\supplierController@show','as' => 'finance.supplier.show']);
   Route::get('supplier/{code}/delete',['uses' => 'app\finance\supplier\supplierController@delete','as' => 'finance.supplier.delete']);
   Route::get('delete-supplier-person/{code}',['uses' => 'app\finance\supplier\supplierController@delete_contact_person','as' => 'finance.supplier.vendor.person']);
   Route::get('supplier/{code}/trash',['uses' => 'app\finance\supplier\supplierController@trash','as' => 'vendor.trash.update']);
   Route::get('supplier/download/import/sample/',['uses' => 'app\finance\supplier\importController@download_import_sample','as' => 'finance.supplier.download.sample.import']);

   //express suppliers
   Route::get('express/supplier/list',['uses' => 'app\finance\supplier\supplierController@express_list','as' => 'finance.supplier.express.list']);
   Route::post('express/supplier/save',['uses' => 'app\finance\supplier\supplierController@express_save','as' => 'finance.supplier.express.store']);

   //supplier category
   Route::get('supplier/category',['uses' => 'app\finance\supplier\groupsController@index','as' => 'finance.supplier.groups.index']);
   Route::post('supplier/category/store',['uses' => 'app\finance\supplier\groupsController@store','as' => 'finance.supplier.groups.store']);
   Route::get('supplier/category/{code}/edit',['uses' => 'app\finance\supplier\groupsController@edit','as' => 'finance.supplier.groups.edit']);
   Route::post('supplier/category/{code}/update',['uses' => 'app\finance\supplier\groupsController@update','as' => 'finance.supplier.groups.update']);
   Route::get('supplier/category/{code}/delete',['uses' => 'app\finance\supplier\groupsController@delete','as' => 'finance.supplier.groups.delete']);

   //import
   Route::get('supplier/import',['uses' => 'app\finance\supplier\importController@index','as' => 'supplier.import.index']);
   Route::post('supplier/post/import',['uses' => 'app\finance\supplier\importController@import','as' => 'supplier.import']);

   //export
   Route::get('supplier/export/{type}',['uses' => 'app\finance\supplier\importController@export','as' => 'supplier.export']);

   /* === product === */
   Route::get('items',['uses' => 'app\finance\products\productController@index','as' => 'finance.product.index']);
   Route::get('items/create',['uses' => 'app\finance\products\productController@create','as' => 'finance.products.create']);
   Route::post('items/store',['uses' => 'app\finance\products\productController@store','as' => 'finance.products.store']);
   Route::get('items/{code}/edit',['uses' => 'app\finance\products\productController@edit','as' => 'finance.products.edit']);
   Route::post('items/{code}/update',['uses' => 'app\finance\products\productController@update','as' => 'finance.products.update']);
   Route::get('items/{code}/details',['uses' => 'app\finance\products\productController@details','as' => 'finance.products.details']);
   Route::get('items/{code}/destroy',['uses' => 'app\finance\products\productController@destroy','as' => 'finance.products.destroy']);

   //express products
   Route::get('/express/items',['uses' => 'app\finance\products\productController@express_list','as' => 'finance.product.express.list']);
   Route::post('/express/items/create',['uses' => 'app\finance\products\productController@express_store','as' => 'finance.products.express.create']);

   //import product
   Route::get('items/import',['uses' => 'app\finance\products\importController@index','as' => 'finance.products.import']);
   Route::post('items/post/import',['uses' => 'app\finance\products\importController@import','as' => 'finance.products.post.import']);

   //export products
   Route::get('items/export/{type}',['uses' => 'app\finance\products\importController@export','as' => 'finance.products.export']);

   //download csv sample for products
   Route::get('items/download/import/sample',['uses' => 'app\finance\products\importController@download_import_sample','as' => 'finance.products.sample.download']);

   /* === product description === */
   Route::get('items/{code}/description',['uses' => 'app\finance\products\productController@description','as' => 'finance.description']);
   Route::post('items/{code}/description/update',['uses' => 'app\finance\products\productController@description_update','as' => 'finance.description.update']);

   /* === product price === */
   Route::get('item/price/{code}/edit',['uses' => 'app\finance\products\productController@price','as' => 'finance.price']);
   Route::post('price/{code}/update',['uses' => 'app\finance\products\productController@price_update','as' => 'finance.price.update']);

   /* === product variants === */
   Route::get('item/{code}/variants',['uses' => 'app\finance\products\variantsController@index','as' => 'finance.products.variants.index']);
   Route::post('item/{code}/variants/store',['uses' => 'app\finance\products\variantsController@store','as' => 'finance.products.variants.store']);
   Route::get('item/{code}/variants/{variantID}/edit',['uses' => 'app\finance\products\variantsController@edit','as' => 'finance.products.variants.edit']);
   Route::post('item/variants/{code}/update',['uses' => 'app\finance\products\variantsController@update','as' => 'finance.products.variants.update']);

   /* === product inventory === */
   Route::get('items/inventory/{code}/edit',['uses' => 'app\finance\products\inventoryController@inventory','as' => 'finance.inventory']);
   Route::post('items/{code}/inventory/{productID}/update',['uses' => 'app\finance\products\inventoryController@inventory_update','as' => 'finance.inventory.update']);
   Route::post('items/inventory/settings/{productID}/update',['uses' => 'app\finance\products\inventoryController@inventory_settings','as' => 'finance.inventory.settings.update']);
   Route::post('items/inventory/outlet/link',['uses' => 'app\finance\products\inventoryController@inventory_outlet_link','as' => 'finance.inventory.outlet.link']);
   Route::get('items/{productID}/inventory/outle/{code}/link/delete',['uses' => 'app\finance\products\inventoryController@delete_inventroy','as' => 'finance.inventory.outlet.link.delete']);

   /* === product images === */
   Route::get('items/images/{code}/edit',['uses' => 'app\finance\products\imagesController@edit','as' => 'finance.product.images']);
   Route::post('items/images/{code}/update',['uses' => 'app\finance\products\imagesController@update','as' => 'finance.product.images.update']);
   Route::post('items/images/store',['uses' => 'app\finance\products\imagesController@store','as' => 'finance.product.images.store']);
   Route::post('items/images/{code}/destroy',['uses' => 'app\finance\products\imagesController@destroy','as' => 'finance.product.images.destroy']);

   /* === product settings === */
   Route::get('items/{code}/settings',['uses' => 'app\finance\products\settingsController@edit','as' => 'finance.product.settings.edit']);
   Route::get('items/{code}/settings/update',['uses' => 'app\finance\products\settingsController@update','as' => 'finance.product.settings.update']);

   /* === stock control === */
   Route::get('stock/control/',['uses' => 'app\finance\products\stockcontrolController@index','as' => 'finance.product.stock.control']);
   Route::get('order/stock',['uses' => 'app\finance\products\stockcontrolController@order','as' => 'finance.product.stock.order']);
   Route::get('order/stock/{code}/show',['uses' => 'app\finance\products\stockcontrolController@show','as' => 'finance.product.stock.order.show']);
   Route::post('post/order/stock',['uses' => 'app\finance\products\stockcontrolController@store','as' => 'finance.product.stock.order.post']);
   Route::post('lpo/ajax/price','app\finance\products\stockcontrolController@productPrice')->name('finance.ajax.product.stock.price');
   Route::get('order/stock/{code}/edit',['uses' => 'app\finance\products\stockcontrolController@edit','as' => 'finance.product.stock.order.edit']);
   Route::post('order/stock/{code}/update',['uses' => 'app\finance\products\stockcontrolController@update','as' => 'finance.product.stock.order.update']);
   Route::get('order/stock/{code}/convert/{format}',['uses' => 'app\finance\products\stockcontrolController@convert','as' => 'finance.product.stock.order.convert']);
   Route::get('order/stock/{code}/delivered',['uses' => 'app\finance\products\stockcontrolController@delivered','as' => 'finance.stock.delivered']);
   Route::get('order/stock/{code}/delete',['uses' => 'app\finance\products\stockcontrolController@delete','as' => 'finance.stock.delete']);


   //send order
   Route::get('stock/{code}/mail',['uses' => 'app\finance\products\stockcontrolController@mail','as' => 'finance.stock.mail']);
   Route::post('stock/mail/send',['uses' => 'app\finance\products\stockcontrolController@send','as' => 'finance.stock.mail.send']);
   Route::post('stock/attach/files',['uses' => 'app\finance\products\stockcontrolController@attachment_files','as' => 'finance.stock.attach']);


   /* === product category === */
   Route::get('items/category',['uses' => 'app\finance\products\productController@category','as' => 'finance.product.category']);

   /* === product brands === */
   Route::get('items/brand',['uses' => 'app\finance\products\brandController@index','as' => 'finance.product.brand']);
   Route::post('items/brand/store',['uses' => 'app\finance\products\brandController@store','as' => 'finance.product.brand.store']);
   Route::get('items/brand/{code}/edit',['uses' => 'app\finance\products\brandController@edit','as' => 'finance.product.brand.edit']);
   Route::post('product.brand/{code}/update',['uses' => 'app\finance\products\brandController@update','as' => 'finance.product.brand.update']);
   Route::get('items/brand/{code}/destroy',['uses' => 'app\finance\products\brandController@destroy','as' => 'finance.product.brand.destroy']);

   /* === product tags === */
   Route::get('items/tags',['uses' => 'app\finance\products\tagsController@index','as' => 'finance.product.tags']);
   Route::post('items/tags/store',['uses' => 'app\finance\products\tagsController@store','as' => 'finance.product.tags.store']);
   Route::get('items/tags/{code}/edit',['uses' => 'app\finance\products\tagsController@edit','as' => 'finance.product.tags.edit']);
   Route::post('product.tags/{code}/update',['uses' => 'app\finance\products\tagsController@update','as' => 'finance.product.tags.update']);
   Route::get('items/tags/{code}/destroy',['uses' => 'app\finance\products\tagsController@destroy','as' => 'finance.product.tags.destroy']);

    /* === product attributes === */
    Route::get('items/attributes',['uses' => 'app\finance\products\attributeController@index','as' => 'finance.product.attributes']);
    Route::post('items/attributes/store',['uses' => 'app\finance\products\attributeController@store','as' => 'finance.product.attributes.store']);
    Route::get('items/attributes/{code}/edit',['uses' => 'app\finance\products\attributeController@edit','as' => 'finance.product.attributes.edit']);
    Route::post('items/attributes/{code}/update',['uses' => 'app\finance\products\attributeController@update','as' => 'finance.product.attributes.update']);
    Route::get('items/attributes/{code}/delete',['uses' => 'app\finance\products\attributeController@delete','as' => 'finance.product.attributes.delete']);

    /* === attribute values === */
    Route::get('items/attributes/{code}/values',['uses' => 'app\finance\products\attributeValueController@create','as' => 'finance.product.attributes.value.create']);
    Route::post('items/attributes/values/store',['uses' => 'app\finance\products\attributeValueController@store','as' => 'finance.product.attributes.value.store']);
    Route::get('items/attributes/values/{code}/edit',['uses' => 'app\finance\products\attributeValueController@edit','as' => 'finance.product.attributes.value.edit']);
    Route::post('items/attributes/values/{code}/update',['uses' => 'app\finance\products\attributeValueController@update','as' => 'finance.product.attributes.value.update']);
    Route::get('items/attributes/values/{id}/delete',['uses' => 'app\finance\products\attributeValueController@delete','as' => 'finance.product.attributes.value.delete']);

   /* === Normal Expense === */
   Route::get('expense',['uses' => 'app\finance\expense\expenseController@index','as' => 'finance.expense.index']);
   Route::get('expense/create',['uses' => 'app\finance\expense\expenseController@create','as' => 'finance.expense.create']);
   Route::post('expense/store',['uses' => 'app\finance\expense\expenseController@store','as' => 'finance.expense.store']);
   Route::get('expense/{id}/edit',['uses' => 'app\finance\expense\expenseController@edit','as' => 'finance.expense.edit']);
   Route::post('expense/{id}/update',['uses' => 'app\finance\expense\expenseController@update','as' => 'finance.expense.update']);
   Route::get('expense/{id}/destroy',['uses' => 'app\finance\expense\expenseController@destroy','as' => 'finance.expense.destroy']);

   /* === Expense Mileage === */
   // Route::get('expense/mileage',['uses' => 'app\finance\expense\mileageController@index','as' => 'finance.mileage.index']);
   // Route::get('expense/mileage/create',['uses' => 'app\finance\expense\mileageController@create','as' => 'finance.mileage.create']);
   // Route::post('expense/mileage/store',['uses' => 'app\finance\expense\mileageController@store','as' => 'finance.mileage.store']);
   // Route::get('expense/mileage/{id}/edit',['uses' => 'app\finance\expense\mileageController@edit','as' => 'finance.mileage.edit']);
   // Route::post('expense/mileage/{id}/update',['uses' => 'app\finance\expense\mileageController@update','as' => 'finance.mileage.update']);
   // Route::get('expense/mileage/{id}/destroy',['uses' => 'app\finance\expense\mileageController@destroy','as' => 'finance.mileage.destroy']);

   /* === General Expense === */
   Route::get('expence/{id}/file/delete',['uses' => 'app\finance\expense\expenseController@file_delete','as' => 'finance.expense.file.delete']);
   Route::get('expence/{id}/file/download',['uses' => 'app\finance\expense\expenseController@download','as' => 'finance.expense.file.download']);

   /* === Expense Category settings === */

   //expense category
   Route::get('expense/category',['uses' => 'app\finance\expense\expenseCategoryController@index','as' => 'finance.expense.category.index']);
   Route::post('expense/category/store',['uses' => 'app\finance\expense\expenseCategoryController@store','as' => 'finance.expense.category.store']);
   Route::get('expense-category/{id}/edit',['uses' => 'app\finance\expense\expenseCategoryController@edit','as' => 'finance.expense.category.edit']);
   Route::post('expense-category/{id}/update',['uses' => 'app\finance\expense\expenseCategoryController@update','as' => 'finance.expense.category.update']);
   Route::get('expense-category/{id}/delete',['uses' => 'app\finance\expense\expenseCategoryController@destroy','as' => 'finance.expense.category.destroy']);

   //express category CRUD
   Route::post('/express/expense/category/store',['uses' => 'app\finance\expense\expenseCategoryController@express','as' => 'finance.express.expense.category.store']);
   Route::get('/express/expense/category/list',['uses' => 'app\finance\expense\expenseCategoryController@list','as' => 'finance.express.expense.category.list']);


   /* === payments === */
   Route::get('payments',['uses' => 'app\finance\payments\paymentsController@index','as' => 'finance.payments.received']);
   Route::get('payments/create',['uses' => 'app\finance\payments\paymentsController@create','as' => 'finance.payments.create']);
   Route::post('payments/store',['uses' => 'app\finance\payments\paymentsController@store','as' => 'finance.payments.store']);
   Route::get('payments/{id}/edit',['uses' => 'app\finance\payments\paymentsController@edit','as' => 'finance.payments.edit']);
   Route::post('payments/{id}/update',['uses' => 'app\finance\payments\paymentsController@update','as' => 'finance.payments.update']);
   Route::get('payments/{id}/show',['uses' => 'app\finance\payments\paymentsController@show','as' => 'finance.payments.show']);
   Route::get('payments/{id}/files',['uses' => 'app\finance\payments\paymentsController@files','as' => 'finance.received.files']);
   Route::post('paymentsfile/store',['uses' => 'app\finance\payments\paymentsController@file_store','as' => 'finance.receivedfile.store']);
   Route::get('retrive_client/{id}',['uses' => 'app\finance\payments\paymentsController@retrive_client','as' => 'finance.retrive.client']);
   Route::get('payment/delete/file/{id}',['uses' => 'app\finance\payments\paymentsController@file_delete','as' => 'finance.payment.file.delete']);
   Route::get('payment/download/file/{id}',['uses' => 'app\finance\payments\paymentsController@download','as' => 'finance.payment.file.download']);
   Route::get('payments/{id}/delete',['uses' => 'app\finance\payments\paymentsController@delete','as' => 'finance.payments.delete']);
   Route::get('payments/{id}/print',['uses' => 'app\finance\payments\paymentsController@print','as' => 'finance.payments.print']);
   Route::get('payments/{id}/pdf',['uses' => 'app\finance\payments\paymentsController@pdf','as' => 'finance.payments.pdf']);
   Route::get('payments/{id}/mail',['uses' => 'app\finance\payments\paymentsController@mail','as' => 'finance.payments.mail']);
   Route::post('payments/send',['uses' => 'app\finance\payments\paymentsController@send','as' => 'finance.payments.send']);


   /* ================= invoice ================= */
   Route::get('invoices',['uses' => 'app\finance\invoice\invoiceController@index','as' => 'finance.invoice.index']);
   Route::get('invoice/{code}/show',['uses' => 'app\finance\invoice\invoiceController@show','as' => 'finance.invoice.show']);
   Route::get('invoice/{code}/delete',['uses' => 'app\finance\invoice\invoiceController@delete_invoice','as' => 'finance.invoice.delete']);
   Route::get('invoice/{code}/convert/{format}',['uses' => 'app\finance\invoice\invoiceController@convert','as' => 'finance.invoice.convert']);
   Route::get('invoice/{code}/deliverynote',['uses' => 'app\finance\invoice\invoiceController@deliverynote','as' => 'finance.invoice.deliverynote']);
   Route::get('invoice/file/{status}/{id}',['uses' => 'app\finance\invoice\invoiceController@update_file_status','as' => 'finance.invoice.attachment.status']);
   Route::post('invoice/payment',['uses' => 'app\finance\invoice\invoiceController@payment','as' => 'finance.invoice.payment']);
   Route::post('invoice/payment/stk/{businessID}',['uses' => 'app\settings\integrations\payments\mpesa\daraja\stkpushController@stkpush','as' => 'finance.invoice.payments.stkpush']);


   //product invoice
   Route::get('invoice/create',['uses' => 'app\finance\invoice\productinvoiceController@create','as' => 'finance.invoice.product.create']);
   Route::get('due/invoices',['uses' => 'app\finance\invoice\invoiceController@due_invoices','as' => 'finance.invoice.due']);

   Route::post('invoice/store',['uses' => 'app\finance\invoice\productinvoiceController@store','as' => 'finance.invoice.product.store']);
   Route::get('invoice/{id}/edit',['uses' => 'app\finance\invoice\productinvoiceController@edit','as' => 'finance.invoice.product.edit']);
   Route::post('invoice/{id}/update',['uses' => 'app\finance\invoice\productinvoiceController@update','as' => 'finance.invoice.product.update']);

   Route::get('invoice/{id}/mail',['uses' => 'app\finance\invoice\invoiceController@mail','as' => 'finance.invoice.mail']);
   Route::post('invoice/send/mail',['uses' => 'app\finance\invoice\invoiceController@send','as' => 'finance.invoice.send.mail']);

   Route::post('invoice/invoice/attachment',['uses' => 'app\finance\invoice\invoiceController@attachment','as' => 'finance.invoice.attachment']);
   Route::post('invoice/attachment/files',['uses' => 'app\finance\invoice\invoiceController@attachment_files','as' => 'finance.invoice.attachment.files']);
   Route::get('invoice/attachment/{ud}/delete',['uses' => 'app\finance\invoice\invoiceController@delete_file','as' => 'finance.invoice.attachment.delete']);

   //test invoice
   Route::get('invoice/create/test',['uses' => 'app\finance\invoice\invoiceTestController@create','as' => 'finance.invoice.product.test']);


   //recurring invoice
   Route::get('invoice/recurring/create',['uses' => 'app\finance\invoice\recurringController@create','as' => 'finance.invoice.recurring.create']);
   Route::post('invoice/recurring/store',['uses' => 'app\finance\invoice\recurringController@store','as' => 'finance.invoice.recurring.store']);
   Route::get('invoice/recurring/{id}/edit',['uses' => 'app\finance\invoice\recurringController@edit','as' => 'finance.invoice.recurring.edit']);
   Route::post('invoice/recurring/{id}/update',['uses' => 'app\finance\invoice\recurringController@update','as' => 'finance.invoice.recurring.update']);

   /* ================= sales orders ================= */
   Route::get('salesorders',['uses' => 'app\finance\salesorders\salesordersController@index','as' => 'finance.salesorders.index']);
   Route::get('salesorders/create',['uses' => 'app\finance\salesorders\salesordersController@create','as' => 'finance.salesorders.create']);
   Route::post('salesorders/store',['uses' => 'app\finance\salesorders\salesordersController@store','as' => 'finance.salesorders.store']);
   Route::get('salesorders/{id}/edit',['uses' => 'app\finance\salesorders\salesordersController@edit','as' => 'finance.salesorders.edit']);
   Route::post('salesorders/{id}/update',['uses' => 'app\finance\salesorders\salesordersController@update','as' => 'finance.salesorders.update']);
   Route::get('salesorders/{id}/delete',['uses' => 'app\finance\salesorders\salesordersController@delete_salesorder','as' => 'finance.salesorders.delete']);
   Route::get('salesorders/{id}/show',['uses' => 'app\finance\salesorders\salesordersController@show','as' => 'finance.salesorders.show']);
   Route::get('salesorders/{id}/pdf',['uses' => 'app\finance\salesorders\salesordersController@pdf','as' => 'finance.salesorders.pdf']);
   Route::get('salesorders/{id}/print',['uses' => 'app\finance\salesorders\salesordersController@print','as' => 'finance.salesorders.print']);
   Route::post('salesorders/attachment',['uses' => 'app\finance\salesorders\salesordersController@attachment','as' => 'finance.salesorders.attachment']);
   Route::post('salesorders/attachment/files',['uses' => 'app\finance\salesorders\salesordersController@attachment_files','as' => 'finance.salesorders.attachment.files']);
   Route::get('salesorders/file/{status}/{id}',['uses' => 'app\finance\salesorders\salesordersController@update_file_status','as' => 'finance.salesorders.attachment.status']);
   Route::get('salesorders/attached/file/{id}/delete',['uses' => 'app\finance\salesorders\salesordersController@delete_file','as' => 'finance.salesorders.attachment.delete']);

   Route::get('salesorders/status/{salesorderID}/{status}/change',['uses' => 'app\finance\salesorders\salesordersController@change_status','as' => 'finance.salesorders.status.change']);

   //conver sales order to invoice
   Route::get('salesorders/{id}/convert',['uses' => 'app\finance\salesorders\salesordersController@convert_to_invoice','as' => 'finance.salesorders.convert']);

   //send sales order
   Route::get('salesorders/{id}/mail',['uses' => 'app\finance\salesorders\salesordersController@mail','as' => 'finance.salesorders.mail']);
   Route::post('salesorders/mail/send',['uses' => 'app\finance\salesorders\salesordersController@send','as' => 'finance.salesorders.mail.send']);

   //sales order settings
   Route::get('settings/salesorders',[ 'uses' => 'app\finance\settings\salesordersController@index','as' => 'finance.settings.salesorders']);
   Route::post('settings/salesorders/generated/{id}/update',[ 'uses' => 'app\finance\settings\salesordersController@update_generated_number','as' => 'finance.settings.salesorders.generated.update']);

   Route::get('settings/salesorders/{id}/defaults',[ 'uses' => 'app\finance\settings\salesordersController@index','as' => 'finance.settings.salesorders.defaults']);
   Route::post('settings/salesorders/defaults/{id}/update',[ 'uses' => 'app\finance\settings\salesordersController@update_defaults','as' => 'finance.settings.salesorders.defaults.update']);

   Route::get('settings/salesorders/{id}/tabs',[ 'uses' => 'app\finance\settings\salesordersController@index','as' => 'finance.settings.salesorders.tabs']);
   Route::post('settings/salesorders/tabs/{id}/update',[ 'uses' => 'app\finance\settings\salesordersController@update_tabs','as' => 'finance.settings.salesorders.tabs.update']);


   /* ================= Quotes ================= */
   Route::get('quotes',['uses' => 'app\finance\quotes\quotesController@index','as' => 'finance.quotes.index']);
   Route::get('quotes/create',['uses' => 'app\finance\quotes\quotesController@create','as' => 'finance.quotes.create']);
   Route::post('quotes/store',['uses' => 'app\finance\quotes\quotesController@store','as' => 'finance.quotes.store']);
   Route::get('quotes/{id}/edit',['uses' => 'app\finance\quotes\quotesController@edit','as' => 'finance.quotes.edit']);
   Route::post('quotes/{id}/update',['uses' => 'app\finance\quotes\quotesController@update','as' => 'finance.quotes.update']);
   Route::get('quotes/{id}/delete',['uses' => 'app\finance\quotes\quotesController@delete','as' => 'finance.quotes.delete']);
   Route::get('quotes/{id}/show',['uses' => 'app\finance\quotes\quotesController@show','as' => 'finance.quotes.show']);
   Route::get('quotes/{id}/pdf',['uses' => 'app\finance\quotes\quotesController@pdf','as' => 'finance.quotes.pdf']);
   Route::get('quotes/{id}/print',['uses' => 'app\finance\quotes\quotesController@print','as' => 'finance.quotes.print']);
   Route::post('quotes/attachment',['uses' => 'app\finance\quotes\quotesController@attachment','as' => 'finance.quotes.attachment']);
   Route::post('quotes/attachment/files',['uses' => 'app\finance\quotes\quotesController@attachment_files','as' => 'finance.quotes.attachment.files']);
   Route::get('quotes/file/{status}/{id}',['uses' => 'app\finance\quotes\quotesController@update_file_status','as' => 'finance.quotes.attachment.status']);
   Route::get('quotes/attached/file/{id}/delete',['uses' => 'app\finance\quotes\quotesController@delete_file','as' => 'finance.quotes.attachment.delete']);
   Route::get('quotes/attachment/{quotesID}/{status}/change',['uses' => 'app\finance\quotes\quotesController@change_status','as' => 'finance.quotes.status.change']);
   Route::get('quotes/{id}/convert',['uses' => 'app\finance\quotes\quotesController@convert_to_invoice','as' => 'finance.quotes.convert']);
   Route::get('quotes/{id}/delete',['uses' => 'app\finance\quotes\quotesController@delete_quotes','as' => 'finance.quotes.delete']);

   //send quotes
   Route::get('quotes/{code}/mail',['uses' => 'app\finance\quotes\quotesController@mail','as' => 'finance.quotes.mail']);
   Route::post('quotes/mail/send',['uses' => 'app\finance\quotes\quotesController@send','as' => 'finance.quotes.mail.send']);

   /* ================= lpo ================= */
   Route::get('purchaseorders',['uses' => 'app\finance\lpo\lpoController@index','as' => 'finance.lpo.index']);
   Route::get('purchaseorders/create',['uses' => 'app\finance\lpo\lpoController@create','as' => 'finance.lpo.create']);
   Route::post('purchaseorders/store',['uses' => 'app\finance\lpo\lpoController@store','as' => 'finance.lpo.store']);
   Route::get('purchaseorders/{id}/edit',['uses' => 'app\finance\lpo\lpoController@edit','as' => 'finance.lpo.edit']);
   Route::post('purchaseorders/{id}/update',['uses' => 'app\finance\lpo\lpoController@update','as' => 'finance.lpo.update']);
   Route::get('purchaseorders/{id}/delete',['uses' => 'app\finance\lpo\lpoController@delete','as' => 'finance.lpo.delete']);
   Route::get('purchaseorders/{id}/show',['uses' => 'app\finance\lpo\lpoController@show','as' => 'finance.lpo.show']);
   Route::get('purchaseorders/{id}/pdf',['uses' => 'app\finance\lpo\lpoController@pdf','as' => 'finance.lpo.pdf']);
   Route::get('purchaseorders/{id}/print',['uses' => 'app\finance\lpo\lpoController@print','as' => 'finance.lpo.print']);
   Route::post('purchaseorders/attachment',['uses' => 'app\finance\lpo\lpoController@attachment','as' => 'finance.lpo.attachment']);
   Route::post('purchaseorders/attachment/files',['uses' => 'app\finance\lpo\lpoController@attachment_files','as' => 'finance.lpo.attachment.files']);
   Route::get('purchaseorders/file/{status}/{id}',['uses' => 'app\finance\lpo\lpoController@update_file_status','as' => 'finance.lpo.attachment.status']);
   Route::get('purchaseorders/attached/file/{id}/delete',['uses' => 'app\finance\lpo\lpoController@delete_file','as' => 'finance.lpo.attachment.delete']);
   Route::get('purchaseorders/attachment/{lpoID}/{status}/change',['uses' => 'app\finance\lpo\lpoController@change_status','as' => 'finance.lpo.status.change']);
   Route::get('purchaseorders/{id}/convert',['uses' => 'app\finance\lpo\lpoController@convert_to_invoice','as' => 'finance.lpo.convert']);
   Route::get('purchaseorders/{id}/delete',['uses' => 'app\finance\lpo\lpoController@delete_lpo','as' => 'finance.lpo.delete']);

   //send lpo
   Route::get('purchaseorders/{id}/mail',['uses' => 'app\finance\lpo\lpoController@mail','as' => 'finance.lpo.mail']);
   Route::post('purchaseorders/mail/send',['uses' => 'app\finance\lpo\lpoController@send','as' => 'finance.lpo.mail.send']);

   /* ================= credit note ================= */
   Route::get('creditnote',['uses' => 'app\finance\creditnote\creditnoteController@index','as' => 'finance.creditnote.index']);
   Route::get('creditnote/create',['uses' => 'app\finance\creditnote\creditnoteController@create','as' => 'finance.creditnote.create']);
   Route::post('creditnote/store',['uses' => 'app\finance\creditnote\creditnoteController@store','as' => 'finance.creditnote.store']);
   Route::get('creditnote/{code}/edit',['uses' => 'app\finance\creditnote\creditnoteController@edit','as' => 'finance.creditnote.edit']);
   Route::post('creditnote/{code}/update',['uses' => 'app\finance\creditnote\creditnoteController@update','as' => 'finance.creditnote.update']);
   Route::get('creditnote/{code}/delete',['uses' => 'app\finance\creditnote\creditnoteController@delete','as' => 'finance.creditnote.delete']);
   Route::get('creditnote/{code}/show',['uses' => 'app\finance\creditnote\creditnoteController@show','as' => 'finance.creditnote.show']);
   Route::get('creditnote/{code}/generate/{format}',['uses' => 'app\finance\creditnote\creditnoteController@generate','as' => 'finance.creditnote.generate']);
   Route::post('creditnote/attachment',['uses' => 'app\finance\creditnote\creditnoteController@attachment','as' => 'finance.creditnote.attachment']);
   Route::post('creditnote/attachment/files',['uses' => 'app\finance\creditnote\creditnoteController@attachment_files','as' => 'finance.creditnote.attachment.files']);
   Route::get('creditnote/file/{status}/{code}',['uses' => 'app\finance\creditnote\creditnoteController@update_file_status','as' => 'finance.creditnote.attachment.status']);
   Route::get('creditnote/attached/file/{code}/delete',['uses' => 'app\finance\creditnote\creditnoteController@delete_file','as' => 'finance.creditnote.attachment.delete']);
   Route::get('creditnote/attachment/{creditnoteID}/{status}/change',['uses' => 'app\finance\creditnote\creditnoteController@change_status','as' => 'finance.creditnote.status.change']);
   Route::post('creditnote/apply/credit',['uses' => 'app\finance\creditnote\creditnoteController@apply_credit','as' => 'finance.creditnote.apply.credit']);
   Route::get('creditnote/{code}/delete',['uses' => 'app\finance\creditnote\creditnoteController@delete_creditnote','as' => 'finance.creditnote.delete']);

   //send creditnote
   Route::get('creditnote/{code}/mail',['uses' => 'app\finance\creditnote\creditnoteController@mail','as' => 'finance.creditnote.mail']);
   Route::post('creditnote/mail/send',['uses' => 'app\finance\creditnote\creditnoteController@send','as' => 'finance.creditnote.mail.send']);

   /* === settings === */
   //invoices
   Route::get('settings/invoice',['uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice']);
   Route::post('settings/invoice/generated/{id}/update',['uses' => 'app\finance\settings\invoiceController@update_generated_number','as' => 'finance.settings.invoice.generated.update']);

   Route::get('settings/invoice/{id}/defaults',['uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice.defaults']);
   Route::post('settings/invoice/defaults/{id}/update',['uses' => 'app\finance\settings\invoiceController@update_defaults','as' => 'finance.settings.invoice.defaults.update']);

   Route::get('settings/invoice/{id}/workflow',['uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice.workflow']);
   Route::post('settings/invoice/workflow/{id}/update',['uses' => 'app\finance\settings\invoiceController@update_workflow','as' => 'finance.settings.invoice.workflow.update']);

   Route::get('settings/invoice/{id}/payments',['uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice.payments']);
   Route::post('settings/invoice/payments/{id}/update',['uses' => 'app\finance\settings\invoiceController@update_payments','as' => 'finance.settings.invoice.payments.update']);

   Route::get('settings/invoice/{id}/tabs',['uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice.tabs']);
   Route::post('settings/invoice/tabs/{id}/update',['uses' => 'app\finance\settings\invoiceController@update_tabs','as' => 'finance.settings.invoice.tabs.update']);

   Route::get('settings/invoice/{id}/print',['uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice.print']);
   Route::post('settings/invoice/print/{id}/update',['uses' => 'app\finance\settings\invoiceController@update_print','as' => 'finance.settings.invoice.print.update']);

   //quotes
   Route::get('settings/quote',[ 'uses' => 'app\finance\settings\quoteController@index','as' => 'finance.settings.quote']);
   Route::post('settings/quote/generated/{id}/update',['uses' => 'app\finance\settings\quoteController@update_generated_number','as' => 'finance.settings.quote.generated.update']);

   Route::get('settings/quote/{id}/defaults',['uses' => 'app\finance\settings\quoteController@index','as' => 'finance.settings.quote.defaults']);
   Route::post('settings/quote/defaults/{id}/update',['uses' => 'app\finance\settings\quoteController@update_defaults','as' => 'finance.settings.quote.defaults.update']);

   Route::get('settings/quote/{id}/tabs',['uses' => 'app\finance\settings\quoteController@index','as' => 'finance.settings.quote.tabs']);
   Route::post('settings/quote/tabs/{id}/update',['uses' => 'app\finance\settings\quoteController@update_tabs','as' => 'finance.settings.quote.tabs.update']);

   //creditnote
   Route::get('settings/creditnote',['uses' => 'app\finance\settings\creditnoteController@index','as' => 'finance.settings.creditnote']);
   Route::post('settings/creditnote/generated/{id}/update',['uses' => 'app\finance\settings\creditnoteController@update_generated_number','as' => 'finance.settings.creditnote.generated.update']);

   Route::get('settings/creditnote/{id}/defaults',['uses' => 'app\finance\settings\creditnoteController@index','as' => 'finance.settings.creditnote.defaults']);
   Route::post('settings/creditnote/defaults/{id}/update',['uses' => 'app\finance\settings\creditnoteController@update_defaults','as' => 'finance.settings.creditnote.defaults.update']);

   Route::get('settings/creditnote/{id}/tabs',['uses' => 'app\finance\settings\creditnoteController@index','as' => 'finance.settings.creditnote.tabs']);
   Route::post('settings/creditnote/tabs/{id}/update',['uses' => 'app\finance\settings\creditnoteController@update_tabs','as' => 'finance.settings.creditnote.tabs.update']);

   //taxes
   Route::get('settings/taxes',['uses' => 'app\finance\settings\taxesController@index','as' => 'finance.settings.taxes']);
   Route::post('settings/taxes/store',['uses' => 'app\finance\settings\taxesController@store','as' => 'finance.settings.taxes.store']);
   Route::get('settings/taxes/{id}/edit',['uses' => 'app\finance\settings\taxesController@edit','as' => 'finance.settings.taxes.edit']);
   Route::post('settings/taxes/update',['uses' => 'app\finance\settings\taxesController@update','as' => 'finance.settings.update']);
   Route::get('settings/taxes/{id}/delete',['uses' => 'app\finance\settings\taxesController@delete','as' => 'finance.settings.delete']);

   //tax express
   Route::get('/taxes/express',['uses' => 'app\finance\settings\taxesController@express_list','as' => 'finance.settings.taxes.express']);
   Route::post('/taxes/express/store',['uses' => 'app\finance\settings\taxesController@store_express','as' => 'finance.settings.taxes.express.store']);

   //Local purchase order
   Route::get('settings/lpo',['uses' => 'app\finance\settings\lpoController@index','as' => 'finance.settings.lpo']);
   Route::post('settings/lpo/generated/{id}/update',['uses' => 'app\finance\settings\lpoController@update_generated_number','as' => 'finance.settings.lpo.generated.update']);

   Route::get('settings/lpo/{id}/defaults',['uses' => 'app\finance\settings\lpoController@index','as' => 'finance.settings.lpo.defaults']);
   Route::post('settings/lpo/defaults/{id}/update',['uses' => 'app\finance\settings\lpoController@update_defaults','as' => 'finance.settings.lpo.defaults.update']);

   Route::get('settings/lpo/{id}/tabs',['uses' => 'app\finance\settings\lpoController@index','as' => 'finance.settings.lpo.tabs']);
   Route::post('settings/lpo/tabs/{id}/update',['uses' => 'app\finance\settings\lpoController@update_tabs','as' => 'finance.settings.lpo.tabs.update']);


   // bank accounts
   Route::get('account/',['uses' => 'app\finance\account\accountController@index','as' => 'finance.account']);
   Route::get('account/create',['uses' => 'app\finance\account\accountController@create','as' => 'finance.account.create']);
   Route::post('account/store',['uses' => 'app\finance\account\accountController@store','as' => 'finance.account.store']);
   Route::get('account/{id}/edit',['uses' => 'app\finance\account\accountController@edit','as' => 'finance.account.edit']);
   Route::post('account/{id}/update',['uses' => 'app\finance\account\accountController@update','as' => 'finance.account.update']);
   Route::get('account/{id}/delete',['uses' => 'app\finance\account\accountController@delete','as' => 'finance.account.delete']);

   //express account crud
   Route::post('/express/account/store',['uses' => 'app\finance\account\accountController@express','as' => 'finance.account.express']);
   Route::get('access/bank/account/', 'app\finance\account\accountController@list')->name('finance.bank.account.access');

   // income category
   Route::get('income/category/',[ 'uses' => 'app\finance\income\incomeController@index','as' => 'finance.income.category']);
   Route::get('income/category/create',['uses' => 'app\finance\income\incomeController@create','as' => 'finance.income.category.create']);
   Route::post('income/category/store',['uses' => 'app\finance\income\incomeController@store','as' => 'finance.income.category.store']);
   Route::get('income/category/{id}/edit',['uses' => 'app\finance\income\incomeController@edit','as' => 'finance.income.category.edit']);
   Route::post('income/category/update',['uses' => 'app\finance\income\incomeController@update','as' => 'finance.income.category.update']);
   Route::get('income/category/{id}/delete',['uses' => 'app\finance\income\incomeController@delete','as' => 'finance.income.category.delete']);
   Route::post('express/income/category/create',['uses' => 'app\finance\income\incomeController@express']);
   Route::get('express/income/category/get',[ 'uses' => 'app\finance\income\incomeController@get_express','as' => 'finance.income.express.category']);

   //payment mode
   Route::get('settings/payment/modes',['uses' => 'app\finance\payments\paymentModeController@index','as' => 'finance.payment.mode']);
   Route::post('settings/payment/modes/store',['uses' => 'app\finance\payments\paymentModeController@store','as' => 'finance.payment.mode.store']);
   Route::post('settings/payment/modes/{id}/update',['uses' => 'app\finance\payments\paymentModeController@update','as' => 'finance.payment.mode.update']);
   Route::get('settings/payment/modes/{id}/delete',['uses' => 'app\finance\payments\paymentModeController@delete','as' => 'finance.payment.mode.delete']);

   //payment method express
   Route::get('express/payment/list',['uses' => 'app\finance\payments\paymentModeController@express_list','as' => 'finance.payment.mode.express']);
   Route::post('express/payment/modes/store',['uses' => 'app\finance\payments\paymentModeController@express_store','as' => 'finance.payment.mode.express.store']);

   /**
   * Reports
   */
   Route::get('/reports',['uses' => 'app\finance\report\reportsController@dashboard','as' => 'finance.report']);

   //statement of account
   Route::get('report/account-statement',['uses' => 'app\finance\report\accountStatementController@index','as' => 'finance.report.account.statement']);
   Route::post('report/account-statement/process',['uses' => 'app\finance\report\accountStatementController@process','as' => 'finance.report.account.statement.process']);
   Route::get('report/account-statement/{clientID}/{from}/{to}/{transaction}/results',['uses' => 'app\finance\report\accountStatementController@results','as' => 'finance.report.account.statement.results']);
   Route::get('report/account-statement/{clientID}/{from}/{to}/{transaction}/export/excel',['uses' => 'app\finance\report\accountStatementController@excel','as' => 'finance.report.account.statement.export.excel']);
   Route::get('report/account-statement/{clientID}/{from}/{to}/{transaction}/export/pdf',['uses' => 'app\finance\report\accountStatementController@pdf','as' => 'finance.report.account.statement.export.pdf']);
   Route::get('report/account-statement/{clientID}/{from}/{to}/{transaction}/export/print',['uses' => 'app\finance\report\accountStatementController@print','as' => 'finance.report.account.statement.export.print']);

   //profit and loss
   //Route::get('report/profitandloss',['uses' => 'app\finance\report\profitandlossController@index','as' => 'finance.report.profitandloss']);

   //balance sheet
   Route::get('report/balancesheet',['uses' => 'app\finance\report\balancesheetController@index','as' => 'finance.report.balancesheet']);

   //sales by customer
   Route::get('report/sales/customer',['uses' => 'app\finance\report\sales\customerController@salesbycustomer','as' => 'finance.report.sales.customer']);
   Route::get('report/sales/customer/print/{to}/{from}',['uses' => 'app\finance\report\sales\customerController@print','as' => 'finance.report.sales.customer.print']);
   Route::get('report/sales/customer/pdf/{to}/{from}',['uses' => 'app\finance\report\sales\customerController@pdf','as' => 'finance.report.sales.customer.pdf']);

   //sales by item
   Route::get('report/sales/item',['uses' => 'app\finance\report\sales\itemController@salesbyitem','as' => 'finance.report.sales.item']);
   Route::get('report/sales/item/print/{to}/{from}',['uses' => 'app\finance\report\sales\itemController@print','as' => 'finance.report.sales.item.print']);
   Route::get('report/sales/item/pdf/{to}/{from}',['uses' => 'app\finance\report\sales\itemController@pdf','as' => 'finance.report.sales.item.pdf']);

   //sales by sales person
   Route::get('report/sales/salesperson',['uses' => 'app\finance\report\sales\salespersonController@salesbysalesperson','as' => 'finance.report.sales.salesperson']);
   Route::get('report/sales/salesperson/print/{to}/{from}',['uses' => 'app\finance\report\sales\salespersonController@print','as' => 'finance.report.sales.salesperson.print']);
   Route::get('report/sales/salesperson/pdf/{to}/{from}',['uses' => 'app\finance\report\sales\salespersonController@pdf','as' => 'finance.report.sales.salesperson.pdf']);

   //Customer Balances report
   Route::get('report/receivables/customerbalances',['uses' => 'app\finance\report\receivables\customerbalancesController@balance','as' => 'finance.report.receivables.balance']);
   Route::get('report/sales/receivables/print/{to}/{from}',['uses' => 'app\finance\report\receivables\customerbalancesController@print','as' => 'finance.report.receivables.balance.print']);
   Route::get('report/sales/receivables/pdf/{to}/{from}',['uses' => 'app\finance\report\receivables\customerbalancesController@pdf','as' => 'finance.report.receivables.balance.pdf']);

   //aging report
   Route::get('report/receivables/aging',['uses' => 'app\finance\report\receivables\agingController@report','as' => 'finance.report.receivables.aging']);
   Route::get('report/receivables/aging/{date}/extract',['uses' => 'app\finance\report\receivables\agingController@extract','as' => 'finance.report.receivables.aging.extract']);

   //profite and loss
   Route::get('report/profilandloss',['uses' => 'app\finance\report\profitandlossController@details','as' => 'finance.report.profitandloss']);
   Route::get('report/profilandloss/pdf/{to}/{from}',['uses' => 'app\finance\report\profitandlossController@pdf','as' => 'finance.report.profitandloss.pdf']);

   //Expense Summary
   Route::get('report/expensesummary',['uses' => 'app\finance\report\expensesummaryController@details','as' => 'finance.report.expensesummary']);
   Route::get('report/expensesummary/extract/{to}/{from}',['uses' => 'app\finance\report\expensesummaryController@extract','as' => 'finance.report.expensesummary.extract']);

   //Income Summary
   Route::get('report/incomesummary',['uses' => 'app\finance\report\incomesummaryController@report','as' => 'finance.report.incomesummary']);
   Route::get('report/incomesummary/{to}/{from}/extract',['uses' => 'app\finance\report\incomesummaryController@extract','as' => 'finance.report.incomesummary.extract']);

   /**
   * Inventory report
   */
   //inventory summary
   Route::get('report/inventory/summary',['uses' => 'app\finance\report\inventory\summaryController@report','as' => 'finance.report.inventory.summary']);
   Route::get('report/inventory/summary/extract',['uses' => 'app\finance\report\inventory\summaryController@extract','as' => 'finance.report.inventory.summary.extract']);

   //Inventory Valuation Summary
   Route::get('report/inventory/valuation/summary',['uses' => 'app\finance\report\inventory\valuationController@report','as' => 'finance.report.inventory.valuation.summary']);
   Route::get('report/inventory/valuation/summary/extract',['uses' => 'app\finance\report\inventory\valuationController@extract','as' => 'finance.report.inventory.valuation.summary.extract']);

   //Inventory product sale report
   Route::get('report/inventory/product-sale/summary',['uses' => 'app\finance\report\inventory\productsaleController@report','as' => 'finance.report.inventory.sale.summary']);
   Route::get('report/inventory/product-sale/summary/{to}/{from}/extract',['uses' => 'app\finance\report\inventory\productsaleController@extract','as' => 'finance.report.inventory.sale.summary.extract']);


   /* ================= fees ================= */

   //fee items
   Route::get('fee/items',['uses' => 'app\finance\fee\feeItemsController@index','as' => 'finance.fee.items.index']);
   Route::get('get/fee/items',['uses' => 'app\finance\fee\feeItemsController@items','as' => 'finance.fee.items']);
   Route::post('fee/items/store',['uses' => 'app\finance\fee\feeItemsController@store','as' => 'finance.fee.items.store']);
   Route::post('fee/items/{code}/update',['uses' => 'app\finance\fee\feeItemsController@update','as' => 'finance.fee.items.update']);
   Route::get('fee/items/{code}/delete',['uses' => 'app\finance\fee\feeItemsController@delete','as' => 'finance.fee.items.delete']);

   //fee statement
   Route::get('fees/statements',['uses' => 'app\finance\fee\statementsController@index','as' => 'finance.fee.statements.index']);
   Route::post('general/fee/statement',['uses' => 'app\finance\fee\statementsController@general_fee_statement','as' => 'finance.fee.general.statements']);
   Route::get('fees/statements/{code}/view',['uses' => 'app\finance\fee\statementsController@view','as' => 'finance.fee.statements.view']);

    //fee structure
   Route::get('fee/structures',['uses' => 'app\finance\fee\feeStructuresController@index','as' => 'finance.fee.structures.index']);
   Route::get('fee/structures/create',['uses' => 'app\finance\fee\feeStructuresController@create','as' => 'finance.fee.structures.create']);
   Route::post('fee/structures/store',['uses' => 'app\finance\fee\feeStructuresController@store','as' => 'finance.fee.structures.store']);
   Route::get('fee/structures/{code}/edit',['uses' => 'app\finance\fee\feeStructuresController@edit','as' => 'finance.fee.structures.edit']);
   Route::post('fee/structures/{code}/update',['uses' => 'app\finance\fee\feeStructuresController@update','as' => 'finance.fee.structures.update']);
   Route::get('fee/structures/{code}/show',['uses' => 'app\finance\fee\feeStructuresController@show','as' => 'finance.fee.structures.show']);

   Route::post('fee/structures/{code}/link/items',['uses' => 'app\finance\fee\feeStructuresController@link_fee_items','as' => 'finance.fee.structures.link.items']);
   Route::get('fee/structures/{code}/link/items/{id}/delete',['uses' => 'app\finance\fee\feeStructuresController@delete_linked_fee_item','as' => 'finance.fee.structures.link.items.delete']);

   Route::post('fee/structures/{code}/link/classes',['uses' => 'app\finance\fee\feeStructuresController@link_classes','as' => 'finance.fee.structures.link.classes']);
   Route::get('fee/structures/{code}/link/classes/{id}/delete',['uses' => 'app\finance\fee\feeStructuresController@delete_linked_class','as' => 'finance.fee.structures.link.class.delete']);

   Route::get('fee/structures/{code}/delete',['uses' => 'app\finance\fee\feeStructuresController@delete','as' => 'finance.fee.structures.delete']);

});

/*
|--------------------------------------------------------------------------
| Human resource
|--------------------------------------------------------------------------
|
| Manage contents of your website quick and first
*/
Route::prefix('hrm')->middleware('auth')->group(function () {

   Route::get('/', ['uses' => 'app\hr\hrm\dashboardController@dashboard','as' => 'hrm.dashboard']);

   /*=== create employee ==*/
   //Route::get('employee', ['uses' => 'app\hr\employee\employeeController@index','as' => 'hrm.employee.index']);
   Route::get('employee/list', ['uses' => 'app\hr\employee\employeeController@index','as' => 'hrm.employee.index']);
   Route::get('employee/create', ['uses' => 'app\hr\employee\employeeController@create','as' => 'hrm.employee.create']);
   Route::post('employee/store', ['uses' => 'app\hr\employee\employeeController@store','as' => 'hrm.employee.store']);
   Route::post('employee/{id}/update', ['uses' => 'app\hr\employee\employeeController@update','as' => 'hrm.employee.update']);

   /*=== view employee details ===*/
   Route::get('employee/{id}/show', ['uses' => 'app\hr\employee\employeeController@show','as' => 'hrm.employee.show']);

   /*=== staff profile ===*/
   Route::get('employee/{id}/edit', ['uses' => 'app\hr\employee\employeeController@edit','as' => 'hrm.employee.edit']);
   Route::post('employee/{id}/update', ['uses' => 'app\hr\employee\employeeController@update','as' => 'hrm.employee.update']);


   /*=== personal info ===*/
   Route::get('employee/personal-info/{id}/edit', ['uses' => 'app\hr\employee\personalinfoController@edit','as' => 'hrm.personalinfo.edit']);
   Route::post('personal-info/{id}/update', ['uses' => 'app\hr\employee\personalinfoController@update','as' => 'hrm.personalinfo.update']);


   /*=== company structure ===*/
   Route::get('employee/company-structure/{id}/edit', ['uses' => 'app\hr\employee\companyStructureController@edit','as' => 'hrm.employee.company.structure.edit']);
   Route::post('employee/company/structure/update', ['uses' => 'app\hr\employee\companyStructureController@update','as' => 'hrm.employee.company.structure.update']);


   /*=== employee salary ===*/
   Route::get('employee/salary/{id}/edit', ['uses' => 'app\hr\employee\salaryController@edit','as' => 'hrm.employee.salary.edit']);
   Route::post('salary/{id}/update', ['uses' => 'app\hr\employee\salaryController@update','as' => 'hrm.employee.salary.update']);


   /*=== bank information ===*/
   Route::get('employee/bank-information/{id}/edit', ['uses' => 'app\hr\employee\bankinformationController@edit','as' => 'hrm.employeebankinformation.edit']);
   Route::post('bank-information/{id}/update', ['uses' => 'app\hr\employee\bankinformationController@update','as' => 'hrm.employeebankinformation.update']);


   /*=== Academic information ===*/
   Route::get('employee/academic-information/{id}/edit', ['uses' => 'app\hr\employee\academicinformationController@edit','as' => 'hrm.employeeacademicinformation.edit']);
   Route::post('academic-information/{id}/update', ['uses' => 'app\hr\employee\academicinformationController@update','as' => 'hrm.employeeacademicinformation.update']);


   /*=== Institution ===*/
   Route::post('institution-information-post',['uses' => 'app\hr\employee\academicinformationController@post_institution','as' => 'hrm.institutioninformation.post']);
   Route::get('delete-institution/{id}',['uses' => 'app\hr\employee\academicinformationController@delete_institution','as' => 'hrm.institution.delete']);
   Route::get('institution-edit/{id}',['uses' => 'app\hr\employee\academicinformationController@edit_institution','as' => 'hrm.institution.edit']);


   /*=== work experience ===*/
   Route::get('employee/experience/{id}/edit',['uses' => 'app\hr\employee\workexperienceController@edit','as' => 'hrm.experience.edit']);
   Route::post('experience/post',['uses' => 'app\hr\employee\workexperienceController@store','as' => 'hrm.experience.store']);
   Route::get('experience/{id}/delete',['uses' => 'app\hr\employee\workexperienceController@delete','as' => 'hrm.experience.delete']);


   /*=== employee alocations ===*/
   Route::get('employee/allocation/{id}/edit',['uses' => 'app\hr\employee\allocationController@edit','as' => 'hrm.allocation.edit']);
   Route::post('allocation/post',['uses' => 'app\hr\employee\allocationController@store','as' => 'hrm.allocation.store']);
   Route::get('delete/{id}/allocation',['uses' => 'app\hr\employee\allocationController@delete','as' => 'hrm.allocation.delete']);


   /*=== family info ===*/
   Route::get('employee/amily-information/{id}/edit',['uses' => 'app\hr\employee\familyController@edit','as' => 'hrm.famillyinfo.edit']);
   Route::post('family-information-post',['uses' => 'app\hr\employee\familyController@post_family','as' => 'hrm.famillyinfo.post']);
   Route::get('delete-family-information/{id}',['uses' => 'app\hr\employee\familyController@delete_family_information','as' => 'hrm.famillyinfo.delete']);


   /*=== employee files ===*/
   Route::get('files/{id}/edit',['uses' => 'app\hr\employee\filesController@edit','as' => 'hrm.employeefile.edit']);
   Route::post('file-post',['uses' => 'app\hr\employee\filesController@post_file','as' => 'hrm.employeefile.post']);
   Route::get('delete-file/{id}',['uses' => 'app\hr\employee\filesController@delete_file','as' => 'hrm.employeefile.delete']);

   /*=== employee roles ===*/
   Route::get('roles/{id}/edit',['uses' => 'app\hr\employee\employeerolesController@edit','as' => 'hrm.employeerole.edit']);

   /*=== employee deductions ===*/
   Route::get('employee/deductions/{id}/edit',['uses' => 'app\hr\employee\deductionsController@index','as' => 'hrm.employee.deductions']);
   Route::post('employee/deductions/allocate',['uses' => 'app\hr\employee\deductionsController@allocate','as' => 'hrm.employee.deductions.allocate']);
   Route::get('employee/deductions/delete/{id}/allocate',['uses' => 'app\hr\employee\deductionsController@delete','as' => 'hrm.employee.deductions.delete.allocate']);

   /* ================== recruitment ============= */
   Route::get('recruitment/job-openings',['uses' => 'app\hr\recruitment\jobsController@index','as' => 'hrm.recruitment.jobs']);
   Route::get('recruitment/job-openings/create',['uses' => 'app\hr\recruitment\jobsController@create','as' => 'hrm.recruitment.jobs.create']);
   Route::post('recruitment/job-openings/store',['uses' => 'app\hr\recruitment\jobsController@store','as' => 'hrm.recruitment.jobs.store']);
   Route::get('recruitment/job-openings/{code}/edit',['uses' => 'app\hr\recruitment\jobsController@edit','as' => 'hrm.recruitment.jobs.edit']);
   Route::post('recruitment/job-openings/{code}/update',['uses' => 'app\hr\recruitment\jobsController@update','as' => 'hrm.recruitment.jobs.update']);
   Route::get('recruitment/job-openings/{code}',['uses' => 'app\hr\recruitment\jobsController@show','as' => 'hrm.recruitment.jobs.show']);


   /* ================== leave ================== */
   Route::get('leave',['uses' => 'app\hr\leave\leaveController@index','as' => 'hrm.leave.index']);
   Route::get('leave/create',['uses' => 'app\hr\leave\leaveController@create','as' => 'hrm.leave.create']);
   Route::post('leave/store',['uses' => 'app\hr\leave\leaveController@store','as' => 'hrm.leave.store']);
   Route::get('leave/{id}/edit',['uses' => 'app\hr\leave\leaveController@edit','as' => 'hrm.leave.edit']);
   Route::post('leave/{id}/update',['uses' => 'app\hr\leave\leaveController@update','as' => 'hrm.leave.update']);
   Route::get('leave/balance',['uses' => 'app\hr\leave\leaveController@balance','as' => 'hrm.leave.balance']);
   Route::get('leave/calendar',['uses' => 'app\hr\leave\leaveController@calendar','as' => 'hrm.leave.calendar']);

   Route::get('leave/{id}/approve',['uses' => 'app\hr\leave\leaveController@approve','as' => 'hrm.leave.approve']);
   Route::get('leave/{id}/denay',['uses' => 'app\hr\leave\leaveController@denay','as' => 'hrm.leave.denay']);
   Route::get('leave/{id}/delete',['uses' => 'app\hr\leave\leaveController@delete','as' => 'hrm.leave.delete']);

   //apply leave
   Route::get('leave/apply',['uses' => 'app\hr\leave\leaveapplyController@application','as' => 'hrm.leave.apply']);
   Route::post('leave/apply/store',['uses' => 'app\hr\leave\leaveapplyController@store','as' => 'hrm.leave.apply.store']);
   Route::get('leave/apply/{id}/edit',['uses' => 'app\hr\leave\leaveapplyController@edit','as' => 'hrm.leave.apply.edit']);
   Route::post('leave/apply/{id}/update',['uses' => 'app\hr\leave\leaveapplyController@update','as' => 'hrm.leave.apply.update']);
   Route::get('leave/my-leave-list',['uses' => 'app\hr\leave\leaveapplyController@my_list','as' => 'hrm.leave.apply.index']);

   //leave settings
   Route::get('leave/settings',['uses' => 'app\hr\leave\settingsController@index','as' => 'hrm.leave.settings']);
   Route::get('leave/holiday',['uses' => 'app\hr\leave\settingsController@index','as' => 'hrm.leave.settings.holiday']);
   Route::post('leave/holiday/store',['uses' => 'app\hr\leave\settingsController@store_holiday','as' => 'hrm.leave.settings.holiday.store']);
   Route::get('leave/workdays',['uses' => 'app\hr\leave\settingsController@index','as' => 'hrm.leave.settings.workdays']);

   //leave type
   Route::get('leave/type',['uses' => 'app\hr\hrm\settingsController@leave_types','as' => 'hrm.leave.type']);

   /* ================== payroll ================== */
   //people
   Route::get('payroll/people',[ 'uses' => 'app\hr\payroll\peopleController@index','as' => 'hrm.payroll.people']);
   Route::get('payroll/{id}/show',[ 'uses' => 'app\hr\payroll\peopleController@show','as' => 'hrm.payroll.people.show']);
   Route::post('payroll/{id}/show/update',['uses' => 'app\hr\payroll\peopleController@update','as' => 'hrm.payroll.people.show.update']);

   //payroll
   Route::get('payrolls',[ 'uses' => 'app\hr\payroll\runPayrollController@index','as' => 'hrm.payroll.index']);
   Route::get('payroll/{id}/details',[ 'uses' => 'app\hr\payroll\runPayrollController@payroll_details','as' => 'hrm.payroll.details']);
   Route::get('payroll/{employeeID}/{id}/payslip',[ 'uses' => 'app\hr\payroll\runPayrollController@payslip','as' => 'hrm.payroll.payslip']);
   Route::get('payroll/{employeeID}/{id}/payslip/delete',['uses' => 'app\hr\payroll\runPayrollController@payslip_delete','as' => 'hrm.payroll.payslip.delete']);
   Route::get('payroll/{id}/delete',['uses' => 'app\hr\payroll\runPayrollController@delete_payroll','as' => 'hrm.payroll.delete']);

   //mpesa payroll payment
   Route::post('payroll/mpesa/payment',['uses' => 'app\hr\payroll\mpesaPaymentController@process_payment','as' => 'hrm.payroll.mpesa.payment']);

   //payroll process
   Route::get('/payroll/process',['uses' => 'app\hr\payroll\runPayrollController@create','as' => 'hrm.payroll.process']);
   Route::post('payroll/process/post',['uses' => 'app\hr\payroll\runPayrollController@run','as' => 'hrm.payroll.process.post']);
   Route::get('payroll/process/{payroll_date}/{type}/{branch}/review',['uses' => 'app\hr\payroll\runPayrollController@review','as' => 'hrm.payroll.process.review']);
   Route::post('payroll/process/run',['uses' => 'app\hr\payroll\runPayrollController@process','as' => 'hrm.payroll.process.run']);


   //settings
   Route::get('payroll/settings',['uses' => 'app\hr\payroll\settingsController@payday','as' => 'hrm.payroll.settings.payday']);
   Route::post('payroll/settings/update',['uses' => 'app\hr\payroll\settingsController@update','as' => 'hrm.payroll.settings.payday.update']);

   //payroll settings
   Route::get('payroll/settings/approval',['uses' => 'app\hr\payroll\settingsController@approval','as' => 'hrm.payroll.settings.approval']);
   Route::post('payroll/settings/approval/update',['uses' => 'app\hr\payroll\settingsController@approval_update','as' => 'hrm.payroll.settings.approval.update']);

   //deductions
   Route::get('payroll/settings/deduction',['uses' => 'app\hr\payroll\deductionsController@index','as' => 'hrm.payroll.settings.deduction']);
   Route::post('payroll/settings/deduction/store',['uses' => 'app\hr\payroll\deductionsController@store','as' => 'hrm.payroll.settings.deduction.store']);
   Route::get('payroll/settings/deduction/{id}/edit',['uses' => 'app\hr\payroll\deductionsController@edit','as' => 'hrm.payroll.settings.deduction.edit']);
   Route::post('payroll/settings/deduction/update',['uses' => 'app\hr\payroll\deductionsController@update','as' => 'hrm.payroll.settings.deduction.update']);
   Route::get('payroll/settings/deduction/{id}/delete',['uses' => 'app\hr\payroll\deductionsController@delete','as' => 'hrm.payroll.settings.deduction.delete']);

   //benefits
   Route::get('payroll/settings/benefits',['uses' => 'app\hr\payroll\benefitsController@index','as' => 'hrm.payroll.settings.benefits']);
   Route::post('payroll/settings/benefits/store',['uses' => 'app\hr\payroll\benefitsController@store','as' => 'hrm.payroll.settings.benefits.store']);
   Route::get('payroll/settings/benefits/{id}/edit',['uses' => 'app\hr\payroll\benefitsController@edit','as' => 'hrm.payroll.settings.benefits.edit']);
   Route::post('payroll/settings/benefits/update',['uses' => 'app\hr\payroll\benefitsController@update','as' => 'hrm.payroll.settings.benefits.update']);
   Route::get('payroll/settings/benefits/{id}/delete',['uses' => 'app\hr\payroll\benefitsController@delete','as' => 'hrm.payroll.settings.benefits.delete']);

   /* ================== hr Calendar ================== */
   Route::get('calendar',['middleware' => ['permission:delete-hrcalendar'], 'uses' => 'app\hr\calendar\calendarController@index','as' => 'hrm.calendar']);

   /* ================== Organization ================== */
   //job title
   Route::get('organization/positions',['uses' => 'app\hr\organization\positionsController@index','as' => 'hrm.positions']);
   Route::post('organization/positions/store',['uses' => 'app\hr\organization\positionsController@store','as' => 'hrm.positions.store']);
   Route::get('organization/positions/{id}/edit',['uses' => 'app\hr\organization\positionsController@edit','as' => 'hrm.positions.edit']);
   Route::post('organization/positions/{id}/update',['uses' => 'app\hr\organization\positionsController@update','as' => 'hrm.positions.update']);
   Route::get('organization/positions/{id}/destroy',['uses' => 'app\hr\organization\positionsController@destroy','as' => 'hrm.positions.destroy']);

   //departments
   Route::get('organization/departments',['uses' => 'app\hr\organization\departmentsController@index','as' => 'hrm.departments']);
   Route::get('organization/departments/create',['uses' => 'app\hr\organization\departmentsController@create','as' => 'hrm.departments.create']);
   Route::post('organization/departments/store',['uses' => 'app\hr\organization\departmentsController@store','as' => 'hrm.departments.store']);
   Route::get('organization/departments/{id}/edit',['uses' => 'app\hr\organization\departmentsController@edit','as' => 'hrm.departments.edit']);
   Route::post('organization/departments/{id}/update',['uses' => 'app\hr\organization\departmentsController@update','as' => 'hrm.departments.update']);
   Route::get('organization/departments/{id}/delete',['uses' => 'app\hr\organization\departmentsController@delete','as' => 'hrm.departments.delete']);

   //branches
   Route::get('organization/branches',['uses' => 'app\hr\organization\branchesController@index','as' => 'hrm.branches']);
   Route::get('organization/branches/create',['uses' => 'app\hr\organization\branchesController@create','as' => 'hrm.branches.create']);
   Route::post('organization/branches/store',['uses' => 'app\hr\organization\branchesController@store','as' => 'hrm.branches.store']);
   Route::get('organization/branches/{id}/edit',['uses' => 'app\hr\organization\branchesController@edit','as' => 'hrm.branches.edit']);
   Route::post('organization/branches/{id}/update',['uses' => 'app\hr\organization\branchesController@update','as' => 'hrm.branches.update']);
   Route::get('organization/branches/{id}/delete',['uses' => 'app\hr\organization\branchesController@delete','as' => 'hrm.branches.delete']);

   /* === Announcements === */
   Route::get('announcements',['uses' => 'app\hr\Announcements\AnnouncementsController@announcements_list','as' => 'hrm.announcements.list']);
   Route::get('announcements/{id}/show',['uses' => 'app\hr\Announcements\AnnouncementsController@show','as' => 'hrm.announcements.show']);

   /* === exit details === */
   Route::get('exit-details',['uses' => 'app\hr\ExitDetails\ExitdetailsController@index','as' => 'hrm.exitdetails.index']);
   Route::get('exit-details/create',['uses' => 'app\hr\ExitDetails\ExitdetailsController@create','as' => 'hrm.exitdetails.create']);
   Route::get('exit-details/{id}/edit',['uses' => 'app\hr\ExitDetails\ExitdetailsController@edit','as' => 'hrm.exitdetails.edit']);

   /* === Company Policy === */
   Route::get('company-policy',['uses' => 'app\hr\CompanyProfile\CompanyProfileController@index','as' => 'hrm.companyprofile.index']);
   Route::get('company-policy/create',['uses' => 'app\hr\CompanyProfile\CompanyProfileController@create','as' => 'hrm.companyprofile.create']);
   Route::get('company-policy/{id}/edit',['uses' => 'app\hr\CompanyProfile\CompanyProfileController@edit','as' => 'hrm.companyprofile.edit']);


   /* === Travel === */
   Route::get('travel/myTravels',['uses' => 'app\hr\travel\travelController@my_travels','as' => 'hrm.travel.my']);
   Route::get('travel',['uses' => 'app\hr\travel\travelController@index','as' => 'hrm.travel.index']);
   Route::get('travel/create',['uses' => 'app\hr\travel\travelController@create','as' => 'hrm.travel.create']);
   Route::post('travel/store',['uses' => 'app\hr\travel\travelController@store','as' => 'hrm.travel.store']);
   Route::get('travel/{id}/edit',['uses' => 'app\hr\travel\travelController@edit','as' => 'hrm.travel.edit']);
   Route::post('travel/{id}/update',['uses' => 'app\hr\travel\travelController@update','as' => 'hrm.travel.update']);
   Route::get('travel/{id}/delete',['uses' => 'app\hr\travel\travelController@delete','as' => 'hrm.travel.delete']);

   /* === Travel Expense === */
   Route::get('travel/expenses',['uses' => 'app\hr\travel\expensesController@index','as' => 'hrm.travel.expenses']);
   Route::get('travel/expenses/create',['uses' => 'app\hr\travel\expensesController@create','as' => 'hrm.travel.expenses.create']);
   Route::post('travel/expenses/store',['uses' => 'app\hr\travel\expensesController@store','as' => 'hrm.travel.expenses.store']);
   Route::get('travel/expenses/{id}/edit',['uses' => 'app\hr\travel\expensesController@edit','as' => 'hrm.travel.expenses.edit']);
   Route::post('travel/expenses/{id}/update',['uses' => 'app\hr\travel\expensesController@update','as' => 'hrm.travel.expenses.update']);
   Route::get('travel/expenses/{id}/show',['uses' => 'app\hr\travel\expensesController@show','as' => 'hrm.travel.expenses.show']);
   Route::get('travel/expenses/{id}/delete',['uses' => 'app\hr\travel\expensesController@delete','as' => 'hrm.travel.expenses.delete']);
   Route::get('travel/expenses/{expenseID}/delete/{id}/files',['uses' => 'app\hr\travel\expensesController@delete_file','as' => 'hrm.travel.expenses.delete.files']);

   /* === Events === */
   Route::get('events',['uses' => 'app\hr\events\eventsController@index','as' => 'hrm.events']);
   Route::get('events/create',['uses' => 'app\hr\events\eventsController@create','as' => 'hrm.events.create']);
   Route::post('events/store',['uses' => 'app\hr\events\eventsController@store','as' => 'hrm.events.store']);
   Route::get('events/{code}/edit',['uses' => 'app\hr\events\eventsController@edit','as' => 'hrm.events.edit']);
   Route::post('events/{code}/update',['uses' => 'app\hr\events\eventsController@update','as' => 'hrm.events.update']);
   Route::get('events/{code}/delete',['uses' => 'app\hr\events\eventsController@delete','as' => 'hrm.events.delete']);

   /* === Assets === */
   //Route::get('Compensation',['uses' => 'app\hr\Assets\AssetsController@index','as' => 'hrm.assets.index']);

   // Route::get('assets/create',[
   //     'uses' => 'app\hr\Assets\AssetsController@create',
   //     'as' => 'assets.create',
   //     'middleware' => 'roles',
   //     'roles' => ['Admin','Human resource','Chief Executive Officer']
   // ]);


   // Route::get('assets/{id}/edit',
   //     'uses' => 'app\hr\Assets\AssetsController@edit',
   //     'as' => 'assets.edit',
   //     'middleware' => 'roles',
   //     'roles' => ['Admin','Human resource','Chief Executive Officer']
   // ]);

   /* === Settings === */

});


/*
|--------------------------------------------------------------------------
| crm
|--------------------------------------------------------------------------
|
| customer relationship manager
*/
Route::prefix('crm')->middleware('auth')->group(function () {

   /*========== dashboard ==========*/
   //personal dashboard
   // Route::get('my/dashboard', ['uses' => 'app\crm\dashboard\dashboardController@dashboard','as' => 'crm.dashboard']);

   //manager dashboard
   // Route::get('manager/dashboard', ['uses' => 'app\crm\dashboard\dashboardController@manager_dashboard','as' => 'crm.manager.dashboard']);

   /*========== leads ==========*/
   Route::get('/dashboard', ['uses' => 'app\crm\leads\leadsController@index','as' => 'crm.dashboard']);
   Route::get('/leads', ['uses' => 'app\crm\leads\leadsController@index','as' => 'crm.leads.index']);
   Route::get('/canvas', ['uses' => 'app\crm\leads\leadsController@canvas','as' => 'crm.leads.canvas']);
   Route::get('/leads/{code}/show', ['uses' => 'app\crm\leads\leadsController@show','as' => 'crm.leads.show']);
   Route::get('/leads/create', ['uses' => 'app\crm\leads\leadsController@create','as' => 'crm.leads.create']);
   Route::post('/leads/store', ['uses' => 'app\crm\leads\leadsController@store','as' => 'crm.leads.store']);
   Route::get('/leads/{code}/edit', ['uses' => 'app\crm\leads\leadsController@edit','as' => 'crm.leads.edit']);
   Route::post('/leads/{code}/update', ['uses' => 'app\crm\leads\leadsController@update','as' => 'crm.leads.update']);
   Route::get('/leads/{code}/delete', ['uses' => 'app\crm\leads\leadsController@delete','as' => 'crm.leads.delete']);
   Route::get('/leads/{code}/convert', ['uses' => 'app\crm\leads\leadsController@convert','as' => 'crm.leads.convert']);

   /*========== notes ==========*/
   Route::get('/leads/{code}/notes', ['uses' => 'app\crm\leads\notesController@notes','as' => 'crm.leads.notes']);
   Route::post('/leads/notes/store', ['uses' => 'app\crm\leads\notesController@store','as' => 'crm.leads.notes.store']);
   Route::post('/leads/{code}/notes/update', ['uses' => 'app\crm\leads\notesController@update','as' => 'crm.leads.notes.update']);
   Route::get('/leads/{code}/notes/delete', ['uses' => 'app\crm\leads\notesController@delete','as' => 'crm.leads.notes.delete']);

   //call logs
   Route::get('/leads/{code}/calllog', ['uses' => 'app\crm\leads\calllogController@calllog','as' => 'crm.leads.calllog']);
   Route::post('/leads/calllog/store', ['uses' => 'app\crm\leads\calllogController@store_calllog','as' => 'crm.leads.calllog.store']);
   Route::post('/leads/{code}/calllog/store', ['uses' => 'app\crm\leads\calllogController@update_calllog','as' => 'crm.leads.calllog.update']);
   Route::get('/leads/{code}/calllog/delete', ['uses' => 'app\crm\leads\calllogController@delete','as' => 'crm.leads.calllog.delete']);

   //lead status
   Route::get('/lead/status', ['uses' => 'app\crm\leads\statusController@index','as' => 'crm.leads.status']);
   Route::post('/lead/status/store', ['uses' => 'app\crm\leads\statusController@store','as' => 'crm.leads.status.store']);
   Route::post('/lead/status/{code}/update', ['uses' => 'app\crm\leads\statusController@update','as' => 'crm.leads.status.update']);
   Route::get('/lead/status/{code}/delete', ['uses' => 'app\crm\leads\statusController@delete','as' => 'crm.leads.status.delete']);

   //lead sources
   Route::get('/lead/sources', ['uses' => 'app\crm\leads\sourcesController@index','as' => 'crm.leads.sources']);
   Route::post('/lead/sources/store', ['uses' => 'app\crm\leads\sourcesController@store','as' => 'crm.leads.sources.store']);
   Route::post('/lead/sources/{code}/update', ['uses' => 'app\crm\leads\sourcesController@update','as' => 'crm.leads.sources.update']);
   Route::get('/lead/sources/{code}/delete', ['uses' => 'app\crm\leads\sourcesController@delete','as' => 'crm.leads.sources.delete']);

   //lead tasks
   Route::get('/leads/{code}/tasks', ['uses' => 'app\crm\leads\tasksController@index','as' => 'crm.leads.tasks']);
   Route::post('/leads/tasks/store', ['uses' => 'app\crm\leads\tasksController@store','as' => 'crm.leads.tasks.store']);
   Route::post('/leads/tasks/{code}/update', ['uses' => 'app\crm\leads\tasksController@update','as' => 'crm.leads.tasks.update']);
   Route::get('/leads/tasks/{code}/delete', ['uses' => 'app\crm\leads\tasksController@delete','as' => 'crm.leads.tasks.delete']);

   //lead events
   Route::get('/leads/{code}/events', ['uses' => 'app\crm\leads\eventsController@index','as' => 'crm.leads.events']);
   Route::get('/leads/{code}/events/list', ['uses' => 'app\crm\leads\eventsController@index','as' => 'crm.leads.events.list']);
   Route::post('/leads/events/store', ['uses' => 'app\crm\leads\eventsController@store','as' => 'crm.leads.events.store']);
   Route::post('/leads/events/{code}/update', ['uses' => 'app\crm\leads\eventsController@update','as' => 'crm.leads.events.update']);
   Route::get('/leads/events/{code}/delete', ['uses' => 'app\crm\leads\eventsController@delete','as' => 'crm.leads.events.delete']);

   //lead documents
   Route::get('/leads/{code}/documents', ['uses' => 'app\crm\leads\documentsController@index','as' => 'crm.leads.documents']);
   Route::post('/leads/documents/store', ['uses' => 'app\crm\leads\documentsController@store','as' => 'crm.leads.documents.store']);
   Route::post('/leads/documents/{documentCode}/update', ['uses' => 'app\crm\leads\documentsController@update','as' => 'crm.leads.documents.update']);
   Route::get('/leads/{code}//documents/{documentCode}/delete', ['uses' => 'app\crm\leads\documentsController@delete','as' => 'crm.leads.documents.delete']);

   //lead mail
   Route::get('/leads/{code}/mail', ['uses' => 'app\crm\leads\mailController@index','as' => 'crm.leads.mail']);
   Route::get('/leads/{code}/mail/{leadID}/details', ['uses' => 'app\crm\leads\mailController@details','as' => 'crm.leads.details']);
   Route::get('/leads/{code}/send', ['uses' => 'app\crm\leads\mailController@send','as' => 'crm.leads.send']);
   Route::post('/leads/mail/store', ['uses' => 'app\crm\leads\mailController@store','as' => 'crm.leads.mail.store']);

   //lead sms
   Route::get('/leads/{code}/sms', ['uses' => 'app\crm\leads\smsController@index','as' => 'crm.leads.sms']);
   Route::post('/leads/sms/send', ['uses' => 'app\crm\leads\smsController@send','as' => 'crm.leads.sms.send']);

   /*========== mail ==========*/
   Route::get('/mail/inbox', ['uses' => 'app\crm\mail\mailController@inbox','as' => 'crm.mail.inbox']);
   Route::get('/mail/sent', ['uses' => 'app\crm\mail\mailController@sent','as' => 'crm.mail.sent']);
   Route::get('/mail/compose', ['uses' => 'app\crm\mail\mailController@compose','as' => 'crm.mail.compose']);
   Route::get('/mail/{code}/details', ['uses' => 'app\crm\mail\mailController@details','as' => 'crm.mail.details']);

   /*========== customers ==========*/
   Route::get('/customer', ['uses' => 'app\crm\customers\customersController@index','as' => 'crm.customers.index']);
   Route::get('/customer/create', ['uses' => 'app\crm\customers\customersController@create','as' => 'crm.customers.create']);
   Route::post('/customer/store', ['uses' => 'app\crm\customers\customersController@contact_store','as' => 'crm.customers.store']);
   Route::get('/customer/{code}/edit', ['uses' => 'app\crm\customers\customersController@edit','as' => 'crm.customers.edit']);
   Route::post('/customer/{code}/update', ['uses' => 'app\crm\customers\customersController@contact_update','as' => 'crm.customers.update']);
   Route::get('/customer/{code}/show', ['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.show']);
   Route::get('/customer/{code}/customer-persons', ['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.persons']);
   Route::get('/customer/{code}/notes', ['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.notes']);
   Route::post('/customer/notes/store', ['uses' => 'app\crm\customers\customersController@note_store','as' => 'crm.post.note']);
   Route::get('/customer/{code}/delete', ['uses' => 'app\crm\customers\customersController@delete','as' => 'crm.customers.delete']);

   //client comments
   Route::get('customer/{code}/comments',['uses' => 'app\crm\customers\commentsController@index','as' => 'crm.customers.comments']);
   Route::post('customer/comments/post',['uses' => 'app\crm\customers\commentsController@store','as' => 'crm.customers.comments.post']);
   Route::get('customer/comments/{code}/delete',['uses' => 'app\crm\customers\commentsController@delete','as' => 'crm.customers.comments.delete']);

   //client invoices
   Route::get('customer/{code}/invoices',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.invoices']);

   //client subscriptions
   Route::get('customer/{code}/subscriptions',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.subscriptions']);

   //client quotes
   Route::get('customer/{code}/quotes',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.quotes']);

   //client creditnotes
   Route::get('customer/{code}/creditnotes',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.creditnotes']);

   //client lpos
   Route::get('customer/{code}/lpos',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.lpos']);

   //client projects
   Route::get('customer/{code}/projects',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.projects']);

   //statement
   Route::get('customer/{code}/statement',['uses' => 'app\crm\customers\statementController@index','as' => 'crm.customers.statement']);
   Route::get('customer/{code}/statement/pdf',['uses' => 'app\crm\customers\statementController@pdf','as' => 'crm.customers.statement.pdf']);
   Route::get('customer/{code}/statement/print',['uses' => 'app\crm\customers\statementController@print','as' => 'crm.customers.statement.print']);
   Route::get('customer/{code}/statement/mail',['uses' => 'app\crm\customers\statementController@mail','as' => 'crm.customers.statement.mail']);
   Route::post('customer/{code}/statement/send',['uses' => 'app\crm\customers\statementController@send','as' => 'crm.customers.statement.send']);

   //customer mail
   Route::get('/customer/{code}/mail', ['uses' => 'app\crm\customers\mailController@index','as' => 'crm.customer.mail']);
   Route::get('/customer/{code}/mail/{customerID}/details', ['uses' => 'app\crm\customers\mailController@details','as' => 'crm.customer.details']);
   Route::get('/customer/{code}/send', ['uses' => 'app\crm\customers\mailController@send','as' => 'crm.customer.send']);
   Route::post('/customer/mail/store', ['uses' => 'app\crm\customers\mailController@store','as' => 'crm.customer.mail.store']);

   //customer documents
   Route::get('/customer/{code}/documents', ['uses' => 'app\crm\customers\documentsController@index','as' => 'crm.customer.documents']);
   Route::post('/customer/documents/store', ['uses' => 'app\crm\customers\documentsController@store','as' => 'crm.customer.documents.store']);
   Route::post('/customer/documents/{code}/update', ['uses' => 'app\crm\customers\documentsController@update','as' => 'crm.customer.documents.update']);
   Route::get('/customer/documents/{code}/{leadID}/delete', ['uses' => 'app\crm\customers\documentsController@delete','as' => 'crm.customer.documents.delete']);

   //customer sms
   Route::get('/customer/{code}/sms', ['uses' => 'app\crm\customers\smsController@index','as' => 'crm.customer.sms']);
   Route::post('/customer/sms/send', ['uses' => 'app\crm\customers\smsController@send','as' => 'crm.customer.sms.send']);

   //import customer
   Route::get('customer/import',['uses' => 'app\crm\customers\importController@import','as' => 'crm.customers.import']);
   Route::post('customer/import/store',['uses' => 'app\crm\customers\importController@import_contact','as' => 'crm.customers.import.store']);
   Route::get('customer/download/import/sample/',['uses' => 'app\crm\customers\importController@download_import_sample','as' => 'crm.customer.download.sample.import']);

   //export customer list
   Route::get('customer/export/{type}',['uses' => 'app\crm\customers\importController@export','as' => 'crm.customers.export']);

   //customer category
   Route::get('customer/category',['uses' => 'app\crm\customers\groupsController@index','as' => 'crm.customers.groups.index']);
   Route::post('customer/category/store',['uses' => 'app\crm\customers\groupsController@store','as' => 'crm.customers.groups.store']);
   Route::get('customer/category/{code}/edit',['uses' => 'app\crm\customers\groupsController@edit','as' => 'crm.customers.groups.edit']);
   Route::post('customer/category/{code}/update',['uses' => 'app\crm\customers\groupsController@update','as' => 'crm.customers.groups.update']);
   Route::get('customer/category/{code}/delete',['uses' => 'app\crm\customers\groupsController@delete','as' => 'crm.customers.groups.delete']);

   //customer notes
   Route::get('/customer/{code}/notes', ['uses' => 'app\crm\customers\notesController@index','as' => 'crm.customer.notes']);
   Route::post('/customer/notes/store', ['uses' => 'app\crm\customers\notesController@store','as' => 'crm.customer.notes.store']);
   Route::post('/customer/{code}/notes/update', ['uses' => 'app\crm\customers\notesController@update','as' => 'crm.customer.notes.update']);
   Route::get('/customer/{code}/notes/delete', ['uses' => 'app\crm\customers\notesController@delete','as' => 'crm.customer.notes.delete']);

   //customer call logs
   Route::get('/customer/{code}/calllogs', ['uses' => 'app\crm\customers\calllogController@index','as' => 'crm.customer.calllog']);
   Route::post('/customer/calllog/store', ['uses' => 'app\crm\customers\calllogController@store','as' => 'crm.customer.calllog.store']);
   Route::post('/customer/{code}/calllog/update', ['uses' => 'app\crm\customers\calllogController@update','as' => 'crm.customer.calllog.update']);
   Route::get('/customer/{code}/calllog/store', ['uses' => 'app\crm\customers\calllogController@delete','as' => 'crm.customer.calllog.delete']);

   //customer events
   Route::get('/customer/{code}/events', ['uses' => 'app\crm\customers\eventsController@index','as' => 'crm.customer.events']);
   Route::post('/customer/events/store', ['uses' => 'app\crm\customers\eventsController@store','as' => 'crm.customer.events.store']);
   Route::post('/customer/events/{code}/update', ['uses' => 'app\crm\customers\eventsController@update','as' => 'crm.customer.events.update']);
   Route::get('/customer/events/{code}/delete', ['uses' => 'app\crm\customers\eventsController@delete','as' => 'crm.customer.events.delete']);


   /*========== sms ==========*/
   Route::get('/sms', ['uses' => 'app\crm\sms\smsController@sent','as' => 'crm.sms.sent']);
   Route::post('/sms/send/single', ['uses' => 'app\crm\sms\smsController@send','as' => 'crm.sms.send.single']);
   Route::post('/sms/send/bulk', ['uses' => 'app\crm\sms\smsController@sent','as' => 'crm.sms.send.bulk']);
   Route::get('/sms/retreve/from/{code}', ['uses' => 'app\crm\sms\smsController@retrieve_from']);

   /*==================== social ====================*/
   //publications
   Route::get('social/dashboard', ['uses' => 'app\crm\social\dashboardController@dashboard','as' => 'crm.social.dashboard']);

   //posts
   Route::get('social/posts', ['uses' => 'app\crm\social\postsController@index','as' => 'crm.social.post.index']);
   Route::get('social/posts/create', ['uses' => 'app\crm\social\postsController@create','as' => 'crm.social.post.create']);
   Route::post('social/social/store', ['uses' => 'app\crm\social\postsController@store','as' => 'crm.social.post.store']);

   Route::get('marketing/retrive/channel/{code}', ['uses' => 'app\crm\digitalmarketing\publicationsController@retrieve_channels']);
   Route::get('marketing/publications/{code}/edit', ['uses' => 'app\crm\digitalmarketing\publicationsController@edit','as' => 'crm.publications.edit']);
   Route::post('marketing/publications/{code}/update', ['uses' => 'app\crm\digitalmarketing\publicationsController@update','as' => 'crm.publications.update']);
   Route::get('marketing/publications/{postID}/channel/{channelID}', ['uses' => 'app\crm\digitalmarketing\publicationsController@post_per_channel','as' => 'crm.publications.post.channel']);
   Route::get('marketing/publish/{postID}/{channelID}', ['uses' => 'app\crm\digitalmarketing\publicationsController@publish','as' => 'crm.publications.post.publish']);

   //accounts
   Route::get('marketing/account', ['uses' => 'app\crm\digitalmarketing\accountController@index','as' => 'crm.account.index']);
   Route::get('marketing/account/create', ['uses' => 'app\crm\digitalmarketing\accountController@create','as' => 'crm.account.create']);
   Route::post('marketing/account/store', ['uses' => 'app\crm\digitalmarketing\accountController@store','as' => 'crm.account.store']);
   Route::get('marketing/account/{code}/edit', ['uses' => 'app\crm\digitalmarketing\accountController@edit','as' => 'crm.account.edit']);
   Route::post('marketing/account/{code}/update', ['uses' => 'app\crm\digitalmarketing\accountController@update','as' => 'crm.account.update']);
   Route::get('marketing/account/{code}/delete', ['uses' => 'app\crm\digitalmarketing\accountController@delete','as' => 'crm.marketing.account.delete']);

   //medium
   Route::get('marketing/medium', ['uses' => 'app\crm\digitalmarketing\mediumController@index','as' => 'crm.medium.index']);
   Route::get('marketing/medium/create', ['uses' => 'app\crm\digitalmarketing\mediumController@create','as' => 'crm.medium.create']);
   Route::post('marketing/medium/store', ['uses' => 'app\crm\digitalmarketing\mediumController@store','as' => 'crm.medium.store']);
   Route::get('marketing/medium/{code}/edit', ['uses' => 'app\crm\digitalmarketing\mediumController@edit','as' => 'crm.medium.edit']);
   Route::post('marketing/medium/{code}/update', ['uses' => 'app\crm\digitalmarketing\mediumController@update','as' => 'crm.medium.update']);
   Route::get('marketing/medium/{code}/delete', ['uses' => 'app\crm\digitalmarketing\mediumController@delete','as' => 'crm.medium.delete']);

   //channel
   Route::get('marketing/{code}/channel', ['uses' => 'app\crm\digitalmarketing\channelController@index','as' => 'crm.channel.index']);
   Route::post('marketing/channel/store', ['uses' => 'app\crm\digitalmarketing\channelController@store','as' => 'crm.channel.store']);
   Route::get('marketing/{accountID}/channel/{code}/edit', ['uses' => 'app\crm\digitalmarketing\channelController@edit','as' => 'crm.channel.edit']);
   Route::post('marketing/channel/{code}/update', ['uses' => 'app\crm\digitalmarketing\channelController@update','as' => 'crm.channel.update']);
   Route::get('marketing/channel/{code}/delete', ['uses' => 'app\crm\digitalmarketing\channelController@delete','as' => 'crm.channel.delete']);

   /* === ur Shortener === */
   Route::get('shortener',['uses' => 'app\cms\shortener\ShortenerController@index','as' => 'url.shortener']);
   Route::post('/store/url/',['uses' => 'app\cms\shortener\ShortenerController@store','as' => 'url.store']);
   Route::get('/url/{code}',['uses' => 'app\cms\shortener\ShortenerController@get', 'as' => 'url.get']);
   Route::get('/short/{code}/delete', 'app\cms\shortener\ShortenerController@delete')->name('url.delete');


   /*==================== deals ====================*/
   //deals
   Route::get('deals', ['uses' => 'app\crm\deals\dealsController@index','as' => 'crm.deals.index']);
   Route::get('deals/grid', ['uses' => 'app\crm\deals\dealsController@grid','as' => 'crm.deals.grid']);
   Route::get('deal/create', ['uses' => 'app\crm\deals\dealsController@create','as' => 'crm.deals.create']);
   Route::post('deal/store', ['uses' => 'app\crm\deals\dealsController@store','as' => 'crm.deals.store']);
   Route::get('deal/{code}/edit', ['uses' => 'app\crm\deals\dealsController@edit','as' => 'crm.deals.edit']);
   Route::post('deal/{code}/update', ['uses' => 'app\crm\deals\dealsController@update','as' => 'crm.deals.update']);
   Route::get('deal/{code}/show', ['uses' => 'app\crm\deals\dealsController@show','as' => 'crm.deals.show']);
   Route::get('deal/{code}/delete', ['uses' => 'app\crm\deals\dealsController@delete','as' => 'crm.deals.delete']);

   Route::get('deal/{code}/stages', ['uses' => 'app\crm\deals\dealsController@stages','as' => 'crm.deals.stages']);
   Route::get('deal/stage/change', ['uses' => 'app\crm\deals\dealsController@stage_change','as' => 'crm.deals.stage.change']);

   //deal call log
   Route::get('deal/{code}/call_log', ['uses' => 'app\crm\deals\calllogController@index','as' => 'crm.deals.calllog.index']);
   Route::post('deal/{code}/call_log/store', ['uses' => 'app\crm\deals\calllogController@store','as' => 'crm.deals.calllog.store']);
   Route::post('deal/{code}/call_log/update', ['uses' => 'app\crm\deals\calllogController@update','as' => 'crm.deals.calllog.update']);
   Route::get('deal/{code}/call_log/delete', ['uses' => 'app\crm\deals\calllogController@delete','as' => 'crm.deals.calllog.delete']);

   //deal notes
   Route::get('deal/{code}/notes', ['uses' => 'app\crm\deals\notesController@index','as' => 'crm.deals.notes.index']);
   Route::post('deal/{code}/notes/store', ['uses' => 'app\crm\deals\notesController@store','as' => 'crm.deals.notes.store']);
   Route::post('deal/{code}/notes/update', ['uses' => 'app\crm\deals\notesController@update','as' => 'crm.deals.notes.update']);
   Route::get('deal/{code}/notes/delete', ['uses' => 'app\crm\deals\notesController@delete','as' => 'crm.deals.notes.delete']);

   //deal task
   Route::get('deal/{code}/task', ['uses' => 'app\crm\deals\tasksController@index','as' => 'crm.deals.task.index']);
   Route::post('deal/{code}/task/store', ['uses' => 'app\crm\deals\tasksController@store','as' => 'crm.deals.task.store']);
   Route::post('deal/{code}/task/update', ['uses' => 'app\crm\deals\tasksController@update','as' => 'crm.deals.task.update']);
   Route::get('deal/{code}/task/delete', ['uses' => 'app\crm\deals\tasksController@delete','as' => 'crm.deals.task.delete']);

   //deal appointments
   Route::get('deal/{code}/appointments', ['uses' => 'app\crm\deals\appointmentsController@index','as' => 'crm.deals.appointments.index']);
   Route::post('deal/{code}/appointments/store', ['uses' => 'app\crm\deals\appointmentsController@store','as' => 'crm.deals.appointments.store']);
   Route::post('deal/{code}/appointments/update', ['uses' => 'app\crm\deals\appointmentsController@update','as' => 'crm.deals.appointments.update']);
   Route::get('deal/{code}/appointments/delete', ['uses' => 'app\crm\deals\appointmentsController@delete','as' => 'crm.deals.appointments.delete']);


   //pipeline
   Route::get('pipeline', ['uses' => 'app\crm\deals\pipelineController@index','as' => 'crm.pipeline.index']);
   Route::post('pipeline/store', ['uses' => 'app\crm\deals\pipelineController@store','as' => 'crm.pipeline.store']);
   Route::get('pipeline/{code}/edit', ['uses' => 'app\crm\deals\pipelineController@edit','as' => 'crm.pipeline.edit']);
   Route::post('pipeline/{code}/update', ['uses' => 'app\crm\deals\pipelineController@update','as' => 'crm.pipeline.update']);
   Route::get('pipeline/{code}/show', ['uses' => 'app\crm\deals\pipelineController@show','as' => 'crm.pipeline.show']);
   Route::get('pipeline/{code}/delete', ['uses' => 'app\crm\deals\pipelineController@delete','as' => 'crm.pipeline.delete']);

   //stage
   Route::post('pipeline/stages/store', ['uses' => 'app\crm\deals\stagesController@store','as' => 'crm.pipeline.stage.store']);
   Route::get('pipeline/stages/{code}/edit', ['uses' => 'app\crm\deals\stagesController@edit','as' => 'crm.pipeline.stage.edit']);
   Route::post('pipeline/stages/{code}/update', ['uses' => 'app\crm\deals\stagesController@update','as' => 'crm.pipeline.stage.update']);
   Route::get('pipeline/stages/{code}/delete', ['uses' => 'app\crm\deals\stagesController@delete','as' => 'crm.pipeline.stage.delete']);
   Route::put('pipeline/stages/position', ['uses' => 'app\crm\deals\stagesController@position','as' => 'stage_position_update']);

   /*==================== reports ====================*/
   //reports dashboard
   Route::get('reports', ['uses' => 'app\crm\reports\dashboardController@dashboard','as' => 'crm.reports']);

   //lead by status
   Route::get('reports/leads_by_status', ['uses' => 'app\crm\reports\leadsByStatusController@filter','as' => 'crm.reports.leads.status.filter']);
   Route::get('reports/leads_by_status/export/{statusID}/{start}/{end}', ['uses' => 'app\crm\reports\leadsByStatusController@export','as' => 'crm.reports.leads.status.export']);

   //lead by source
   Route::get('reports/leads_by_source', ['uses' => 'app\crm\reports\leadsBySourceController@filter','as' => 'crm.reports.leads.source.filter']);
   Route::get('reports/leads_by_source/export/{sourceID}/{start}/{end}', ['uses' => 'app\crm\reports\leadsBySourceController@export','as' => 'crm.reports.leads.source.export']);

   //lead by industry
   Route::get('reports/leads_by_industry', ['uses' => 'app\crm\reports\leadsByIndustryController@filter','as' => 'crm.reports.leads.industry.filter']);
   Route::get('reports/leads_by_industry/export/{sourceID}/{start}/{end}', ['uses' => 'app\crm\reports\leadsByIndustryController@export','as' => 'crm.reports.leads.industry.export']);




});


/*
|--------------------------------------------------------------------------
| Project Management
|--------------------------------------------------------------------------
|
| Manage contents of your website quick and first
|
|
|
*/
Route::prefix('jobs')->middleware('auth')->group(function () {

   Route::get('/dashboard', ['uses' => 'app\jobs\jobsManagementController@dashboard','as' => 'jobs.dashboard']);

   /*==================== Jobs =======================*/
   Route::get('/list', [ 'uses' => 'app\jobs\jobsController@index','as' => 'job.index']);
   Route::get('/job/create', ['uses' => 'app\jobs\jobsController@create','as' => 'job.create']);
   Route::post('/job/store', ['uses' => 'app\jobs\jobsController@store', 'as' => 'job.store']);

   Route::get('/job/{jobCode}/dashboard', ['uses' => 'app\jobs\jobsController@dashboard', 'as' => 'job.dashboard']);
   Route::get('/job/{code}/details', ['uses' => 'app\jobs\jobsController@show', 'as' => 'job.show']);

   Route::get('/job/{jobCode}/budget', ['uses' => 'app\jobs\jobsController@budget', 'as' => 'job.budget']);

   Route::get('/job/{jobCode}/users', ['uses' => 'app\jobs\jobsController@users', 'as' => 'job.users']);

   Route::get('/job/{jobCode}/activity', ['uses' => 'app\jobs\jobsController@activity', 'as' => 'job.activity']);

   Route::get('/job/{jobCode}/settings', ['uses' => 'app\jobs\jobsController@settings', 'as' => 'job.settings']);

   Route::get('/job/{code}/edit', ['uses' => 'app\jobs\jobsController@edit', 'as' => 'job.edit']);
   Route::post('/job/update/{code}', ['uses' => 'app\jobs\jobsController@update', 'as' => 'job.update']);
   Route::get('/job/destroy/{code}', ['uses' => 'app\jobs\jobsController@destroy', 'as' => 'job.destroy']);

   /*==================== Discussions =======================*/
   Route::get('/job/{code}/discussions', ['uses' => 'app\jobs\discussionsController@index','as' => 'job.discussions']);
   Route::post('/job/discussions/store', ['uses' => 'app\jobs\discussionsController@store','as' => 'job.discussions.store']);
   Route::get('/job/{jobCode}/discussions/{code}/delete', ['uses' => 'app\jobs\discussionsController@delete','as' => 'job.discussions.delete']);

   /*==================== tasks =======================*/
   Route::get('/job/{jobCode}/tasks', ['uses' => 'app\jobs\taskController@tasks','as' => 'job.task']);
   Route::get('/job/{jobCode}/section/{sectionCode}/{sectionName}', ['uses' => 'app\jobs\taskController@section','as' => 'job.task.section']);
   Route::get('/job/{code}/tasks/create', [ 'uses' => 'app\jobs\taskController@create','as' => 'task.create']);
   Route::post('tasks/store', [ 'uses' => 'app\jobs\taskController@store','as' => 'task.store']);
   Route::get('/job/{projectID}/tasks/{taskID}/show', ['uses' => 'app\jobs\taskController@show','as' => 'task.show']);
   Route::get('/job/{projectID}/tasks/{taskID}/edit', ['uses' => 'app\jobs\taskController@edit','as' => 'task.edit']);
   Route::get('/job/{jobcode}/tasks/{taskcode}/status', ['uses' => 'app\jobs\taskController@complete','as' => 'task.complete']);
   Route::post('/job/tasks/{code}/update', ['uses' => 'app\jobs\taskController@update','as' => 'task.update']);
   Route::get('/job/tasks/{code}/delete', ['uses' => 'app\jobs\taskController@delete','as' => 'task.delete']);

   Route::get('/job/tasks/group/change', ['uses' => 'app\jobs\taskController@group_change','as' => 'task.group.change']);

   Route::get('/tasks', ['uses' => 'app\jobs\taskController@all','as' => 'task.all']);
   Route::get('/job/tasks/{userID}/incomplete', ['uses' => 'app\jobs\taskController@incomplete','as' => 'task.all.user.incomplete']);
   Route::get('/job/tasks/all/incomplete/t', ['uses' => 'app\jobs\taskController@all_incomplete','as' => 'task.all.incomplete']);

   //group
   Route::post('/job/task/group',['uses' => 'app\jobs\grouptaskController@store','as' => 'task.group.store']);
   Route::get('/job/task/group/{code}/edit',['uses' => 'app\jobs\grouptaskController@edit','as' => 'task.group.edit']);
   Route::post('/job/task/group/update',['uses' => 'app\jobs\grouptaskController@update','as' => 'task.group.update']);
   Route::get('/job/task/group/{code}/delete',['uses' => 'app\jobs\grouptaskController@delete','as' => 'task.group.delete']);

   //comments
   Route::post('/job/comment/store', ['uses' => 'app\jobs\taskController@comment','as' =>'task.comment.store']);
   Route::get('/job/{projectCode}/tasks/comment/{code}/delete', ['uses' => 'app\jobs\taskController@delete_comment','as' =>'task.comment.delete']);

   //delete file
   Route::get('/job/{pid}/tasks/files/{code}/delete', ['uses' => 'app\jobs\taskController@delete_file','as' =>'task.file.delete']);

   //task filters
   Route::get('/{projectID}/tasks/filter/overdue', ['uses' =>'app\jobs\tasksFilterController@overdue','as' =>'task.filter.overdue']);
   Route::get('/{projectID}/tasks/filter/today', ['uses' =>'app\jobs\tasksFilterController@today','as' =>'task.filter.today']);
   Route::get('/{projectID}/tasks/filter/last-7-days', ['uses' =>'app\jobs\tasksFilterController@last_seven','as' =>'task.last.seven.days']);

   /*==================== my tasks =======================*/
   Route::get('/my-tasks', ['uses' => 'app\jobs\myTaskController@list','as' => 'job.mytask.list']);

   /*==================== tickets =======================*/
   Route::get('/job/{pid}/tickets',['uses' => 'app\jobs\ticketsController@index','as' => 'job.tickets.index']);
   Route::post('/job/tickets/store',['uses' => 'app\jobs\ticketsController@store','as' => 'job.tickets.store']);
   Route::get('/job/{projectID}/tickets/{ticketID}/edit',['uses' => 'app\jobs\ticketsController@edit','as' => 'job.tickets.edit']);
   Route::get('/job/{projectID}/tickets/{ticketID}/show',['uses' => 'app\jobs\ticketsController@show','as' => 'job.tickets.show']);
   Route::post('/job/tickets/{tid}/update',['uses' => 'app\jobs\ticketsController@update','as' => 'job.tickets.update']);
   Route::get('/job/{code}/tickets/{tid}/delete',['uses' => 'app\jobs\ticketsController@delete','as' => 'job.tickets.delete']);

   //comments
   Route::post('/job/tickets/comment',['uses' => 'app\jobs\ticketsController@comment','as' => 'job.tickets.comment']);
   Route::get('/job/tickets/comment/{code}/delete',['uses' => 'app\jobs\ticketsController@delete_comment','as' => 'job.tickets.comment.delete']);

   //delete ticket document
   Route::get('/job/{pid}/tickets/documents/{code}/delete',['uses' => 'app\jobs\ticketsController@delete_file','as' => 'job.tickets.document.delete']);

   /*==================== note =======================*/
   Route::get('/job/{code}/notes', ['uses' => 'app\jobs\notesController@index','as' => 'job.notes']);
   Route::get('/job/{jobcode}/notes/{notecode}/edit', ['uses' => 'app\jobs\notesController@edit','as' => 'job.notes.edit']);
   Route::post('/job/{jobcode}/notes/{code}/update', ['uses' => 'app\jobs\notesController@update','as' => 'job.notes.update']);
   Route::get('/job/{pid}/notes/{code}/delete', ['uses' => 'app\jobs\notesController@delete','as' => 'job.notes.delete']);

   /*==================== files =======================*/
   Route::get('/job/{jobcode}/files', ['uses' => 'app\jobs\filesController@index','as' => 'job.files']);
   Route::post('/job/files/store', ['uses' => 'app\jobs\filesController@store','as' => 'job.files.store']);

   /*==================== events =======================*/
   Route::get('/job/{jobcode}/events', ['uses' => 'app\jobs\eventsController@index','as' => 'job.events']);
   Route::post('/job/events/store', ['uses' => 'app\jobs\eventsController@store','as' => 'job.events.store']);
   Route::get('/job/events/{jobcode}/{eventcode}/edit', ['uses' => 'app\jobs\eventsController@edit','as' => 'job.events.edit']);
   Route::post('/job/events/{eventcode}/update', ['uses' => 'app\jobs\eventsController@update','as' => 'job.events.update']);
   Route::post('/job/events/{jobcode}/results', ['uses' => 'app\jobs\eventsController@results','as' => 'job.events.results']);
   Route::get('/job/events/{jobcode}/{code}/show', ['uses' => 'app\jobs\eventsController@show','as' => 'job.events.show']);
   Route::get('/job/events/{jobcode}/{code}/delete', ['uses' => 'app\jobs\eventsController@delete','as' => 'job.events.delete']);


   /*==================== to do list =======================*/
   Route::get('/todo', ['uses' => 'app\jobs\todoController@index','as' => 'todo.index']);

   /*==================== Goal =======================*/
   Route::get('/job/events/{jobcode}/goals', ['uses' => 'app\jobs\goalsController@goals','as' => 'job.goals']);

   /*==================== clients =======================*/
   Route::get('/clients', ['uses' => 'app\jobs\clientsController@index','as' => 'job.clients.index']);
});


/*
|--------------------------------------------------------------------------
| Assets
|--------------------------------------------------------------------------
*/
Route::prefix('assets')->middleware('auth')->group(function () {
   Route::get('/dashboard', ['uses' => 'app\assets\dashboardController@dashboard','as' => 'assets.dashboard']);

   //assets
   Route::get('/list', ['uses' => 'app\assets\asset\assetsController@index','as' => 'assets.index']);
   Route::get('/create', ['uses' => 'app\assets\asset\assetsController@create','as' => 'assets.create']);
   Route::post('/store', ['uses' => 'app\assets\asset\assetsController@store','as' => 'assets.store']);
   Route::get('/{code}/edit', ['uses' => 'app\assets\asset\assetsController@edit','as' => 'assets.edit']);
   Route::post('/{code}/update', ['uses' => 'app\assets\asset\assetsController@update','as' => 'assets.update']);
   Route::get('/{code}/view', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.show']);
   Route::get('/{code}/finance', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.finance']);
   Route::get('/{code}/delete', ['uses' => 'app\assets\asset\assetsController@delete','as' => 'assets.delete']);

   Route::get('/retrive/model/{code}', 'app\assets\asset\assetsController@retrive_model')->name('model.retrive');
   Route::get('/{code}/vehicle', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.details.vehicle']);

   Route::get('/{code}/remove-image', 'app\assets\asset\assetsController@remove_image')->name('assets.image.remove');

   //asset maintenances
   Route::get('/{code}/maintenances', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.maintenances.index']);
   Route::get('/{code}/maintenance/create', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.maintenances.create']);
   Route::post('/{code}/maintenance/store', ['uses' => 'app\assets\asset\maintenancesController@store','as' => 'assets.maintenances.store']);
   Route::get('/{asset}/maintenance/{edit}/edit', ['uses' => 'app\assets\asset\maintenancesController@edit','as' => 'assets.maintenances.edit']);
   Route::post('/{asset}/maintenance/{edit}/update', ['uses' => 'app\assets\asset\maintenancesController@update','as' => 'assets.maintenances.update']);
   Route::get('/{asset}/maintenance/{code}/delete', ['uses' => 'app\assets\asset\maintenancesController@delete','as' => 'assets.maintenances.delete']);

   //asset files
   Route::get('/{code}/files', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.files.index']);
   Route::post('/files/{code}/save', ['uses' => 'app\assets\asset\assetsController@add_file','as' => 'assets.files.add']);
   Route::get('/files/{code}/delete', ['uses' => 'app\assets\asset\assetsController@files','as' => 'assets.files.delete']);

   //asset events
   Route::get('/{asset}/events', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.event.index']);

   //checkout
   Route::get('/{asset}/checkout-checkin', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.event.checkout.checkin']);
   Route::post('/checkout/events/store', ['uses' => 'app\assets\asset\checkoutcheckinController@check_out_store','as' => 'assets.event.checkout.store']);
   Route::post('/checkout/{code}/events/update', ['uses' => 'app\assets\asset\checkoutcheckinController@check_out_update','as' => 'assets.event.checkout.update']);

   //checkin
   Route::post('/checkin/events/store', ['uses' => 'app\assets\asset\checkoutcheckinController@check_in_store','as' => 'assets.event.checkin.store']);
   Route::post('/checkin/{code}/events/update', ['uses' => 'app\assets\asset\checkoutcheckinController@check_in_update','as' => 'assets.event.checkin.update']);
   Route::get('/{asset}/checkout-checkin/{code}/delete', ['uses' => 'app\assets\asset\checkoutcheckinController@delete','as' => 'assets.checkout.checkin.delete']);

   //repairs
   Route::get('/{asset}/repairs', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.repairs']);
   Route::post('/{asset}/repair/store', ['uses' => 'app\assets\asset\repairController@store','as' => 'assets.repair.store']);
   Route::post('/{asset}/repair/{code}/update', ['uses' => 'app\assets\asset\assetsController@update','as' => 'assets.repair.update']);
   Route::get('/{asset}/repair/{code}/delete', ['uses' => 'app\assets\asset\assetsController@delete','as' => 'assets.repair.delete']);

   //lease
   Route::get('/{asset}/lease', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.leases']);
   Route::post('{asset}/lease/events/store', ['uses' => 'app\assets\asset\assetsController@lease_store','as' => 'assets.lease.store']);

   //missing
   Route::get('/{asset}/other/missing', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.other.events.missing']);
   Route::post('/{assset}/missing/asset/store', ['uses' => 'app\assets\asset\assetsController@missing_asset','as' => 'assets.other.events.missing.store']);

   //dispose
   Route::get('/{asset}/other/dispose', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.other.events.dispose']);
   Route::post('/{assset}/dispose/asset/store', ['uses' => 'app\assets\asset\assetsController@dispose_asset','as' => 'assets.other.events.dispose.store']);

   //donate
   Route::get('/{asset}/other/donate', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.other.events.donate']);
   Route::post('/{assset}/donate/asset/store', ['uses' => 'app\assets\asset\assetsController@donate_asset','as' => 'assets.other.events.donate.store']);

   //sell
   Route::get('/{asset}/other/sell', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.other.events.sell']);
   Route::post('/{assset}/sell/asset/store', ['uses' => 'app\assets\asset\assetsController@sell_asset','as' => 'assets.other.events.sell.store']);

   //map
   Route::get('/{asset}/location', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.location']);

   //licenses
   Route::get('/licenses', ['uses' => 'app\assets\license\licensesController@index','as' => 'licenses.assets.index']);
   Route::get('/licenses/create', ['uses' => 'app\assets\license\licensesController@create','as' => 'licenses.assets.create']);
   Route::post('/licenses/store', ['uses' => 'app\assets\license\licensesController@store','as' => 'licenses.assets.store']);
   Route::get('/licenses/{code}/edit', ['uses' => 'app\assets\license\licensesController@edit','as' => 'licenses.assets.edit']);
   Route::post('/licenses/{code}/update', ['uses' => 'app\assets\license\licensesController@update','as' => 'licenses.assets.update']);
   Route::get('/licenses/{code}/view', ['uses' => 'app\assets\license\licensesController@show','as' => 'licenses.assets.show']);
   Route::get('/licenses/{code}/delete', ['uses' => 'app\assets\license\licensesController@delete','as' => 'licenses.assets.delete']);

   //licenses maintenances
   Route::get('licenses/{code}/maintenances', ['uses' => 'app\assets\license\licensesController@show','as' => 'licenses.maintenances.index']);
   Route::get('licenses/{code}/maintenance/create', ['uses' => 'app\assets\license\maintenancesController@show','as' => 'licenses.maintenances.create']);
   Route::post('licenses/{code}/maintenance/store', ['uses' => 'app\assets\license\maintenancesController@store','as' => 'licenses.maintenances.store']);
   Route::get('licenses/{asset}/maintenance/{edit}/edit', ['uses' => 'app\assets\license\maintenancesController@edit','as' => 'licenses.maintenances.edit']);
   Route::post('licenses/{asset}/maintenance/{edit}/update', ['uses' => 'app\assets\license\maintenancesController@update','as' => 'licenses.maintenances.update']);
   Route::get('licenses/{asset}/maintenance/{code}/delete', ['uses' => 'app\assets\license\maintenancesController@delete','as' => 'licenses.maintenances.delete']);

   //assets type
   Route::get('/types', ['uses' => 'app\assets\typeController@index','as' => 'assets.type.index']);
   Route::post('/type/store', ['uses' => 'app\assets\typeController@store','as' => 'assets.type.store']);
   Route::get('/type/{code}/edit', ['uses' => 'app\assets\typeController@edit','as' => 'assets.type.edit']);
   Route::post('/type/{code}/update', ['uses' => 'app\assets\typeController@update','as' => 'assets.type.update']);
   Route::get('/type/{code}/delete', ['uses' => 'app\assets\typeController@delete','as' => 'assets.type.delete']);

});


/*
|--------------------------------------------------------------------------
| Subscription
|--------------------------------------------------------------------------
|
| Manage subscription services
*/
Route::prefix('subscriptions')->middleware('auth')->group(function () {
   Route::get('/', ['uses' => 'app\subscriptions\dashboardController@dashboard','as' => 'subscriptions.dashboard']);

   /* === products === */
   Route::get('products', ['uses' => 'app\subscriptions\productsController@index','as' => 'subscriptions.products.index']);
   Route::get('products/create', ['uses' => 'app\subscriptions\productsController@create','as' => 'subscriptions.products.create']);
   Route::post('products/store', ['uses' => 'app\subscriptions\productsController@store','as' => 'subscriptions.products.store']);
   Route::get('products/{code}/edit', ['uses' => 'app\subscriptions\productsController@edit','as' => 'subscriptions.products.edit']);
   Route::post('products/{code}/update', ['uses' => 'app\subscriptions\productsController@update','as' => 'subscriptions.products.update']);
   Route::get('products/{code}/delete', ['uses' => 'app\subscriptions\productsController@delete','as' => 'subscriptions.products.delete']);

   /* === plan === */
   Route::get('plan/{code}', ['uses' => 'app\subscriptions\planController@index','as' => 'subscriptions.plan.index']);
   Route::get('plan/{code}/create', ['uses' => 'app\subscriptions\planController@create','as' => 'subscriptions.plan.create']);
   Route::post('plan/store', ['uses' => 'app\subscriptions\planController@stoplanre','as' => 'subscriptions.plan.store']);
   Route::get('plan/{code}/edit/{pid}', ['uses' => 'app\subscriptions\planController@edit','as' => 'subscriptions.plan.edit']);
   Route::post('plan/{code}/update', ['uses' => 'app\subscriptions\planController@update','as' => 'subscriptions.plan.update']);
   Route::get('plan/{code}/delete', ['uses' => 'app\subscriptions\planController@delete','as' => 'subscriptions.plan.delete']);

   /* === customers === */
   Route::get('customer',['uses' => 'app\subscriptions\customerController@index','as' => 'subscription.customer.index']);
   Route::get('customer/create',['uses' => 'app\subscriptions\customerController@create','as' => 'subscription.customer.create']);
   Route::post('post-customer',['uses' => 'app\subscriptions\customerController@store','as' => 'subscription.customer.store']);
   Route::get('customer/{code}/edit',['uses' => 'app\subscriptions\customerController@edit','as' => 'subscription.customer.edit']);
   Route::post('customer/{code}/update',['uses' => 'app\subscriptions\customerController@update','as' => 'subscription.customer.update']);
   Route::get('customer/{code}/show',['uses' => 'app\subscriptions\customerController@show','as' => 'subscription.customer.show']);
   Route::get('customer/{code}/delete',['uses' => 'app\subscriptions\customerController@delete','as' => 'subscription.customer.delete']);
   Route::get('customer/{code}/delete',['uses' => 'app\subscriptions\customerController@trash','as' => 'subscription.customer.delete']);

   /* === subscriptions === */
   Route::get('/all',['uses' => 'app\subscriptions\subscriptionController@index','as' => 'subscriptions.index']);
   Route::get('/create',['uses' => 'app\subscriptions\subscriptionController@create','as' => 'subscriptions.create']);
   Route::post('/store',['uses' => 'app\subscriptions\subscriptionController@store','as' => 'subscriptions.store']);
   Route::get('/{code}/edit',['uses' => 'app\subscriptions\subscriptionController@edit','as' => 'subscriptions.edit']);
   Route::post('{code}/update',['uses' => 'app\subscriptions\subscriptionController@update','as' => 'subscriptions.update']);
   Route::get('/{code}/delete',['uses' => 'app\subscriptions\subscriptionController@delete','as' => 'subscriptions.delete']);
   Route::get('/{code}/details',['uses' => 'app\subscriptions\subscriptionController@show','as' => 'subscriptions.show']);
   Route::get('/{code}/invoices',['uses' => 'app\subscriptions\subscriptionController@invoices','as' => 'subscriptions.invoices']);
   Route::get('/{code}/renew',['uses' => 'app\subscriptions\subscriptionController@renew','as' => 'subscriptions.renew']);
   Route::get('/{code}/cancel',['uses' => 'app\subscriptions\subscriptionController@cancel','as' => 'subscriptions.cancel']);

   //get plans
   Route::get('/{code}/plans',['uses' => 'app\subscriptions\subscriptionController@plan','as' => 'subscriptions.plan']);
   Route::get('/plans/{code}/price',['uses' => 'app\subscriptions\subscriptionController@plan_price']);

   //import customer
   Route::get('subscription/import',['uses' => 'app\subscriptions\importController@import','as' => 'subscription.customer.import']);
   Route::post('subscription/import/store',['uses' => 'app\subscriptions\importController@import_customer','as' => 'subscription.contact.import.store']);
   Route::get('subscription/download/import/sample/',['uses' => 'app\subscriptions\importController@download_import_sample','as' => 'subscription.customer.download.sample.import']);

   //export customer list
   Route::get('customer/export/{type}',['uses' => 'app\subscriptions\importController@export','as' => 'subscription.customer.export']);

   /* === invoice === */
   Route::get('invoice',['uses' => 'app\subscriptions\invoiceController@index','as' => 'subscription.invoice.index']);
   Route::get('invoice/{code}/show',['uses' => 'app\subscriptions\invoiceController@show','as' => 'subscription.invoice.show']);


   /* === settings === */
   Route::get('/settings',['uses' => 'app\subscriptions\settingsController@index','as' => 'subscriptions.settings.index']);

});


/*
|--------------------------------------------------------------------------
| Point of sale
|--------------------------------------------------------------------------
|
| Manage contents of your website quick and first
*/
Route::prefix('pos')->middleware('auth')->group(function () {
   /* === Dashboard === */
   Route::get('/dashboard',['uses' => 'app\pos\posController@dashboard','as' => 'pos.dashboard']);

   /* === terminal === */
   Route::get('sales/terminal',['uses' => 'app\pos\posController@sales','as' => 'pos.sell']);
   Route::post('cart/{cartID}/update',['uses' => 'app\pos\posController@update_cart','as' => 'pos.update.cart']);
   Route::get('cart/item/{cartID}/remove',['uses' => 'app\pos\posController@remove_cart_item','as' => 'pos.remove.cart.item']);
   Route::get('cancel/order',['uses' => 'app\pos\posController@cancel_sale','as' => 'pos.cancel.order']);

   Route::post('sale/apply/tax',['uses' => 'app\pos\posController@apply_sale','as' => 'pos.sale.tax.apply']);
   Route::get('sale/remove/tax',['uses' => 'app\pos\posController@remove_tax','as' => 'pos.sale.remove.tax']);

   Route::get('sale/checkout',['uses' => 'app\pos\posController@sale_checkout','as' => 'pos.sale.checkout']);

   Route::post('save/order',['uses' => 'app\pos\posController@save_sale','as' => 'pos.save.order']);
   Route::get('sale/{saleID}/details',['uses' => 'app\pos\posController@sale_view','as' => 'pos.sale.details']);
   Route::get('sale/{saleID}/receipt/print',['uses' => 'app\pos\posController@receipt_print','as' => 'pos.sale.receipt.print']);
   Route::post('sale/receipt/mail',['uses' => 'app\pos\posController@receipt_mail','as' => 'pos.sale.receipt.mail']);

   /* === sales report === */
   Route::get('sales/history', ['uses' => 'app\pos\salesController@index', 'as' => 'sales.history']);
   Route::get('history/{code}/details', ['uses' => 'app\pos\salesController@show', 'as' => 'history.details']);
   Route::get('print/receipt/{code}', ['uses' => 'app\pos\salesController@print', 'as' => 'pos.print.receipt']);

   /* === complete order === */
   //Route::post('save/order', ['uses' => 'app\pos\posController@save_order', 'as' => 'save.order']);
   Route::get('make/payment/{invoiceID}/{gatewayID}', ['uses' => 'app\pos\posController@make_payment', 'as' => 'make.payment']);
   Route::get('complete/payment/{invoiceID}/{gatewayID}', ['uses' => 'app\pos\posController@complete_payment', 'as' => 'complete.payment']);
   Route::get('order/{code}/receipt', ['uses' => 'app\pos\posController@order_receipt', 'as' => 'order.receipt']);

   /* === products === */
   Route::get('products',['uses' => 'app\pos\productsController@index','as' => 'pos.products']);
   Route::get('product/create',['uses' => 'app\pos\productsController@create','as' => 'pos.products.create']);
   Route::post('product/store',['uses' => 'app\pos\productsController@store','as' => 'pos.products.store']);
   Route::get('product/{code}/edit',['uses' => 'app\pos\productsController@edit','as' => 'pos.products.edit']);
   Route::post('product/{code}/update',['uses' => 'app\pos\productsController@update','as' => 'pos.products.update']);
   Route::get('product/{code}/details',['uses' => 'app\pos\productsController@details','as' => 'pos.products.details']);
   Route::get('product/{code}/destroy',['uses' => 'app\pos\productsController@destroy','as' => 'pos.products.destroy']);

   /* === product price === */
   Route::get('products/{code}/price',['uses' => 'app\pos\productsPriceController@price','as' => 'pos.products.price']);
   Route::post('products/{code}/price/update',['uses' => 'app\pos\productsPriceController@price_update','as' => 'pos.products.price.update']);

   /* === product inventory === */
   Route::get('product/inventory/{code}/edit',['uses' => 'app\pos\inventoryController@inventory','as' => 'pos.inventory']);
   Route::post('product/{code}/inventory/{productID}/update',['uses' => 'app\pos\inventoryController@inventory_update','as' => 'pos.inventory.update']);
   Route::post('product/inventory/settings/{productID}/update',['uses' => 'app\pos\inventoryController@inventory_settings','as' => 'pos.inventory.settings.update']);
   Route::post('product/inventory/outlet/link',['uses' => 'app\pos\inventoryController@inventory_outlet_link','as' => 'pos.inventory.outlet.link']);
   Route::get('product/{productID}/inventory/outle/{code}/link/delete',['uses' => 'app\pos\inventoryController@delete_inventroy','as' => 'pos.inventory.outlet.link.delete']);

   /* === product images === */
   Route::get('product/images/{code}/edit',['uses' => 'app\pos\imagesController@edit','as' => 'pos.product.images']);
   Route::post('product/images/{code}/update',['uses' => 'app\pos\imagesController@update','as' => 'pos.product.images.update']);
   Route::post('product/images/store',['uses' => 'app\pos\imagesController@store','as' => 'pos.product.images.store']);
   Route::get('product/{code}/images/{imageCode}/delete',['uses' => 'app\pos\imagesController@delete','as' => 'pos.product.images.delete']);

   /* === product settings === */
   Route::get('product/{code}/settings',['uses' => 'app\pos\settingsController@edit','as' => 'pos.product.settings.edit']);
   Route::get('product/{code}/settings/update',['uses' => 'app\pos\settingsController@update','as' => 'pos.product.settings.update']);

   /* === stock control === */
   Route::get('stock/control/',['uses' => 'app\pos\stockcontrolController@index','as' => 'pos.product.stock.control']);
   Route::get('order/stock',['uses' => 'app\pos\stockcontrolController@order','as' => 'pos.product.stock.order']);
   Route::get('order/stock/{code}/show',['uses' => 'app\pos\stockcontrolController@show','as' => 'pos.product.stock.order.show']);
   Route::post('post/order/stock',['uses' => 'app\pos\stockcontrolController@store','as' => 'pos.product.stock.order.post']);
   Route::post('lpo/ajax/price','app\pos\stockcontrolController@productPrice')->name('pos.ajax.product.stock.price');
   Route::get('order/stock/{code}/edit',['uses' => 'app\pos\stockcontrolController@edit','as' => 'pos.product.stock.order.edit']);
   Route::post('order/stock/{code}/update',['uses' => 'app\pos\stockcontrolController@update','as' => 'pos.product.stock.order.update']);
   Route::get('order/stock/{code}/pdf',['uses' => 'app\pos\stockcontrolController@pdf','as' => 'pos.product.stock.order.pdf']);
   Route::get('order/stock/{code}/print',['uses' => 'app\pos\stockcontrolController@print','as' => 'pos.product.stock.order.print']);
   Route::get('order/stock/{code}/delivered',['uses' => 'app\pos\stockcontrolController@delivered','as' => 'pos.stock.delivered']);

   //send order
   Route::get('stock/{code}/mail',['uses' => 'app\pos\stockcontrolController@mail','as' => 'pos.stock.mail']);
   Route::post('stock/mail/send',['uses' => 'app\pos\stockcontrolController@send','as' => 'pos.stock.mail.send']);
   Route::post('stock/attach/files',['uses' => 'app\pos\stockcontrolController@attachment_files','as' => 'pos.stock.attach']);


   /* === product category === */
   Route::get('product/category',['uses' => 'app\pos\categoryController@index','as' => 'pos.product.category']);
   Route::post('product/category/store',['uses' => 'app\pos\categoryController@store','as' => 'pos.product.category.store']);
   Route::get('product/category/{code}/edit',['uses' => 'app\pos\categoryController@edit','as' => 'pos.product.category.edit']);
   Route::post('product.category/{code}/update',['uses' => 'app\pos\categoryController@update','as' => 'pos.product.category.update']);
   Route::get('product/category/{code}/destroy',['uses' => 'app\pos\categoryController@destroy','as' => 'pos.product.category.destroy']);

   /* === product brands === */
   Route::get('product/brand',['uses' => 'app\pos\brandController@index','as' => 'pos.product.brand']);
   Route::post('product/brand/store',['uses' => 'app\pos\brandController@store','as' => 'pos.product.brand.store']);
   Route::get('product/brand/{code}/edit',['uses' => 'app\pos\brandController@edit','as' => 'pos.product.brand.edit']);
   Route::post('product.brand/{code}/update',['uses' => 'app\pos\brandController@update','as' => 'pos.product.brand.update']);
   Route::get('product/brand/{code}/destroy',['uses' => 'app\pos\brandController@destroy','as' => 'pos.product.brand.destroy']);

   /* === product tags === */
   Route::get('product/tags',['uses' => 'app\pos\tagsController@index','as' => 'pos.product.tags']);
   Route::post('product/tags/store',['uses' => 'app\pos\tagsController@store','as' => 'pos.product.tags.store']);
   Route::get('product/tags/{code}/edit',['uses' => 'app\pos\tagsController@edit','as' => 'pos.product.tags.edit']);
   Route::post('product.tags/{code}/update',['uses' => 'app\pos\tagsController@update','as' => 'pos.product.tags.update']);
   Route::get('product/tags/{code}/destroy',['uses' => 'app\pos\tagsController@destroy','as' => 'pos.product.tags.destroy']);

   /* === supplier === */
   Route::get('supplier',['uses' => 'app\pos\supplier\supplierController@index','as' => 'pos.supplier.index']);
   Route::get('supplier/create',['uses' => 'app\pos\supplier\supplierController@create','as' => 'pos.supplier.create']);
   Route::post('post-supplier',['uses' => 'app\pos\supplier\supplierController@store','as' => 'pos.supplier.store']);
   Route::get('supplier/{code}/edit',['uses' => 'app\pos\supplier\supplierController@edit','as' => 'pos.supplier.edit']);
   Route::post('supplier/{code}/update',['uses' => 'app\pos\supplier\supplierController@update','as' => 'pos.supplier.update']);
   Route::get('supplier/{code}/show',['uses' => 'app\pos\supplier\supplierController@show','as' => 'pos.supplier.show']);
   Route::get('supplier/{code}/delete',['uses' => 'app\pos\supplier\supplierController@delete','as' => 'pos.supplier.delete']);
   Route::get('delete-supplier-person/{code}',['uses' => 'app\pos\supplier\supplierController@delete_contact_person','as' => 'pos.supplier.vendor.person']);
   Route::get('supplier/{code}/trash',['uses' => 'app\pos\supplier\supplierController@trash','as' => 'pos.supplier.trash.update']);
   Route::get('supplier/download/import/sample/',['uses' => 'app\pos\supplier\importController@download_import_sample','as' => 'pos.supplier.download.sample.import']);

   //express suppliers
   Route::get('express/supplier/list',['uses' => 'app\pos\supplier\supplierController@express_list','as' => 'pos.supplier.express.list']);
   Route::post('express/supplier/save',['uses' => 'app\pos\supplier\supplierController@express_save','as' => 'pos.supplier.express.store']);

   //supplier category
   Route::get('supplier/category',['uses' => 'app\pos\supplier\groupsController@index','as' => 'pos.supplier.groups.index']);
   Route::post('supplier/category/store',['uses' => 'app\pos\supplier\groupsController@store','as' => 'pos.supplier.groups.store']);
   Route::get('supplier/category/{code}/edit',['uses' => 'app\pos\supplier\groupsController@edit','as' => 'pos.supplier.groups.edit']);
   Route::post('supplier/category/{code}/update',['uses' => 'app\pos\supplier\groupsController@update','as' => 'pos.supplier.groups.update']);
   Route::get('supplier/category/{code}/delete',['uses' => 'app\pos\supplier\groupsController@delete','as' => 'pos.supplier.groups.delete']);

   //import
   Route::get('supplier/import',['uses' => 'app\pos\supplier\importController@index','as' => 'pos.supplier.import.index']);
   Route::post('supplier/post/import',['uses' => 'app\pos\supplier\importController@import','as' => 'pos.supplier.import']);

   //export
   Route::get('supplier/export/{type}',['uses' => 'app\pos\supplier\importController@export','as' => 'pos.supplier.export']);

   /* === customer === */
   Route::get('customer',['uses' => 'app\pos\contact\contactController@index','as' => 'pos.contact.index']);
   Route::get('customer/create',['uses' => 'app\pos\contact\contactController@create','as' => 'pos.contact.create']);
   Route::post('post-customer',['uses' => 'app\pos\contact\contactController@store','as' => 'pos.contact.store']);
   Route::get('customer/{code}/edit',['uses' => 'app\pos\contact\contactController@edit','as' => 'pos.contact.edit']);
   Route::post('customer/{code}/update',['uses' => 'app\pos\contact\contactController@update','as' => 'pos.contact.update']);
   Route::get('customer/{code}/show',['uses' => 'app\pos\contact\contactController@show','as' => 'pos.contact.show']);
   Route::get('customer/{code}/delete',['uses' => 'app\pos\contact\contactController@delete','as' => 'pos.contact.delete']);

   /* === settings === */
   //notifications
   Route::get('settings/notifications',['uses' => 'app\pos\settings\generalController@notification','as' => 'pos.settings.notification']);
   Route::post('settings/notifications/{code}/update',['uses' => 'app\pos\settings\generalController@notification_update','as' => 'pos.settings.notification.update']);

});


/*
|--------------------------------------------------------------------------
| E-commerce
|--------------------------------------------------------------------------
*/
Route::prefix('ecommerce')->middleware('auth')->group(function () {
   /*========== dashboard ==========*/
   Route::get('/', ['uses' => 'app\ecommerce\dashboard\dashboardController@dashboard','as' => 'ecommerce.dashboard']);

   /* === customer === */
   Route::get('customer',['uses' => 'app\ecommerce\contact\contactController@index','as' => 'ecommerce.customers.index']);
   Route::get('customer/create',['uses' => 'app\ecommerce\contact\contactController@create','as' => 'ecommerce.customers.create']);
   Route::post('post-customer',['uses' => 'app\ecommerce\contact\contactController@store','as' => 'ecommerce.customers.store']);
   Route::get('customer/{code}/edit',['uses' => 'app\ecommerce\contact\contactController@edit','as' => 'ecommerce.customers.edit']);
   Route::post('customer/{code}/update',['uses' => 'app\ecommerce\contact\contactController@update','as' => 'ecommerce.customers.update']);
   Route::get('customer/{code}/show',['uses' => 'app\ecommerce\contact\contactController@show','as' => 'ecommerce.customers.show']);
   Route::get('customer/{code}/delete',['uses' => 'app\ecommerce\contact\contactController@delete','as' => 'ecommerce.customers.delete']);

   /* === supplier === */
   Route::get('supplier',['uses' => 'app\ecommerce\supplier\supplierController@index','as' => 'ecommerce.supplier.index']);
   Route::get('supplier/create',['uses' => 'app\ecommerce\supplier\supplierController@create','as' => 'ecommerce.supplier.create']);
   Route::post('post-supplier',['uses' => 'app\ecommerce\supplier\supplierController@store','as' => 'ecommerce.supplier.store']);
   Route::get('supplier/{code}/edit',['uses' => 'app\ecommerce\supplier\supplierController@edit','as' => 'ecommerce.supplier.edit']);
   Route::post('supplier/{code}/update',['uses' => 'app\ecommerce\supplier\supplierController@update','as' => 'ecommerce.supplier.update']);
   Route::get('supplier/{code}/show',['uses' => 'app\ecommerce\supplier\supplierController@show','as' => 'ecommerce.supplier.show']);
   Route::get('supplier/{code}/delete',['uses' => 'app\ecommerce\supplier\supplierController@delete','as' => 'ecommerce.supplier.delete']);
   Route::get('delete-supplier-person/{code}',['uses' => 'app\ecommerce\supplier\supplierController@delete_contact_person','as' => 'ecommerce.supplier.vendor.person']);
   Route::get('supplier/{code}/trash',['uses' => 'app\ecommerce\supplier\supplierController@trash','as' => 'ecommerce.vendor.trash.update']);
   Route::get('supplier/download/import/sample/',['uses' => 'app\ecommerce\supplier\importController@download_import_sample','as' => 'ecommerce.supplier.download.sample.import']);

   /* === product === */
   Route::get('products',['uses' => 'app\ecommerce\products\productController@index','as' => 'ecommerce.product.index']);
   Route::get('products/create',['uses' => 'app\ecommerce\products\productController@create','as' => 'ecommerce.products.create']);
   Route::post('products/store',['uses' => 'app\ecommerce\products\productController@store','as' => 'ecommerce.products.store']);
   Route::get('products/{code}/edit',['uses' => 'app\ecommerce\products\productController@edit','as' => 'ecommerce.products.edit']);
   Route::post('products/{code}/update',['uses' => 'app\ecommerce\products\productController@update','as' => 'ecommerce.products.update']);
   Route::get('products/{code}/details',['uses' => 'app\ecommerce\products\productController@details','as' => 'ecommerce.products.details']);
   Route::get('products/{code}/destroy',['uses' => 'app\ecommerce\products\productController@destroy','as' => 'ecommerce.products.destroy']);

   //express products
   Route::get('/express/items',['uses' => 'app\ecommerce\products\productController@express_list','as' => 'ecommerce.product.express.list']);
   Route::post('/express/items/create',['uses' => 'app\ecommerce\products\productController@express_store','as' => 'ecommerce.products.express.create']);

   //import product
   Route::get('products/import',['uses' => 'app\ecommerce\products\importController@index','as' => 'ecommerce.products.import']);
   Route::post('products/post/import',['uses' => 'app\ecommerce\products\importController@import','as' => 'ecommerce.products.post.import']);

   //export products
   Route::get('products/export/{type}',['uses' => 'app\ecommerce\products\importController@export','as' => 'ecommerce.products.export']);

   //download csv sample for products
   Route::get('products/download/import/sample',['uses' => 'app\ecommerce\products\importController@download_import_sample','as' => 'ecommerce.products.sample.download']);

   /* === product description === */
   Route::get('products/{code}/description',['uses' => 'app\ecommerce\products\productController@description','as' => 'ecommerce.products.description']);
   Route::post('products/{code}/description/update',['uses' => 'app\ecommerce\products\productController@description_update','as' => 'ecommerce.products.description.update']);

   /* === product price === */
   Route::get('products/price/{code}/edit',['uses' => 'app\ecommerce\products\productController@price','as' => 'ecommerce.products.price']);
   Route::post('products/price/{code}/update',['uses' => 'app\ecommerce\products\productController@price_update','as' => 'ecommerce.products.price.update']);

   /* === product variants === */
   Route::get('products/{code}/variants',['uses' => 'app\ecommerce\products\variantsController@index','as' => 'ecommerce.products.variants.index']);
   Route::post('products/{code}/variants/store',['uses' => 'app\ecommerce\products\variantsController@store','as' => 'ecommerce.products.variants.store']);
   Route::get('products/{code}/variants/{variantID}/edit',['uses' => 'app\ecommerce\products\variantsController@edit','as' => 'ecommerce.products.variants.edit']);
   Route::post('products/variants/{code}/update',['uses' => 'app\ecommerce\products\variantsController@update','as' => 'ecommerce.products.variants.update']);

   /* === product inventory === */
   Route::get('products/inventory/{code}/edit',['uses' => 'app\ecommerce\products\inventoryController@inventory','as' => 'ecommerce.products.inventory']);
   Route::post('products/{code}/inventory/{productID}/update',['uses' => 'app\ecommerce\products\inventoryController@inventory_update','as' => 'ecommerce.products.inventory.update']);
   Route::post('products/inventory/settings/{productID}/update',['uses' => 'app\ecommerce\products\inventoryController@inventory_settings','as' => 'ecommerce.inventory.settings.update']);
   Route::post('products/inventory/outlet/link',['uses' => 'app\ecommerce\products\inventoryController@inventory_outlet_link','as' => 'ecommerce.inventory.outlet.link']);
   Route::get('products/{productID}/inventory/outle/{code}/link/delete',['uses' => 'app\ecommerce\products\inventoryController@delete_inventory','as' => 'ecommerce.inventory.outlet.link.delete']);

   /* === product images === */
   Route::get('products/images/{code}/edit',['uses' => 'app\ecommerce\products\imagesController@edit','as' => 'ecommerce.product.images']);
   Route::post('products/images/{code}/update',['uses' => 'app\ecommerce\products\imagesController@update','as' => 'ecommerce.product.images.update']);
   Route::post('products/images/store',['uses' => 'app\ecommerce\products\imagesController@store','as' => 'ecommerce.product.images.store']);
   Route::post('products/images/{code}/destroy',['uses' => 'app\ecommerce\products\imagesController@destroy','as' => 'ecommerce.product.images.destroy']);

   /* === product settings === */
   Route::get('products/{code}/settings',['uses' => 'app\ecommerce\products\settingsController@edit','as' => 'ecommerce.product.settings.edit']);
   Route::get('products/{code}/settings/update',['uses' => 'app\ecommerce\products\settingsController@update','as' => 'ecommerce.product.settings.update']);

   /* === stock control === */
   Route::get('stock/control/',['uses' => 'app\ecommerce\products\stockcontrolController@index','as' => 'ecommerce.product.stock.control']);
   Route::get('order/stock',['uses' => 'app\ecommerce\products\stockcontrolController@order','as' => 'ecommerce.product.stock.order']);
   Route::get('order/stock/{code}/show',['uses' => 'app\ecommerce\products\stockcontrolController@show','as' => 'ecommerce.product.stock.order.show']);
   Route::post('post/order/stock',['uses' => 'app\ecommerce\products\stockcontrolController@store','as' => 'ecommerce.product.stock.order.post']);
   Route::post('lpo/ajax/price','app\ecommerce\products\stockcontrolController@productPrice')->name('ecommerce.ajax.product.stock.price');
   Route::get('order/stock/{code}/edit',['uses' => 'app\ecommerce\products\stockcontrolController@edit','as' => 'ecommerce.product.stock.order.edit']);
   Route::post('order/stock/{code}/update',['uses' => 'app\ecommerce\products\stockcontrolController@update','as' => 'ecommerce.product.stock.order.update']);
   Route::get('order/stock/{code}/pdf',['uses' => 'app\ecommerce\products\stockcontrolController@pdf','as' => 'ecommerce.product.stock.order.pdf']);
   Route::get('order/stock/{code}/print',['uses' => 'app\ecommerce\products\stockcontrolController@print','as' => 'ecommerce.product.stock.order.print']);
   Route::get('order/stock/{code}/delivered',['uses' => 'app\ecommerce\products\stockcontrolController@delivered','as' => 'ecommerce.stock.delivered']);

   //send order
   Route::get('stock/{code}/mail',['uses' => 'app\ecommerce\products\stockcontrolController@mail','as' => 'ecommerce.stock.mail']);
   Route::post('stock/mail/send',['uses' => 'app\ecommerce\products\stockcontrolController@send','as' => 'ecommerce.stock.mail.send']);
   Route::post('stock/attach/files',['uses' => 'app\ecommerce\products\stockcontrolController@attachment_files','as' => 'ecommerce.stock.attach']);

   /* === e-commerce orders=== */
   Route::get('ecommerce/order',['uses' => 'app\ecommerce\products\ecommerceControlController@orders','as' => 'ecommerce.ecommerce.orders']);
   Route::get('ecommerce/order/{code}/view',['uses' => 'app\ecommerce\products\ecommerceControlController@show','as' => 'ecommerce.ecommerce.orders.view']);

   /* === product category === */
   Route::get('products/category',['uses' => 'app\ecommerce\products\categoryController@index','as' => 'ecommerce.product.category']);
   Route::post('products/category/store',['uses' => 'app\ecommerce\products\categoryController@store','as' => 'ecommerce.product.category.store']);
   Route::get('products/category/{code}/edit',['uses' => 'app\ecommerce\products\categoryController@edit','as' => 'ecommerce.product.category.edit']);
   Route::post('product.category/{code}/update',['uses' => 'app\ecommerce\products\categoryController@update','as' => 'ecommerce.product.category.update']);
   Route::get('products/category/{code}/destroy',['uses' => 'app\ecommerce\products\categoryController@destroy','as' => 'ecommerce.product.category.destroy']);

   /* === product brands === */
   Route::get('products/brand',['uses' => 'app\ecommerce\products\brandController@index','as' => 'ecommerce.product.brand']);
   Route::post('products/brand/store',['uses' => 'app\ecommerce\products\brandController@store','as' => 'ecommerce.product.brand.store']);
   Route::get('products/brand/{code}/edit',['uses' => 'app\ecommerce\products\brandController@edit','as' => 'ecommerce.product.brand.edit']);
   Route::post('product.brand/{code}/update',['uses' => 'app\ecommerce\products\brandController@update','as' => 'ecommerce.product.brand.update']);
   Route::get('products/brand/{code}/destroy',['uses' => 'app\ecommerce\products\brandController@destroy','as' => 'ecommerce.product.brand.destroy']);

   /* === product tags === */
   Route::get('products/tags',['uses' => 'app\ecommerce\products\tagsController@index','as' => 'ecommerce.product.tags']);
   Route::post('products/tags/store',['uses' => 'app\ecommerce\products\tagsController@store','as' => 'ecommerce.product.tags.store']);
   Route::get('products/tags/{code}/edit',['uses' => 'app\ecommerce\products\tagsController@edit','as' => 'ecommerce.product.tags.edit']);
   Route::post('product.tags/{code}/update',['uses' => 'app\ecommerce\products\tagsController@update','as' => 'ecommerce.product.tags.update']);
   Route::get('products/tags/{code}/destroy',['uses' => 'app\ecommerce\products\tagsController@destroy','as' => 'ecommerce.product.tags.destroy']);

   /* === product attributes === */
   Route::get('products/attributes',['uses' => 'app\ecommerce\products\attributeController@index','as' => 'ecommerce.product.attributes']);
   Route::post('products/attributes/store',['uses' => 'app\ecommerce\products\attributeController@store','as' => 'ecommerce.product.attributes.store']);
   Route::get('products/attributes/{code}/edit',['uses' => 'app\ecommerce\products\attributeController@edit','as' => 'ecommerce.product.attributes.edit']);
   Route::post('products/attributes/{code}/update',['uses' => 'app\ecommerce\products\attributeController@update','as' => 'ecommerce.product.attributes.update']);
   Route::get('products/attributes/{code}/delete',['middleware' => ['permission:delete-productattributes'],'uses' => 'app\ecommerce\products\attributeController@delete','as' => 'ecommerce.product.attributes.delete']);

   /* === attribute values === */
   Route::get('products/attributes/{code}/values',['middleware' => ['permission:create-productattributevalues'],'uses' => 'app\ecommerce\products\attributeValueController@create','as' => 'ecommerce.product.attributes.value.create']);
   Route::post('products/attributes/values/store',['middleware' => ['permission:create-productattributevalues'],'uses' => 'app\ecommerce\products\attributeValueController@store','as' => 'ecommerce.product.attributes.value.store']);
   Route::get('products/attributes/values/{code}/edit',['middleware' => ['permission:update-productattributevalues'],'uses' => 'app\ecommerce\products\attributeValueController@edit','as' => 'ecommerce.product.attributes.value.edit']);
   Route::post('products/attributes/values/{code}/update',['middleware' => ['permission:update-productattributevalues'],'uses' => 'app\ecommerce\products\attributeValueController@update','as' => 'ecommerce.product.attributes.value.update']);
    Route::get('products/attributes/values/{code}/delete',['middleware' => ['permission:delete-productattributevalues'],'uses' => 'app\ecommerce\products\attributeValueController@delete','as' => 'ecommerce.product.attributes.value.delete']);

   /* ================= orders ================= */
   Route::get('orders',['uses' => 'app\ecommerce\products\ordersController@index','as' => 'ecommerce.orders.index']);
   Route::get('orders/{code}/show',['uses' => 'app\ecommerce\products\ordersController@show','as' => 'ecommerce.orders.show']);
   Route::get('orders/{code}/delete',['uses' => 'app\ecommerce\products\ordersController@delete_invoice','as' => 'ecommerce.orders.delete']);

   Route::get('orders/{code}/pdf',['uses' => 'app\ecommerce\products\ordersController@pdf','as' => 'ecommerce.orders.pdf']);
   Route::get('orders/{code}/print',['uses' => 'app\ecommerce\products\ordersController@print','as' => 'ecommerce.orders.print']);

   Route::get('orders/file/{status}/{code}',['uses' => 'app\ecommerce\products\ordersController@update_file_status','as' => 'ecommerce.orders.attachment.status']);

   Route::post('orders/payment',['uses' => 'app\ecommerce\products\ordersController@payment','as' => 'ecommerce.orders.payment']);

   /* ================= website settings ================= */
   Route::get('settings/website/details',['uses' => 'app\ecommerce\settings\websiteController@details','as' => 'ecommerce.settings.website.details']);
   Route::post('settings/website/details/save',['uses' => 'app\ecommerce\settings\websiteController@save_details','as' => 'ecommerce.settings.website.details.save']);

   Route::get('settings/website/contacts',['uses' => 'app\ecommerce\settings\websiteController@contacts','as' => 'ecommerce.settings.website.contacts']);
   Route::post('settings/website/contacts/save',['uses' => 'app\ecommerce\settings\websiteController@save_contacts','as' => 'ecommerce.settings.website.contacts.save']);

   Route::get('settings/website/policies',['uses' => 'app\ecommerce\settings\websiteController@policies','as' => 'ecommerce.settings.website.policies']);
   Route::post('settings/website/policies/save',['uses' => 'app\ecommerce\settings\websiteController@save_policies','as' => 'ecommerce.settings.website.policies.save']);

   Route::get('settings/website/analytics',['uses' => 'app\ecommerce\settings\websiteController@analytics','as' => 'ecommerce.settings.website.analytics']);
   Route::post('settings/website/analytics/save',['uses' => 'app\ecommerce\settings\websiteController@save_analytics','as' => 'ecommerce.settings.website.analytics.save']);
});

/*
|--------------------------------------------------------------------------
| sales flow
|--------------------------------------------------------------------------
|
| Manage retail distribution
*/
Route::prefix('salesflow')->middleware('auth')->group(function () {
   /*========== dashboard ==========*/
   Route::get('/', ['uses' => 'app\salesflow\salesflowController@dashboard','as' => 'salesflow.dashboard']);
   Route::get('dashboard/users-summary', 'app\sokoflowController@user_summary')->name('app.dashboard.user.summary');

   /* === customer === */
   Route::get('customer',['uses' => 'app\salesflow\customer\customerController@index','as' => 'salesflow.customer.index']);
   Route::get('customer/create',['uses' => 'app\salesflow\customer\customerController@create','as' => 'salesflow.customer.create']);
   Route::post('post-customer',['uses' => 'app\salesflow\customer\customerController@store','as' => 'salesflow.customer.store']);
   Route::get('customer/{code}/edit',['uses' => 'app\salesflow\customer\customerController@edit','as' => 'salesflow.customer.edit']);
   Route::post('customer/{code}/update',['uses' => 'app\salesflow\customer\customerController@update','as' => 'salesflow.customer.update']);
   Route::get('customer/{code}/show',['uses' => 'app\salesflow\customer\customerController@show','as' => 'salesflow.customer.show']);
   Route::get('customer/{code}/delete',['uses' => 'app\salesflow\customer\customerController@delete','as' => 'salesflow.customer.delete']);

   //import customer
   Route::get('customer/import',['uses' => 'app\salesflow\customer\importController@import','as' => 'salesflow.customer.import']);
   Route::post('customer/import/store',['uses' => 'app\salesflow\customer\importController@import_contact','as' => 'salesflow.customer.import.store']);
   Route::get('customer/download/import/sample/',['uses' => 'app\salesflow\customer\importController@download_import_sample','as' => 'salesflow.customer.download.sample.import']);

   //export
   Route::get('customer/export/{formart}',['uses' => 'app\salesflow\customer\importController@export','as' => 'salesflow.customer.export']);

   //customer category
   Route::get('customer/category',['uses' => 'app\salesflow\customer\groupsController@index','as' => 'salesflow.customer.category.index']);
   Route::post('customer/category/store',['uses' => 'app\salesflow\customer\groupsController@store','as' => 'salesflow.customer.category.store']);
   Route::get('customer/category/{code}/edit',['uses' => 'app\salesflow\customer\groupsController@edit','as' => 'salesflow.customer.groups.edit']);
   Route::post('customer/category/{code}/update',['uses' => 'app\salesflow\customer\groupsController@update','as' => 'salesflow.customer.groups.update']);
   Route::get('customer/category/{code}/delete',['uses' => 'app\salesflow\customer\groupsController@delete','as' => 'salesflow.customer.groups.delete']);

   /* === customer checkin === */
   Route::get('customer/checkins',['uses' => 'app\salesflow\customer\checkinController@index','as' => 'salesflow.customer.checkin.index']);

   /* === supplier === */
   Route::get('supplier',['uses' => 'app\supplier\supplierController@index','as' => 'salesflow.supplier.index']);
   Route::get('supplier/create',['uses' => 'app\supplier\supplierController@create','as' => 'salesflow.supplier.create']);
   Route::post('post-supplier',['uses' => 'app\supplier\supplierController@store','as' => 'salesflow.supplier.store']);
   Route::get('supplier/{code}/edit',['uses' => 'app\supplier\supplierController@edit','as' => 'salesflow.supplier.edit']);
   Route::post('supplier/{code}/update',['uses' => 'app\supplier\supplierController@update','as' => 'salesflow.supplier.update']);
   Route::get('supplier/{code}/show',['uses' => 'app\supplier\supplierController@show','as' => 'salesflow.supplier.show']);
   Route::get('supplier/{code}/delete',['uses' => 'app\supplier\supplierController@delete','as' => 'salesflow.supplier.delete']);
   Route::get('delete-supplier-person/{code}',['uses' => 'app\supplier\supplierController@delete_contact_person','as' => 'salesflow.supplier.vendor.person']);
   Route::get('supplier/{code}/trash',['uses' => 'app\supplier\supplierController@trash','as' => 'salesflow.vendor.trash.update']);
   Route::get('supplier/download/import/sample/',['uses' => 'app\supplier\ImportController@download_import_sample','as' => 'salesflow.supplier.download.sample.import']);


   //supplier category
   Route::get('supplier/category',['uses' => 'app\supplier\groupsController@index','as' => 'salesflow.supplier.category.index']);
   Route::post('supplier/category/store',['uses' => 'app\supplier\groupsController@store','as' => 'salesflow.supplier.category.store']);
   Route::get('supplier/category/{code}/edit',['uses' => 'app\supplier\groupsController@edit','as' => 'salesflow.supplier.category.edit']);
   Route::post('supplier/category/{code}/update',['uses' => 'app\supplier\groupsController@update','as' => 'salesflow.supplier.category.update']);
   Route::get('supplier/category/{code}/delete',['uses' => 'app\supplier\groupsController@delete','as' => 'salesflow.supplier.category.delete']);

   //import
   Route::get('supplier/import',['uses' => 'app\supplier\ImportController@index','as' => 'salesflow.supplier.import.index']);
   Route::post('supplier/post/import',['uses' => 'app\supplier\ImportController@import','as' => 'salesflow.supplier.import']);

   //export
   Route::get('supplier/export/{type}',['uses' => 'app\supplier\ImportController@export','as' => 'salesflow.supplier.export']);

   /* === product === */
   Route::get('products',['uses' => 'app\salesflow\products\productController@index','as' => 'salesflow.product.index']);
   Route::get('products/create',['uses' => 'app\salesflow\products\productController@create','as' => 'salesflow.products.create']);
   Route::post('products/store',['uses' => 'app\salesflow\products\productController@store','as' => 'salesflow.products.store']);
   Route::get('products/{code}/edit',['uses' => 'app\salesflow\products\productController@edit','as' => 'salesflow.products.edit']);
   Route::post('products/{code}/update',['uses' => 'app\salesflow\products\productController@update','as' => 'salesflow.products.update']);
   Route::get('products/{code}/details',['uses' => 'app\salesflow\products\productController@details','as' => 'salesflow.products.details']);
   Route::get('products/{code}/destroy',['middleware' => ['permission:delete-products'], 'uses' => 'app\salesflow\products\productController@destroy','as' => 'salesflow.products.destroy']);

   //express products
   Route::get('/express/items',['uses' => 'app\salesflow\products\productController@express_list','as' => 'salesflow.product.express.list']);
   Route::post('/express/items/create',['uses' => 'app\salesflow\products\productController@express_store','as' => 'salesflow.products.express.create']);

   //import product
   Route::get('products/import',['uses' => 'app\salesflow\products\ImportController@index','as' => 'salesflow.products.import']);
   Route::post('products/post/import',['uses' => 'app\salesflow\products\ImportController@import','as' => 'salesflow.products.post.import']);

   //export products
   Route::get('products/export/{type}',['uses' => 'app\salesflow\products\ImportController@export','as' => 'salesflow.products.export']);

   //download csv sample for products
   Route::get('products/download/import/sample',['uses' => 'app\salesflow\products\ImportController@download_import_sample','as' => 'salesflow.products.sample.download']);

   /* === product description === */
   Route::get('products/{code}/description',['uses' => 'app\salesflow\products\productController@description','as' => 'description']);
   Route::post('products/{code}/description/update',['uses' => 'app\salesflow\products\productController@description_update','as' => 'description.update']);

   /* === product price === */
   Route::get('product/price/{code}/edit',['uses' => 'app\salesflow\products\productController@price','as' => 'salesflow.product.price']);
   Route::post('price/{code}/update',['uses' => 'app\salesflow\products\productController@price_update','as' => 'salesflow.product.price.update']);

   /* === product inventory === */
   Route::get('products/inventory/{code}/edit',['uses' => 'app\salesflow\products\inventoryController@inventory','as' => 'salesflow.products.inventory']);
   Route::post('products/{code}/inventory/{productCode}/update',['uses' => 'app\salesflow\products\inventoryController@inventory_update','as' => 'salesflow.products.inventory.update']);
   Route::post('products/inventory/settings/{productCode}/update',['uses' => 'app\salesflow\products\inventoryController@inventory_settings','as' => 'salesflow.inventory.settings.update']);
   Route::post('products/inventory/outlet/link',['uses' => 'app\salesflow\products\inventoryController@inventory_outlet_link','as' => 'salesflow.products.inventory.outlet.link']);
   Route::get('products/{productCode}/inventory/outle/{code}/link/delete',['uses' => 'app\salesflow\products\inventoryController@delete_inventroy','as' => 'salesflow.products.inventory.outlet.link.delete']);

   /* === product images === */
   Route::get('products/images/{code}/edit',['uses' => 'app\salesflow\products\imagesController@edit','as' => 'salesflow.product.images']);
   Route::post('products/images/{code}/update',['uses' => 'app\salesflow\products\imagesController@update','as' => 'salesflow.product.images.update']);
   Route::post('products/images/store',['uses' => 'app\salesflow\products\imagesController@store','as' => 'salesflow.product.images.store']);
   Route::post('products/images/{code}/destroy',['uses' => 'app\salesflow\products\imagesController@destroy','as' => 'salesflow.product.images.destroy']);

   /* === stock control === */
   Route::get('stock/control/',['uses' => 'app\salesflow\products\stockcontrolController@index','as' => 'salesflow.product.stock.control']);
   Route::get('order/stock',['uses' => 'app\salesflow\products\stockcontrolController@order','as' => 'salesflow.product.stock.order']);
   Route::get('order/stock/{code}/show',['uses' => 'app\salesflow\products\stockcontrolController@show','as' => 'salesflow.product.stock.order.show']);
   Route::post('post/order/stock',['middleware' => ['permission:create-stockcontrol'],'uses' => 'app\salesflow\products\stockcontrolController@store','as' => 'salesflow.product.stock.order.post']);
   Route::post('lpo/ajax/price','app\salesflow\products\stockcontrolController@productPrice')->name('ajax.product.stock.price');
   Route::get('order/stock/{code}/edit',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\salesflow\products\stockcontrolController@edit','as' => 'salesflow.product.stock.order.edit']);
   Route::post('order/stock/{code}/update',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\salesflow\products\stockcontrolController@update','as' => 'salesflow.product.stock.order.update']);
   Route::get('order/stock/{code}/pdf',['uses' => 'app\salesflow\products\stockcontrolController@pdf','as' => 'salesflow.product.stock.order.pdf']);
   Route::get('order/stock/{code}/print',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\salesflow\products\stockcontrolController@print','as' => 'salesflow.product.stock.order.print']);
   Route::get('order/stock/{code}/delivered',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\salesflow\products\stockcontrolController@delivered','as' => 'salesflow.stock.delivered']);

   //send order
   Route::get('stock/{code}/mail',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\products\stockcontrolController@mail','as' => 'salesflow.stock.mail']);
   Route::post('stock/mail/send',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\products\stockcontrolController@send','as' => 'salesflow.stock.mail.send']);
   Route::post('stock/attach/files',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\products\stockcontrolController@attachment_files','as' => 'salesflow.stock.attach']);

   /* === product category === */
   Route::get('products/category',['uses' => 'app\products\categoryController@index','as' => 'salesflow.product.category']);
   Route::post('products/category/store',['uses' => 'app\products\categoryController@store','as' => 'salesflow.product.category.store']);
   Route::get('products/category/{code}/edit',['uses' => 'app\products\categoryController@edit','as' => 'salesflow.product.category.edit']);
   Route::post('product.category/{code}/update',['uses' => 'app\products\categoryController@update','as' => 'salesflow.product.category.update']);
   Route::get('products/category/{code}/destroy',['uses' => 'app\products\categoryController@destroy','as' => 'salesflow.product.category.destroy']);

   /* === product brands === */
   Route::get('products/brand',['uses' => 'app\products\brandController@index','as' => 'salesflow.product.brand']);
   Route::post('products/brand/store',['uses' => 'app\products\brandController@store','as' => 'salesflow.product.brand.store']);
   Route::get('products/brand/{code}/edit',['uses' => 'app\products\brandController@edit','as' => 'salesflow.product.brand.edit']);
   Route::post('product.brand/{code}/update',['uses' => 'app\products\brandController@update','as' => 'salesflow.product.brand.update']);
   Route::get('products/brand/{code}/destroy',['uses' => 'app\products\brandController@destroy','as' => 'salesflow.product.brand.destroy']);

   /* === users === */
   Route::get('users',['uses' => 'app\usersController@index','as' => 'salesflow.users.index']);
   Route::get('user/create',['uses' => 'app\usersController@create','as' => 'salesflow.user.create']);
   Route::post('user/store',['uses' => 'app\usersController@store','as' => 'salesflow.user.store']);
   Route::get('user/{code}/edit',['uses' => 'app\usersController@edit','as' => 'salesflow.user.edit']);
   Route::post('user/{code}/update',['uses' => 'app\usersController@update','as' => 'salesflow.user.update']);
   Route::get('user{code}/destroy',['uses' => 'app\usersController@destroy','as' => 'salesflow.user.destroy']);

   /* === Route Scheduling === */
   Route::get('routes',['uses' => 'app\routesController@index','as' => 'salesflow.routes.index']);
   Route::get('routes/create',['uses' => 'app\routesController@create','as' => 'salesflow.routes.create']);
   Route::post('routes/store',['uses' => 'app\routesController@store','as' => 'salesflow.routes.store']);
   Route::get('routes/{code}/update',['uses' => 'app\routesController@update','as' => 'salesflow.routes.update']);
   Route::get('routes/{code}/view',['uses' => 'app\routesController@view','as' => 'salesflow.routes.view']);

   /* === Orders === */
   Route::get('orders',['uses' => 'app\ordersController@index','as' => 'salesflow.orders.index']);
   Route::get('orders/{code}/details',['uses' => 'app\ordersController@details','as' => 'salesflow.orders.details']);
   Route::get('orders/{code}/delivery/allocation',['uses' => 'app\ordersController@allocation','as' => 'salesflow.orders.delivery.allocation']);
   Route::post('orders/allocate',['uses' => 'app\ordersController@delivery','as' => 'salesflow.order.create.delivery']);

   /* === delivery === */
   Route::get('delivery',['uses' => 'app\deliveryController@index','as' => 'salesflow.delivery.index']);


   /* === Warehousing === */
   Route::get('warehousing',['uses' => 'app\warehousingController@index','as' => 'salesflow.warehousing.index']);
   Route::get('warehousing/create',['uses' => 'app\warehousingController@create','as' => 'salesflow.warehousing.create']);
   Route::post('warehousing/store',['uses' => 'app\warehousingController@store','as' => 'salesflow.warehousing.store']);
   Route::get('warehousing/{code}/edit',['uses' => 'app\warehousingController@edit','as' => 'salesflow.warehousing.edit']);
   Route::post('warehousing/{code}/update',['uses' => 'app\warehousingController@update','as' => 'salesflow.warehousing.update']);

   /* ===  inventory === */

   //stock allocation
   Route::get('inventory/allocated',['uses' => 'app\inventoryController@allocated','as' => 'salesflow.inventory.allocated']);
   Route::post('inventory/allocate/user',['uses' => 'app\inventoryController@allocate_user','as' => 'salesflow.inventory.allocate.user']);
   Route::get('inventory/allocate/{code}/items',['uses' => 'app\inventoryController@allocate_items','as' => 'salesflow.inventory.allocate.items']);


   /* === settings === */
   //account
   Route::get('settings/account',['uses' => 'app\settingsController@account','as' => 'salesflow.settings.account']);
   Route::post('settings/account/{code}/update',['uses' => 'app\settingsController@update_account','as' => 'salesflow.settings.account.update']);

   //activity log
   Route::get('settings/activity-log',['uses' => 'app\settingsController@activity_log','as' => 'salesflow.settings.activity.log']);

   //Territories
   Route::get('territories',['uses' => 'app\territoriesController@index','as' => 'salesflow.territories.index']);

   /* ===  survey === */
   /* === category === */
   Route::get('category/list','app\survey\categoryController@index')->name('salesflow.survey.category.index');
   Route::get('category/create','app\survey\categoryController@create')->name('salesflow.survey.category.create');
   Route::post('category/store','app\survey\categoryController@store')->name('salesflow.survey.category.store');
   Route::get('category/{code}/edit','app\survey\categoryController@edit')->name('salesflow.survey.category.edit');
   Route::post('category/{code}/update','app\survey\categoryController@update')->name('salesflow.survey.category.update');
   Route::get('category/{code}/delete','app\survey\categoryController@delete')->name('salesflow.survey.category.delete');

   /* === survey === */
   Route::get('survey/list','app\survey\surveyController@index')->name('salesflow.survey.index');
   Route::get('survey/create','app\survey\surveyController@create')->name('salesflow.survey.create');
   Route::post('survey/store','app\survey\surveyController@store')->name('salesflow.survey.store');
   Route::get('survey/{code}/show','app\survey\surveyController@show')->name('salesflow.survey.show');
   Route::get('survey/{code}/edit','app\survey\surveyController@edit')->name('salesflow.survey.edit');
   Route::post('survey/{code}/update','app\survey\surveyController@update')->name('salesflow.survey.update');
   Route::get('survey/{code}/delete','app\survey\surveyController@delete')->name('salesflow.survey.delete');

   /* === questions === */
   Route::get('survey/{code}/questions','app\survey\questionsController@index')->name('salesflow.survey.questions.index');
   Route::get('survey/{code}/questions/create','app\survey\questionsController@create')->name('salesflow.survey.questions.create');
   Route::post('survey/{code}/questions/store','app\survey\questionsController@store')->name('salesflow.survey.questions.store');
   Route::get('survey/{code}/questions/{questionID}/edit','app\survey\questionsController@edit')->name('salesflow.survey.questions.edit');
   Route::post('survey/{code}/questions/{questionID}/update','app\survey\questionsController@update')->name('salesflow.survey.questions.update');
   Route::get('survey/{code}/questions/{questionID}/delete','app\survey\questionsController@delete')->name('salesflow.survey.questions.delete');

});

/*
|--------------------------------------------------------------------------
| property wingu
|--------------------------------------------------------------------------
|
| Property wingu
*/
Route::prefix('propertywingu')->middleware('auth')->group(function () {

   /*========== dashboard ==========*/
   Route::get('/dashboard', ['uses' => 'app\propertywingu\propertywinguController@dashboard','as' => 'propertywingu.dashboard']);

   /* ==== Dashboard ==== */
   Route::get('properties',['uses' => 'app\propertywingu\property\propertyController@index', 'as' => 'propertywingu.property.index']);
   Route::get('property/create', ['uses' => 'app\propertywingu\property\propertyController@create','as' => 'propertywingu.property.create']);
   Route::post('property/store', ['uses' => 'app\propertywingu\property\propertyController@store','as' => 'propertywingu.property.store']);
   Route::get('property/{code}/edit', ['uses' => 'app\propertywingu\property\propertyController@edit','as' => 'propertywingu.property.edit']);
   Route::post('property/{code}/update', ['uses' => 'app\propertywingu\property\propertyController@update','as' => 'propertywingu.property.update']);
   Route::get('property/{code}/details', ['uses' => 'app\propertywingu\property\propertyController@show','as' => 'propertywingu.property.show']);
   Route::get('property/{code}/remove/image', ['uses' => 'app\propertywingu\property\propertyController@remove_image','as' => 'propertywingu.property.remove.image']);
   Route::get('property/{code}/information', ['uses' => 'app\propertywingu\property\propertyController@information','as' => 'propertywingu.property.information']);
   Route::post('property/{code}/information/update', ['uses' => 'app\propertywingu\property\propertyController@update_information','as' => 'propertywingu.property.information.update']);
   Route::get('property/{code}/delete', ['uses' => 'app\propertywingu\property\propertyController@delete','as' => 'propertywingu.property.delete']);
   //Route::get('property/{code}/edit', ['uses' => 'app\propertywingu\property\propertyController@edit','as' => 'propertywingu.property.details']);
   Route::get('property/units/{code}/vacant', ['uses' => 'app\propertywingu\property\propertyController@vacant','as' => 'propertywingu.property.vacant']);
   Route::get('property/units/{code}/occupied', ['uses' => 'app\propertywingu\property\propertyController@occupied','as' => 'propertywingu.property.occupied']);
   Route::post('property/document/upload', ['uses' => 'app\propertywingu\property\propertyController@document_upload','as' => 'propertywingu.property.document.upload']);

   //tenants in property
   Route::get('property/{code}/tenants', ['uses' => 'app\propertywingu\property\propertyController@tenants','as' => 'propertywingu.property.tenants']);
   Route::get('property/tenants/{propertyCode}/{tenantID}/show',['uses' => 'app\propertywingu\property\tenants\tenantsController@show','as' => 'propertywingu.property.tenants.show']);
   Route::get('property/{code}/tenant/contactperson', ['uses' => 'app\propertywingu\property\tenants\tenantsController@delete_contact_person','as' => 'tenant.contactperson.delete']);

   //leases
   Route::get('property/{code}/leases',['uses' => 'app\propertywingu\property\leasesController@index','as' => 'propertywingu.property.leases']);
   Route::get('property/{code}/add/leases',['uses' => 'app\propertywingu\property\leasesController@create','as' => 'propertywingu.property.leases.create']);
   Route::post('property/store/lease',['uses' => 'app\propertywingu\property\leasesController@store','as' => 'propertywingu.property.leases.store']);

   //units
   Route::get('property/{code}/units', ['uses' => 'app\propertywingu\property\unitsController@index','as' => 'propertywingu.property.units']);
   Route::get('property/{code}/units/add', ['uses' => 'app\propertywingu\property\unitsController@create','as' => 'propertywingu.property.units.create']);
   Route::post('property/units/store', ['uses' => 'app\propertywingu\property\unitsController@store','as' => 'propertywingu.property.units.store']);
   Route::get('property/{pid}/units/{uid}/edit', ['uses' => 'app\propertywingu\property\unitsController@edit','as' => 'propertywingu.property.units.edit']);
   Route::get('property/units/{uid}/upload_document', ['uses' => 'app\propertywingu\property\unitsController@edit','as' => 'propertywingu.property.units.document']);
   Route::post('property/units/{uid}/update', ['uses' => 'app\propertywingu\property\unitsController@update','as' => 'propertywingu.property.units.update']);
   Route::get('property/{pid}/units/{uid}/delete', ['uses' => 'app\propertywingu\property\unitsController@delete','as' => 'propertywingu.property.units.delete']);

   //bulk units upload
   Route::get('property/{code}/units/bulk', ['uses' => 'app\propertywingu\property\unitsController@bulk','as' => 'propertywingu.property.units.bulk.create']);
   Route::post('property/units/bulk/store', ['uses' => 'app\propertywingu\property\unitsController@store_bulk','as' => 'propertywingu.property.units.bulk.store']);

   //invoices
   Route::get('property/{propertyCode}/invoices',['uses' => 'app\propertywingu\accounting\invoicesController@index','as' => 'propertywingu.property.invoice.index']);
   Route::get('property/{propertyCode}/invoices/create',['uses' => 'app\propertywingu\accounting\invoicesController@create','as' => 'propertywingu.property.invoice.create']);
   Route::post('property/{propertyCode}/invoices/store',['uses' => 'app\propertywingu\accounting\invoicesController@store','as' => 'propertywingu.property.invoice.store']);
   Route::get('property/{propertyCode}/rental/{invoiceID}/edit/invoices', ['uses' => 'app\propertywingu\accounting\invoicesController@edit','as' => 'propertywingu.property.invoice.edit']);
   Route::post('property/{propertyCode}/rental/{invoiceID}/update/invoices', ['uses' => 'app\propertywingu\accounting\invoicesController@update','as' => 'propertywingu.property.invoice.update']);
   Route::get('property/{propertyCode}/invoices/{invoiceID}/details',['uses' => 'app\propertywingu\accounting\invoicesController@show','as' => 'propertywingu.property.invoice.show']);
   Route::get('property/{propertyCode}/invoices/{invoiceID}/delete',['uses' => 'app\propertywingu\accounting\invoicesController@delete','as' => 'propertywingu.property.invoice.delete']);
   Route::get('property/{propertyCode}/invoices/{tenantID}/leases',['uses' => 'app\propertywingu\accounting\invoicesController@get_leases','as' => 'propertywingu.property.invoice.tenant.leases']);
   Route::post('property/{propertyCode}/invoices/{invoiceID}/payments',['uses' => 'app\propertywingu\accounting\invoicesController@payments','as' => 'propertywingu.property.invoice.payment']);

   //bulk invoiceing
   Route::get('property/{propertyCode}/invoices/bulk',['uses' => 'app\propertywingu\accounting\invoicesController@create_bulk','as' => 'propertywingu.property.invoice.create.bulk']);
   Route::post('property/{propertyCode}/invoices/bulk/store',['uses' => 'app\propertywingu\accounting\invoicesController@store_bulk','as' => 'propertywingu.property.invoice.store.bulk']);

   //print invoice
   Route::get('property/{propertyCode}/invoices/{invoiceID}/print',['uses' => 'app\propertywingu\accounting\invoicesController@print','as' => 'propertywingu.property.invoice.print']);

   //invoice payments
   Route::get('property/{propertyCode}/payments',['uses' => 'app\propertywingu\accounting\paymentsController@index','as' => 'propertywingu.property.payments']);
   Route::get('property/{propertyCode}/payments/create',['uses' => 'app\propertywingu\accounting\paymentsController@create','as' => 'propertywingu.property.payments.create']);
   Route::post('/payments/store',['uses' => 'app\propertywingu\accounting\paymentsController@store','as' => 'propertywingu.property.payments.store']);
   Route::get('property/{propertyCode}/payments/{paymentID}/edit',['uses' => 'app\propertywingu\accounting\paymentsController@edit','as' => 'propertywingu.property.payments.edit']);
   Route::post('/{propertyCode}/payments/{paymentID}/update',['uses' => 'app\propertywingu\accounting\paymentsController@update','as' => 'propertywingu.property.payments.update']);
   Route::get('property/{propertyCode}/payments/{paymentID}/show',['uses' => 'app\propertywingu\accounting\paymentsController@show','as' => 'propertywingu.property.payments.show']);
   Route::get('retrive/{propertyCode}/invoice/{tenantID}',['uses' => 'app\propertywingu\accounting\paymentsController@retrive_tenant_invoice']);
   Route::get('{propertyCode}/payments/file/{fileID}/{parentID}/delete',['uses' => 'app\propertywingu\accounting\paymentsController@delete_file','as' => 'propertywingu.property.payments.delete.file']);
   Route::get('{propertyCode}/payments/{parentID}/delete',['uses' => 'app\propertywingu\accounting\paymentsController@destroy','as' => 'propertywingu.property.payments.delete']);

   //utility billing
   Route::get('property/{propertyCode}/utility',['uses' => 'app\propertywingu\accounting\utilityController@index','as' => 'propertywingu.property.utility.billing.index']);
   Route::get('property/{propertyCode}/utility/create',['uses' => 'app\propertywingu\accounting\utilityController@create','as' => 'propertywingu.property.utility.billing.create']);
   Route::post('/{propertyCode}/prepare/utility',['uses' => 'app\propertywingu\accounting\utilityController@prepare_bulk_billing','as' => 'propertywingu.property.prepare.utility.billing']);
   Route::get('property/{propertyCode}/prepare/{utility}/utility/bill/{from}/{to}',['uses' => 'app\propertywingu\accounting\utilityController@record_bulk_reading','as' => 'propertywingu.property.record.bulk.reading']);
   Route::post('/{propertyCode}/utility/store',['uses' => 'app\propertywingu\accounting\utilityController@store','as' => 'propertywingu.property.utility.billing.store']);
   Route::get('property/{propertyCode}/{invoiceID}/edit/utility', ['uses' => 'app\propertywingu\accounting\utilityController@edit','as' => 'propertywingu.property.utility.billing.edit']);

   Route::post('/{propertyCode}/{invoiceID}/calculate/utility/consumption', ['uses' => 'app\propertywingu\accounting\utilityController@calculate_consumption','as' => 'propertywingu.property.calculate.utility.consumption']);
   Route::post('/{propertyCode}/{invoiceID}/update/utility/consumption', ['uses' => 'app\propertywingu\accounting\utilityController@update_utility_billing','as' => 'propertywingu.property.update.utility.consumption']);

   Route::get('property/{propertyCode}/utility/{invoiceID}/details',['uses' => 'app\propertywingu\accounting\utilityController@show','as' => 'propertywingu.property.utility.billing.show']);
   Route::get('property/{propertyCode}/utility/{invoiceID}/delete',['uses' => 'app\propertywingu\accounting\utilityController@delete','as' => 'propertywingu.property.utility.billing.delete']);
   Route::get('property/{propertyCode}/utility/{tenantID}/leases',['uses' => 'app\propertywingu\accounting\utilityController@get_leases','as' => 'propertywingu.property.utility.billing.tenant.leases']);

   //utility payment
   Route::post('property/{propertyCode}/utility/{invoiceID}/payments',['uses' => 'app\propertywingu\accounting\utilityController@pay_utility','as' => 'propertywingu.property.utility.payment']);

   //mail utility
   Route::get('property/{propertyCode}/utility/{invoiceID}/compose/mail',['uses' => 'app\propertywingu\accounting\utilityController@compose_mail','as' => 'propertywingu.property.utility.compose.mail']);
   Route::post('property/{propertyCode}/utility/compose/send',['uses' => 'app\propertywingu\accounting\utilityController@send_mail','as' => 'propertywingu.property.utility.send.mail']);

   //invoice settings
   Route::get('settings/{code}/invoice', ['uses' => 'app\propertywingu\settings\invoiceSettingsController@edit','as' => 'propertywingu.property.invoice.settings']);
   Route::post('settings/{code}/invoice/update', ['uses' => 'app\propertywingu\settings\invoiceSettingsController@update','as' => 'propertywingu.property.invoice.settings.update']);

   //credit note settings
   Route::get('settings/{code}/creditnote', ['uses' => 'app\propertywingu\settings\creditnoteSettingsController@edit','as' => 'propertywingu.property.creditnote.settings']);
   Route::post('settings/{code}/invoice/creditnote', ['uses' => 'app\propertywingu\settings\creditnoteSettingsController@update','as' => 'propertywingu.property.creditnote.settings.update']);

   //billing  process
   Route::post('rental/billing/process', ['uses' => 'app\propertywingu\accounting\rentController@bulk_process','as' => 'propertywingu.property.billing.process']);

   //billing filter
   Route::get('rental/{code}/billing/{datefrom}/{dateto}/{type}/history', ['uses' => 'app\propertywingu\accounting\rentController@history','as' => 'propertywingu.property.billing.history']);
   Route::get('rental/{code}/billing/history', ['uses' => 'app\propertywingu\accounting\rentController@search_history','as' => 'propertywingu.property.billing.history.search']);
   Route::post('rental/billing/search/results', ['uses' => 'app\propertywingu\accounting\rentController@search_results','as' => 'propertywingu.property.billing.history.search.results']);
   Route::post('property/billing/missing/invoice', ['uses' => 'app\propertywingu\accounting\rentController@missing_billings','as' => 'propertywingu.property.billing.missing.invoice']);

   //documents
   Route::get('property/{code}/documents', ['uses' => 'app\propertywingu\documentsController@index','as' => 'propertywingu.property.documents']);

   //images
   Route::get('property/{code}/gallery', ['uses' => 'app\propertywingu\galleryController@index','as' => 'propertywingu.property.gallery']);

   //property payment integration
   Route::get('payment/{code}/integration', ['uses' => 'app\propertywingu\settings\paymentIntegrationController@index','as' => 'propertywingu.property.payment.integration.settings']);
   Route::get('payment/{code}/integration/{integrationID}/delete', ['uses' => 'app\propertywingu\settings\paymentIntegrationController@delete','as' => 'propertywingu.property.payment.integration.settings.delete']);
   Route::post('payment/{code}/integration', ['uses' => 'app\propertywingu\settings\paymentIntegrationController@activation','as' => 'propertywingu.property.payment.integration.settings.activation']);

   //mpesa api
   Route::get('{propertyCode}/integration/{getwayID}/mpesaapi', ['uses' => 'app\propertywingu\integration\payments\mpesaController@api','as' => 'propertywingu.property.mpesaapi.integration']);
   Route::post('{propertyCode}/integration/{code}/mpesaapi/update', ['uses' => 'app\propertywingu\integration\payments\mpesaController@api_update','as' => 'propertywingu.property.mpesaapi.integration.update']);

   //mpesa till
   Route::get('{propertyCode}/integration/{getwayID}/mpesatill/ ', ['uses' => 'app\propertywingu\integration\payments\mpesaController@till','as' => 'propertywingu.property.mpesatill.integration']);
   Route::post('{propertyCode}/integration/{code}/mpesatill/update', ['uses' => 'app\propertywingu\integration\payments\mpesaController@till_update','as' => 'propertywingu.property.mpesatill.integration.update']);

   //mpesa paybill
   Route::get('{propertyCode}/integration/{getwayID}/mpesapaybill/', ['uses' => 'app\propertywingu\integration\payments\mpesaController@paybill','as' => 'propertywingu.property.mpesapaybill.integration']);
   Route::post('{propertyCode}/integration/{code}/mpesapaybill/update', ['uses' => 'app\propertywingu\integration\payments\mpesaController@paybill_update','as' => 'propertywingu.property.mpesapaybill.integration.update']);

   //bank 1
   Route::get('{propertyCode}/integration/{getwayID}/bank1', ['uses' => 'app\propertywingu\integration\payments\bankController@bank','as' => 'propertywingu.property.bank1.integration']);
   Route::post('{propertyCode}/integration/{code}/bank1/update', ['uses' => 'app\propertywingu\integration\payments\bankController@bank1_update','as' => 'propertywingu.property.bank1.integration.update']);

   //bank 2
   Route::get('{propertyCode}/integration/{getwayID}/bank2', ['uses' => 'app\propertywingu\integration\payments\bankController@bank','as' => 'propertywingu.property.bank2.integration']);
   Route::post('{propertyCode}/integration/{code}/bank2/update', ['uses' => 'app\propertywingu\integration\payments\bankController@bank2_update','as' => 'propertywingu.property.bank2.integration.update']);

   //bank 3
   Route::get('{propertyCode}/integration/{getwayID}/bank3', ['uses' => 'app\propertywingu\integration\payments\bankController@bank','as' => 'propertywingu.property.bank3.integration']);
   Route::post('{propertyCode}/integration/{code}/bank3/update', ['uses' => 'app\propertywingu\integration\payments\bankController@bank3_update','as' => 'propertywingu.property.bank3.integration.update']);

   //bank 4
   Route::get('{propertyCode}/integration/{getwayID}/bank4', ['uses' => 'app\propertywingu\integration\payments\bankController@bank','as' => 'propertywingu.property.bank4.integration']);
   Route::post('{propertyCode}/integration/{code}/bank4/update', ['uses' => 'app\propertywingu\integration\payments\bankController@bank4_update','as' => 'propertywingu.property.bank4.integration.update']);

   //bank 5
   Route::get('{propertyCode}/integration/{getwayID}/bank5', ['uses' => 'app\propertywingu\integration\payments\bankController@bank','as' => 'propertywingu.property.bank5.integration']);
   Route::post('{propertyCode}/integration/{code}/bank5/update', ['uses' => 'app\propertywingu\integration\payments\bankController@bank5_update','as' => 'propertywingu.property.bank5.integration.update']);

   //property images
   Route::get('{propertyCode}/images', ['uses' => 'app\propertywingu\imagesController@index','as' => 'propertywingu.property.images']);
   Route::post('{propertyCode}/images/upload', ['uses' => 'app\propertywingu\imagesController@upload_image','as' => 'propertywingu.property.images.upload']);
   Route::get('{propertyCode}/images/{code}/delete', ['uses' => 'app\propertywingu\imagesController@delete','as' => 'propertywingu.property.images.delete']);

   //property documents
   //Route::get('{propertyCode}/documents', ['uses' => 'app\propertywingu\documentsController@index','as' => 'propertywingu.property.documents']);
   Route::post('{propertyCode}/documents/upload', ['uses' => 'app\propertywingu\documentsController@upload_document','as' => 'propertywingu.property.documents.upload']);
   Route::post('{propertyCode}/documents/{documentID}/update', ['uses' => 'app\propertywingu\documentsController@update','as' => 'propertywingu.property.documents.update']);
   Route::get('{propertyCode}/documents/{code}/delete', ['uses' => 'app\propertywingu\documentsController@delete','as' => 'propertywingu.property.documents.delete']);

   //expenses
   Route::get('{propertyCode}/expenses', ['uses' => 'app\propertywingu\accounting\expenseController@index','as' => 'propertywingu.property.expense']);
   Route::get('{propertyCode}/expenses/create', ['uses' => 'app\propertywingu\accounting\expenseController@create','as' => 'propertywingu.property.expense.create']);
   Route::post('{propertyCode}/expenses/store', ['uses' => 'app\propertywingu\accounting\expenseController@store','as' => 'propertywingu.property.expense.store']);
   Route::get('{propertyCode}/expenses/{code}/edit', ['uses' => 'app\propertywingu\accounting\expenseController@edit','as' => 'propertywingu.property.expense.edit']);
   Route::post('{propertyCode}/expenses/{code}/update', ['uses' => 'app\propertywingu\accounting\expenseController@update','as' => 'propertywingu.property.expense.update']);
   Route::get('{propertyCode}/expenses/{parentID}/file/{fileID}/delete', ['uses' => 'app\propertywingu\accounting\expenseController@delete_file','as' => 'propertywingu.property.expense.delete.file']);
   Route::get('{propertyCode}/expenses/{parentID}/delete', ['uses' => 'app\propertywingu\accounting\expenseController@destroy','as' => 'propertywingu.property.expense.delete']);

   //credit note
   Route::get('{propertyCode}/creditnote',['uses' => 'app\propertywingu\accounting\creditnoteController@index','as' => 'propertywingu.property.creditnote.index']);
   Route::get('{propertyCode}/creditnote/create',['uses' => 'app\propertywingu\accounting\creditnoteController@create','as' => 'propertywingu.property.creditnote.create']);
   Route::post('{propertyCode}/creditnote/store',['uses' => 'app\propertywingu\accounting\creditnoteController@store','as' => 'propertywingu.property.creditnote.store']);
   Route::get('{propertyCode}/creditnote/{code}/edit',['uses' => 'app\propertywingu\accounting\creditnoteController@edit','as' => 'propertywingu.property.creditnote.edit']);
   Route::post('{propertyCode}/creditnote/{code}/update',['uses' => 'app\propertywingu\accounting\creditnoteController@update','as' => 'propertywingu.property.creditnote.update']);
   Route::get('{propertyCode}/creditnote/{code}/delete',['uses' => 'app\propertywingu\accounting\creditnoteController@delete','as' => 'propertywingu.property.creditnote.delete']);
   Route::get('{propertyCode}/creditnote/{code}/show',['uses' => 'app\propertywingu\accounting\creditnoteController@show','as' => 'propertywingu.property.creditnote.show']);
   Route::get('{propertyCode}/creditnote/{code}/pdf',['uses' => 'app\propertywingu\accounting\creditnoteController@pdf','as' => 'propertywingu.property.creditnote.pdf']);
   Route::get('{propertyCode}/creditnote/{code}/print',['uses' => 'app\propertywingu\accounting\creditnoteController@print','as' => 'propertywingu.property.creditnote.print']);
   Route::post('creditnote/apply/credit',['uses' => 'app\propertywingu\accounting\creditnoteController@apply_credit','as' => 'propertywingu.property.creditnote.apply.credit']);
   Route::get('{propertyCode}/creditnote/{code}/delete',['uses' => 'app\propertywingu\accounting\creditnoteController@delete_creditnote','as' => 'propertywingu.property.creditnote.delete']);

   //send creditnote
   Route::get('{propertyCode}/creditnote/{code}/mail',['uses' => 'app\propertywingu\accounting\creditnoteController@mail','as' => 'propertywingu.property.creditnote.mail']);
   Route::post('creditnote/mail/send',['uses' => 'app\propertywingu\accounting\creditnoteController@send','as' => 'propertywingu.property.creditnote.mail.send']);

   //report
   Route::get('{propertyCode}/reports',['uses' => 'app\propertywingu\reports\reportsController@dashboard','as' => 'propertywingu.property.reports']);

   //profit and loss
   Route::get('{propertyCode}/reports/profitandloss',['uses' => 'app\propertywingu\reports\profitandlossController@report','as' => 'propertywingu.property.reports.profitandloss']);
   Route::get('{propertyCode}/report/profilandloss/generate/{to}/{from}',['uses' => 'app\propertywingu\reports\profitandlossController@generate','as' => 'propertywingu.property.reports.profitandloss.generate']);

   //Expense Summary
   Route::get('{propertyCode}/reports/expensesummary',['uses' => 'app\propertywingu\reports\expensesummaryController@report','as' => 'propertywingu.property.reports.expensesummary']);
   Route::get('{propertyCode}/report/expensesummary/generate/{to}/{from}',['uses' => 'app\propertywingu\reports\expensesummaryController@generate','as' => 'propertywingu.property.reports.expensesummary.generate']);

   //Income Summary
   Route::get('{propertyCode}/reports/incomesummary',['uses' => 'app\propertywingu\reports\incomesummaryController@report','as' => 'propertywingu.property.reports.incomesummary']);
   Route::get('{propertyCode}/report/incomesummary/generate/{to}/{from}',['uses' => 'app\propertywingu\reports\incomesummaryController@generate','as' => 'propertywingu.property.reports.incomesummary.generate']);



    /* =======================================================================================================================================
    ==                                                    marketing                                                                         ==
    =========================================================================================================================================*/
    //listing
    Route::get('/marketing/listings', ['uses' => 'app\propertywingu\marketing\listingController@index','as' => 'propertywingu.property.lisitng']);
    Route::get('/property/{code}/list', ['uses' => 'app\propertywingu\marketing\listingController@add_to_list','as' => 'list.property']);
    Route::get('/marketing/property/{code}/edit', ['uses' => 'app\propertywingu\marketing\listingController@edit','as' => 'list.property.edit']);
    Route::post('/marketing/property/update', ['uses' => 'app\propertywingu\marketing\listingController@update','as' => 'list.property.update']);
    Route::get('/marketing/property/{code}/details', ['uses' => 'app\propertywingu\marketing\listingController@show','as' => 'list.property.details']);
    Route::get('/marketing/property/{propertyCode}/{listID}/cancel', ['uses' => 'app\propertywingu\marketing\listingController@cancel_listing','as' => 'list.property.cancel']);
    Route::get('/marketing/property/{code}/image/{imageID}/delete', ['uses' => 'app\propertywingu\marketing\listingController@delete_image','as' => 'list.property.delete.image']);
    Route::get('/marketing/property/{code}/image/{imageID}/cover', ['uses' => 'app\propertywingu\marketing\listingController@image_cover','as' => 'list.property.image.cover']);
    Route::get('/marketing/property/{code}/delete', ['uses' => 'app\propertywingu\marketing\listingController@delete','as' => 'list.property.delete']);

    //listing leads
    Route::get('/inquiry', ['uses' => 'app\propertywingu\marketing\inquiryController@index','as' => 'propertywingu.property.inquiry']);

    /* =======================================================================================================================================
    ==                                                    tenants                                                                           ==
    =========================================================================================================================================*/

    Route::get('delete-vendor-person/{code}',['uses' => 'app\propertywingu\property\tenants\tenantsController@delete_vendor_person','as' => 'tenantsperson.delete']);
    Route::get('tenants/{code}/trash',['uses' => 'app\propertywingu\property\tenants\tenantsController@trash','as' => 'tenants.trash.update']);

    //tenant notes
    Route::get('tenants/{propertyCode}/{tenantID}/notes',['uses' => 'app\propertywingu\property\tenants\notesController@index','as' => 'tenants.notes']);
    Route::post('tenants/notes/store',['uses' => 'app\propertywingu\property\tenants\notesController@store','as' => 'tenants.notes.store']);
    Route::post('tenants/notes/{code}/update',['uses' => 'app\propertywingu\property\tenants\notesController@update','as' => 'tenants.notes.update']);
    Route::get('tenants/{code}/notes/delete',['uses' => 'app\propertywingu\property\tenants\notesController@delete','as' => 'tenants.notes.delete']);

    //billing
    Route::get('tenants/{propertyCode}/{tenantID}/invoices',['uses' => 'app\propertywingu\property\tenants\invoicesController@index','as' => 'tenants.invoice.index']);

    //statement
    Route::get('tenants/{code}/statement',['uses' => 'app\propertywingu\property\tenants\tenantsController@show','as' => 'tenants.statement']);

    //units
    Route::get('tenants/{propertyCode}/{tenantID}/units',['uses' => 'app\propertywingu\property\tenants\unitsController@index','as' => 'tenants.units.index']);


    //Tenant Lease
    Route::get('/tenant/{propertyCode}/{tenantID}/lease',['uses' => 'app\propertywingu\property\tenants\leasesController@index','as' => 'propertywingu.property.tenant.lease']);
    Route::get('/tenant/{propertyCode}/{tenantID}/{leaseID}/lease/details',['uses' => 'app\propertywingu\property\tenants\leasesController@show','as' => 'propertywingu.property.tenant.lease.show']);
    Route::get('/tenant/{propertyCode}/{tenantID}/edit/{leaseID}/lease',['uses' => 'app\propertywingu\property\tenants\leasesController@edit','as' => 'propertywingu.property.tenant.lease.edit']);
    Route::post('tenant/update/{leaseID}/lease',['uses' => 'app\propertywingu\property\tenants\leasesController@update','as' => 'propertywingu.property.tenant.lease.update']);
    Route::get('tenant/lease/{leaseID}/delete',['uses' => 'app\propertywingu\property\tenants\leasesController@delete_lease','as' => 'propertywingu.property.tenant.lease.delete']);

    Route::post('tenant/lease/utility/store',['uses' => 'app\propertywingu\property\tenants\leasesController@add_utility','as' => 'propertywingu.property.tenant.lease.add.utility']);
    Route::post('tenant/lease/utility/update',['uses' => 'app\propertywingu\property\tenants\leasesController@update_utility','as' => 'propertywingu.property.tenant.lease.update.utility']);
    Route::get('tenant/lease/{leaseID}/utility/{code}/delete',['uses' => 'app\propertywingu\property\tenants\leasesController@delete_utility','as' => 'propertywingu.property.leases.delete.utility']);
    Route::post('tenant/lease/terminate',['uses' => 'app\propertywingu\property\tenants\leasesController@lease_termination','as' => 'propertywingu.property.lease.terminate']);


    /* === utility === */
    Route::get('utility/{code}/billing',['uses' => 'app\propertywingu\accounting\utilityController@index','as' => 'utility.billing.index']);
    Route::post('utility/billing/hold',['uses' => 'app\propertywingu\accounting\utilityController@hold_utility','as' => 'utility.billing.hold']);
    Route::get('utility/{code}/readings',['uses' => 'app\propertywingu\accounting\utilityController@utility_readings','as' => 'utility.readings']);
    Route::post('utility/bill/readings',['uses' => 'app\propertywingu\accounting\utilityController@bill_utility','as' => 'utility.bill.readings']);
    Route::post('utility/bill/search',['uses' => 'app\propertywingu\accounting\utilityController@utility_search','as' => 'utility.bill.search']);
    Route::get('utility/{propertyCode}/billing/{periodID}/history',['uses' => 'app\propertywingu\accounting\utilityController@history','as' => 'utility.billing.history']);
    Route::post('utility/billing/{code}/update',['uses' => 'app\propertywingu\accounting\utilityController@utility_update','as' => 'utility.billing.update']);

    /* =======================================================================================================================================
    ==                                                    Agents                                                                         ==
    =========================================================================================================================================*/
    Route::get('agents',['uses' => 'app\propertywingu\agentsController@index','as' => 'propertywingu.property.agents']);
    Route::get('agents/create',['uses' => 'app\propertywingu\agentsController@create','as' => 'propertywingu.property.agents.create']);
    Route::post('agents/store',['uses' => 'app\propertywingu\agentsController@store','as' => 'propertywingu.property.agents.store']);
    Route::get('agents/{code}/edit',['uses' => 'app\propertywingu\agentsController@edit','as' => 'propertywingu.property.agents.edit']);
    Route::post('agents/{code}/update',['uses' => 'app\propertywingu\agentsController@update','as' => 'propertywingu.property.agents.update']);
    Route::get('agents/{code}/delete',['uses' => 'app\propertywingu\agentsController@delete','as' => 'propertywingu.property.agents.delete']);


    /* =======================================================================================================================================
    ==                                                    Supplier                                                                         ==
    =========================================================================================================================================*/
    Route::get('supplier',['uses' => 'app\propertywingu\supplierController@index','as' => 'propertywingu.property.supplier']);
    Route::get('supplier/create',['uses' => 'app\propertywingu\supplierController@create','as' => 'propertywingu.property.supplier.create']);
    Route::post('supplier/store',['uses' => 'app\propertywingu\supplierController@store','as' => 'propertywingu.property.supplier.store']);
    Route::get('supplier/{code}/edit',['uses' => 'app\propertywingu\supplierController@edit','as' => 'propertywingu.property.supplier.edit']);
    Route::post('supplier/{code}/update',['uses' => 'app\propertywingu\supplierController@update','as' => 'propertywingu.property.supplier.update']);
    Route::get('supplier/{code}/delete',['uses' => 'app\propertywingu\supplierController@delete','as' => 'propertywingu.property.supplier.delete']);


    /* =======================================================================================================================================
    ==                                                    landlords                                                                         ==
    =========================================================================================================================================*/
    //landlords
    Route::get('landlord',[ 'uses' => 'app\propertywingu\landlords\landlordController@index','as' => 'landlord.index']);
    Route::get('landlord/create',['uses' => 'app\propertywingu\landlords\landlordController@create','as' => 'landlord.create']);
    Route::post('post-landlords',['uses' => 'app\propertywingu\landlords\landlordController@store','as' => 'landlord.store']);
    Route::get('landlord/{code}/edit',['uses' => 'app\propertywingu\landlords\landlordController@edit','as' => 'landlord.edit']);
    Route::post('landlord/{code}/update',['uses' => 'app\propertywingu\landlords\landlordController@update','as' => 'landlord.update']);
    Route::get('landlord/{code}/show',['uses' => 'app\propertywingu\landlords\landlordController@show','as' => 'landlord.show']);
    Route::get('landlord/{code}/delete',['uses' => 'app\propertywingu\landlords\landlordController@delete','as' => 'landlord.delete']);
    Route::get('landlord/{code}/delete-contact-person',['uses' => 'app\propertywingu\landlords\landlordController@delete_contact_person','as' => 'landlordperson.delete']);
    Route::get('landlord/{code}/trash',['uses' => 'app\propertywingu\landlords\landlordController@trash','as' => 'landlord.trash.update']);

    //import
    Route::get('landlord/import',['uses' => 'app\propertywingu\landlords\importController@import','as' => 'landlord.import.index']);
    Route::post('landlord/post/import',['uses' => 'app\propertywingu\landlords\importController@import_contact','as' => 'landlord.import']);
    Route::get('landlord/download/import/sample/',['uses' => 'app\propertywingu\landlords\importController@download_import_sample','as' => 'landlord.download.sample.import']);

    //export
    Route::get('landlord/export',['uses' => 'app\propertywingu\landlords\importController@export','as' => 'landlord.export']);

    /* =======================================================================================================================================
    ==                                                    Tenants                                                                           ==
    =========================================================================================================================================*/
    /* === Tenants === */
    Route::get('tenants',['uses' => 'app\propertywingu\tenants\tenantsController@index','as' => 'tenants.index']);
    Route::get('tenants/create',['uses' => 'app\propertywingu\tenants\tenantsController@create','as' => 'tenants.create']);
    Route::post('tenants/store',['uses' => 'app\propertywingu\tenants\tenantsController@store','as' => 'tenants.store']);
    Route::get('tenants/{code}/edit',['uses' => 'app\propertywingu\tenants\tenantsController@edit','as' => 'tenants.edit']);
    Route::post('tenants/{code}/update',['uses' => 'app\propertywingu\tenants\tenantsController@update','as' => 'tenants.update']);
    Route::get('tenants/{code}/delete',['uses' => 'app\propertywingu\tenants\tenantsController@delete','as' => 'tenants.delete']);

    //import
    Route::get('tenants/import',['uses' => 'app\propertywingu\tenants\importController@index','as' => 'tenants.import.index']);
    Route::post('tenants/post/import',['uses' => 'app\propertywingu\tenants\importController@import','as' => 'tenants.import']);
    Route::get('tenants/download/import/sample/',['uses' => 'app\propertywingu\property\tenants\importController@download_import_sample','as' => 'tenants.download.sample.import']);

    //export
    Route::get('tenants/export',['uses' => 'app\propertywingu\tenants\importController@export','as' => 'tenants.export']);


    /* =======================================================================================================================================
    ==                                                    Maintenance                                                                       ==
    =========================================================================================================================================*/
    /* === Maintenance === */
    Route::get('maintenance',['uses' => 'app\propertywingu\maintenance\maintenanceController@index','as' => 'propertywingu.property.maintenance']);
    Route::get('maintenance/create',['uses' => 'app\propertywingu\maintenance\maintenanceController@create','as' => 'propertywingu.property.maintenance.create']);
    Route::post('maintenance/store',['uses' => 'app\propertywingu\maintenance\maintenanceController@store','as' => 'propertywingu.property.maintenance.store']);
    Route::get('maintenance/{code}/edit',['uses' => 'app\propertywingu\maintenance\maintenanceController@edit','as' => 'propertywingu.property.maintenance.edit']);
    Route::get('maintenance/property/units/{code}',['uses' => 'app\propertywingu\maintenance\maintenanceController@get_units','as' => 'pm.maintenance.get.units']);
    Route::get('maintenance/property/units/tenant/{code}',['uses' => 'app\propertywingu\maintenance\maintenanceController@get_tenant','as' => 'pm.maintenance.get.units.tenant']);
    Route::get('maintenance/get/category/{code}',['uses' => 'app\propertywingu\maintenance\maintenanceController@get_maintenance_category','as' => 'pm.maintenance.get.category']);


    //category
    Route::get('maintenance/category',['uses' => 'app\propertywingu\maintenance\maintenanceCategoryController@index','as' => 'maintenance.category.index']);
    Route::post('maintenance/category/store',['uses' => 'app\propertywingu\maintenance\maintenanceCategoryController@store','as' => 'maintenance.category.store']);
    Route::get('maintenance/category/{code}/edit',['uses' => 'app\propertywingu\maintenance\maintenanceCategoryController@edit','as' => 'maintenance.category.edit']);
    Route::post('maintenance/category/{code}/update',['uses' => 'app\propertywingu\maintenance\maintenanceCategoryController@update','as' => 'maintenance.category.update']);
    Route::get('maintenance/category/{code}/delete',['uses' => 'app\propertywingu\maintenance\maintenanceCategoryController@delete','as' => 'maintenance.category.delete']);


    /* =======================================================================================================================================
    ==                                                    Settings                                                                          ==
    =========================================================================================================================================*/
   /* === taxes === */
    Route::get('taxes',['uses' => 'app\propertywingu\settings\taxesController@index','as' => 'propertywingu.property.taxes']);
    Route::post('taxes/store',['uses' => 'app\propertywingu\settings\taxesController@store','as' => 'propertywingu.property.taxes.store']);
    Route::get('taxes/{code}/edit',['uses' => 'app\propertywingu\settings\taxesController@edit','as' => 'propertywingu.property.taxes.edit']);
    Route::post('taxes/update',['uses' => 'app\propertywingu\settings\taxesController@update','as' => 'propertywingu.property.taxes.update']);
    Route::get('taxes/{code}/delete',['uses' => 'app\propertywingu\settings\taxesController@delete','as' => 'propertywingu.property.taxes.delete']);

    //tax express
    Route::get('/taxes/express',['uses' => 'app\propertywingu\settings\taxesController@express_list','as' => 'propertywingu.property.taxes.express']);
    Route::post('/taxes/express/store',['uses' => 'app\propertywingu\settings\taxesController@store_express','as' => 'propertywingu.property.taxes.express.store']);

    /* === income category === */
    Route::get('income/category/',['uses' => 'app\propertywingu\settings\incomeController@index','as' => 'propertywingu.property.income.category']);
    Route::get('income/category/create',['uses' => 'app\propertywingu\settings\incomeController@create','as' => 'propertywingu.property.income.category.create']);
    Route::post('income/category/store',['uses' => 'app\propertywingu\settings\incomeController@store','as' => 'propertywingu.property.income.category.store']);
    Route::get('income/category/{code}/edit',['uses' => 'app\propertywingu\settings\incomeController@edit','as' => 'propertywingu.property.income.category.edit']);
    Route::post('income/category/update',['uses' => 'app\propertywingu\settings\incomeController@update','as' => 'propertywingu.property.income.category.update']);
    Route::get('income/category/{code}/delete',['uses' => 'app\propertywingu\settings\incomeController@delete','as' => 'propertywingu.property.income.category.delete']);
    Route::post('express/income/category/create',['uses' => 'app\propertywingu\settings\incomeController@express']);
    Route::get('express/income/category/get',['uses' => 'app\propertywingu\settings\incomeController@get_express','as' => 'propertywingu.property.income.express.category']);

    /* === payment methods === */
    Route::get('payment/methods',['uses' => 'app\propertywingu\settings\paymentMethodsController@index','as' => 'propertywingu.property.payment.method']);
    Route::post('payment/methods/store',['uses' => 'app\propertywingu\settings\paymentMethodsController@store','as' => 'propertywingu.property.payment.method.store']);
    Route::post('payment/methods/{code}/update',['uses' => 'app\propertywingu\settings\paymentMethodsController@update','as' => 'propertywingu.property.payment.method.update']);
    Route::get('payment/methods/{code}/delete',['uses' => 'app\propertywingu\settings\paymentMethodsController@delete','as' => 'propertywingu.property.payment.method.delete']);

    //payment method express
    Route::get('express/payment/list',['uses' => 'app\propertywingu\settings\paymentMethodsController@express_list','as' => 'propertywingu.property.payment.mode.express']);
    Route::post('express/payment/modes/store',['uses' => 'app\propertywingu\settings\paymentMethodsController@express_store','as' => 'propertywingu.property.payment.mode.express.store']);

    //expense category
    Route::get('expense/category',['uses' => 'app\propertywingu\settings\expenseCategoryController@index','as' => 'propertywingu.property.expense.category.index']);
    Route::post('expense/category/store',['uses' => 'app\propertywingu\settings\expenseCategoryController@store','as' => 'propertywingu.property.expense.category.store']);
    Route::get('expense-category/{code}/edit',['uses' => 'app\propertywingu\settings\expenseCategoryController@edit','as' => 'propertywingu.property.expense.category.edit']);
    Route::post('expense-category/{code}/update',['uses' => 'app\propertywingu\settings\expenseCategoryController@update','as' => 'propertywingu.property.expense.category.update']);
    Route::get('expense-category/{code}/delete',['uses' => 'app\propertywingu\settings\expenseCategoryController@destroy','as' => 'propertywingu.property.expense.category.destroy']);

    //express category CRUD
    Route::post('/express/expense/category/store',['uses' => 'app\propertywingu\settings\expenseCategoryController@express','as' => 'propertywingu.property.express.expense.category.store']);
    Route::get('/express/expense/category/list',['uses' => 'app\propertywingu\settings\expenseCategoryController@list','as' => 'propertywingu.property.express.expense.category.list']);

    /* === utilities === */
    Route::get('utilities',['uses' => 'app\propertywingu\settings\utilitiesController@index','as' => 'propertywingu.property.utilities']);
    Route::get('utilities/create',['uses' => 'app\propertywingu\settings\utilitiesController@create','as' => 'propertywingu.property.utilities.create']);
    Route::post('utilities/store',['uses' => 'app\propertywingu\settings\utilitiesController@store','as' => 'propertywingu.property.utilities.store']);
    Route::get('utilities/{code}/edit',['uses' => 'app\propertywingu\settings\utilitiesController@edit','as' => 'propertywingu.property.utilities.edit']);
    Route::post('utilities/{code}/update',['uses' => 'app\propertywingu\settings\utilitiesController@update','as' => 'propertywingu.property.utilities.update']);
    Route::get('utilities/{code}/delete',['uses' => 'app\propertywingu\settings\utilitiesController@delete','as' => 'propertywingu.property.utilities.delete']);
});

/*
|--------------------------------------------------------------------------
| Wingu crowd
|--------------------------------------------------------------------------
|
| All-in-One Software to Grow Your Community
*/
Route::prefix('eventmanager')->middleware('auth')->group(function () {
   Route::get('/', ['uses' => 'app\events\eventManagerController@dashboard','as' => 'events.manager.dashboard']);


   /* ==== events ==== */
   Route::get('/events', ['uses' => 'app\events\eventsController@index','as' => 'events']);
   Route::get('/events/create', ['uses' => 'app\events\eventsController@create','as' => 'events.create']);
   Route::post('/events/store', ['uses' => 'app\events\eventsController@store','as' => 'events.store']);
   Route::get('/events/{code}/edit', ['uses' => 'app\events\eventsController@edit','as' => 'events.edit']);
   Route::post('/events/{code}/update', ['uses' => 'app\events\eventsController@update','as' => 'events.update']);
   Route::get('/events/{code}/details', ['uses' => 'app\events\eventsController@show','as' => 'events.show']);

   /* ==== speakers ==== */
   Route::get('/events/{code}/speakers', ['uses' => 'app\events\eventsController@speakers','as' => 'events.speakers']);

   /* ==== sponsors ==== */
   Route::get('/events/{code}/sponsors', ['uses' => 'app\events\sponsorsController@index','as' => 'events.sponsors']);
   Route::get('/events/{code}/sponsors/store', ['uses' => 'app\events\sponsorsController@store','as' => 'events.sponsors.store']);
   Route::get('/events/{code}/sponsors/delete', ['uses' => 'app\events\sponsorsController@delete','as' => 'events.sponsors.delete']);

   /* ==== tickets ==== */
   Route::get('/events/{code}/tickets', ['uses' => 'app\events\eventsController@tickets','as' => 'events.tickets']);
   Route::get('/events/{code}/ticket-sold', ['uses' => 'app\events\eventsController@ticket_sold','as' => 'events.ticket.sold']);

   /* ==== attendance ==== */
   Route::get('/events/{code}/attendance', ['uses' => 'app\events\eventsController@attendance','as' => 'events.attendance']);

   /* ==== Schedules ==== */
   Route::get('/events/{code}/schedules', ['uses' => 'app\events\schedulesController@index','as' => 'events.schedules']);

   //sessions
   Route::get('/events/{code}/schedules/{schedule}/sessions', ['uses' => 'app\events\schedulesController@sessions','as' => 'events.schedule.sessions']);


});


/*
|--------------------------------------------------------------------------
| settings
|--------------------------------------------------------------------------
|
| Manage contents of your website quick and first
*/

// Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
//    Route::get('/', 'AdminController@welcome');
//    Route::get('/manage', ['middleware' => ['permission:manage-admins'], 'uses' =>'AdminController@manageAdmins']);
// });

//Route::get('content', ['middleware' => ['permission:content-list'], 'uses' => 'cms.pages\contentController@index'])->name('content.index');

Route::prefix('settings')->middleware('auth')->group(function () {
   /* ==== Dashboard ==== */
   Route::get('/',['uses' => 'app\settings\business\businessController@index', 'as' => 'settings.index']);

   /* ==== Business Profile ==== */
   Route::get('/business/profile',['uses' => 'app\settings\business\businessController@index','as' => 'settings.business.index']);
   Route::get('/business/profile/edit',['uses' => 'app\settings\business\businessController@index','as' => 'settings.business.edit']);
   Route::post('/business/profile/{code}/update',['uses' => 'app\settings\business\businessController@update','as' => 'settings.business.update']);
   Route::get('/business/profile/{code}/delete/logo',['uses' => 'app\settings\business\businessController@delete_logo','as' => 'settings.business.delete.logo']);

   /* ==== Users ==== */
   Route::get('/users',['uses' => 'app\settings\users\UserController@index','as' => 'settings.users.index']);
   Route::get('/users/create',['uses' => 'app\settings\users\UserController@create','as' => 'settings.users.create']);
   Route::post('/users/store',['uses' => 'app\settings\users\UserController@store','as' => 'settings.users.store']);
   Route::get('/users/{code}/edit',['uses' => 'app\settings\users\UserController@edit', 'as' => 'settings.users.edit']);
   Route::post('/users/{code}/update',['uses' => 'app\settings\users\UserController@update', 'as' => 'settings.users.update']);

   /* ==== Language ==== */
   Route::get('/language',['uses' => 'app\settings\language\languageController@index', 'as' => 'language.index']);
   Route::get('/language/{code}/{section}',['uses' => 'app\settings\Language\LanguageController@show', 'as' => 'language.show']);
   Route::post('/language/translate/section',['uses' => 'app\settings\Language\LanguageController@post_show', 'as' => 'language.translate.section']);
   Route::post('/language/translate',['uses' => 'app\settings\Language\LanguageController@translate','as' => 'language.translate']);
   Route::get('/language/{code}/edit',['uses' => 'app\settings\Language\LanguageController@edit','as' => 'language.edit']);
   Route::post('/language/{code}/update',['uses' => 'app\settings\Language\LanguageController@update','as' => 'language.update']);
   Route::post('settings/defaultLanguage',['uses' => 'app\settings\language\languageController@defaultLanguage','as' => 'language.defaultLanguage']);
   Route::post('language/store',['uses' => 'app\settings\Language\LanguageController@store','as' => 'language.store']);
   Route::get('language/{code}/delete',['uses' => 'app\settings\Language\LanguageController@destroy','as' => 'language.destroy']);

   /* === roles === */
   Route::get('/roles', [ 'uses' =>'app\settings\users\rolesController@index'])->name('settings.roles.index');
   Route::get('/roles/{code}/show',['uses' => 'app\settings\users\rolesController@show', 'as' => 'settings.roles.show']);
   Route::get('/roles/create', ['uses' => 'app\settings\users\rolesController@create', 'as' => 'settings.roles.create']);
   Route::post('/roles/store',['uses' => 'app\settings\users\rolesController@store', 'as' => 'settings.roles.store']);
   Route::get('/roles/{code}/edit',['uses' => 'app\settings\users\rolesController@edit', 'as' => 'settings.roles.edit']);
   Route::post('/roles/{code}/update',['uses' => 'app\settings\users\rolesController@update', 'as' => 'settings.roles.update']);
   Route::get('/roles/{code}/delete',['middleware' => ['permission:delete-roles'],'uses' => 'app\settings\users\rolesController@delete', 'as' => 'settings.roles.delete']);

   /* ==== Applications ==== */
   Route::get('/account/applications',['uses' => 'app\settings\applications\applicationController@index', 'as' => 'settings.applications']);
   Route::get('/account/application/{code}/delete',['uses' => 'app\settings\applications\applicationController@delete', 'as' => 'settings.application.delete']);
   Route::get('/account/application/{applicationID}/billing',['uses' => 'app\settings\applications\applicationController@billing', 'as' => 'settings.applications.billing']);

   /* ==== billing ==== */
   Route::get('/account/billing',['uses' => 'app\settings\billingController@index', 'as' => 'settings.billing']);

   /* ==== integrations ==== */
   //payment
   Route::get('/payment/integrations',['uses' => 'app\settings\integrations\payments\paymentsController@index', 'as' => 'settings.integrations.payments']);
   Route::post('/payment/integrations/store',['uses' => 'app\settings\integrations\payments\paymentsController@store', 'as' => 'settings.integrations.payments.store']);
   Route::get('/payment/integrations{code}/status/{statusID}',['uses' => 'app\settings\integrations\payments\paymentsController@status', 'as' => 'settings.integrations.payments.status']);
   Route::get('/payment/integrations/{code}/delete',['uses' => 'app\settings\integrations\payments\paymentsController@delete', 'as' => 'settings.integrations.payments.delete']);

   //pesapal
   Route::get('payment/integrations/{code}/pesapal',['uses' => 'app\settings\integrations\payments\pesapalController@edit', 'as' => 'settings.integrations.payments.pesapal.edit']);
   Route::post('payment/integrations/{code}/pesapal/update',['uses' => 'app\settings\integrations\payments\pesapalController@update', 'as' => 'settings.integrations.payments.pesapal.update']);

   //paypal
   Route::get('payment/integrations/{code}/paypal',['uses' => 'app\settings\integrations\payments\paypalController@edit', 'as' => 'settings.integrations.payments.paypal.edit']);
   Route::post('payment/integrations/{code}/paypal/update',['uses' => 'app\settings\integrations\payments\paypalController@update', 'as' => 'settings.integrations.payments.paypal.update']);

   //kepler9
   Route::get('payment/integrations/{code}/kepler9',['uses' => 'app\settings\integrations\payments\kepler9Controller@edit', 'as' => 'settings.payments.integrations.kepler9']);
   Route::post('payment/integrations/{code}/kepler9/update',['uses' => 'app\settings\integrations\payments\kepler9Controller@update', 'as' => 'settings.integrations.payments.kepler9.update']);

   //ipay
   Route::get('payment/integrations/{code}/ipay',['uses' => 'app\settings\integrations\payments\ipayController@edit', 'as' => 'settings.payments.integrations.ipay']);
   Route::post('payment/integrations/{code}/ipay/update',['uses' => 'app\settings\integrations\payments\ipayController@update', 'as' => 'settings.payments.integrations.ipay.update']);

   //daraja
   Route::get('payment/integrations/{code}/mpesa',['uses' => 'app\settings\integrations\payments\mpesa\darajaController@edit', 'as' => 'settings.integrations.payments.mpesa.edit']);
   Route::post('payment/integrations/{code}/mpesa/update',['uses' => 'app\settings\integrations\payments\mpesa\darajaController@update', 'as' => 'settings.integrations.payments.mpesa.update']);
   Route::get('daraja/register/url/{businessID}', 'app\settings\integrations\payments\mpesa\darajaController@registerUrls')->name('settings.integrations.daraja.register.urls');

   //mpesa phone number
   Route::get('payment/integrations/{code}/mpesa-phone-number',['uses' => 'app\settings\integrations\payments\mpesa\phonenumberController@phone_number', 'as' => 'settings.payments.integrations.mpesa.phonenumber']);
   Route::post('payment/integrations/{code}/mpesa-phone-number/update',['uses' => 'app\settings\integrations\payments\mpesa\phonenumberController@update_phone_number', 'as' => 'settings.payments.integrations.mpesa.phonenumber.update']);

   //mpesa till number
   Route::get('payment/integrations/{code}/mpesa-till-number',['uses' => 'app\settings\integrations\payments\mpesa\tillnumberController@till_number', 'as' => 'settings.payments.integrations.mpesa.tillnumber']);
   Route::post('payment/integrations/{code}/mpesa-till-number/update',['uses' => 'app\settings\integrations\payments\mpesa\tillnumberController@update_till_number', 'as' => 'settings.payments.integrations.mpesa.tillnumber.update']);

   //mpesa paybill number
   Route::get('payment/integrations/{code}/mpesa-paybill-number',['uses' => 'app\settings\integrations\payments\mpesa\paybillnumberController@paybill_number', 'as' => 'settings.payments.integrations.mpesa.paybillnumber']);
   Route::post('payment/integrations/{code}/mpesa-paybill-number/update',['uses' => 'app\settings\integrations\payments\mpesa\paybillnumberController@update_paybill_number', 'as' => 'settings.payments.integrations.mpesa.paybillnumber.update']);

   /* ==== Telephony integrations ==== */
   Route::get('/integrations/telephony',['uses' => 'app\settings\integrations\telephony\telephonyController@index', 'as' => 'settings.integrations.telephony']);
   Route::post('/integrations/telephony/store',['uses' => 'app\settings\integrations\telephony\telephonyController@store', 'as' => 'settings.integrations.telephony.store']);

   //twilio
   Route::get('/integrations/telephony/{code}/twilio',['uses' => 'app\settings\integrations\telephony\twilioController@edit', 'as' => 'settings.integrations.telephony.twilio.edit']);
   Route::post('/integrations/telephony/{code}/twilio/update',['uses' => 'app\settings\integrations\telephony\twilioController@update', 'as' => 'settings.integrations.telephony.twilio.update']);

   //africas talking
   Route::get('/integrations/telephony/{code}/africasTalking',['uses' => 'app\settings\integrations\telephony\africasTalkingController@edit', 'as' => 'settings.integrations.telephony.africasTalking.edit']);
   Route::post('/integrations/telephony/{code}/africasTalking/update',['uses' => 'app\settings\integrations\telephony\africasTalkingController@update', 'as' => 'settings.integrations.telephony.africasTalking.update']);

   //account subscription
   Route::get('subscription',['uses' => 'app\wingu\winguplusController@subscription', 'as' => 'settings.account.subscription']);

});


Route::prefix('winguplus')->middleware('auth')->group(function () {
   Route::get('/apps',['uses' => 'app\wingu\winguplusController@apps', 'as' => 'winguplus.apps']);
   Route::post('apps/install',['uses' => 'app\wingu\winguplusController@install', 'as' => 'winguplus.apps.install']);
});

//paypall
Route::post('/subscriptions/paypal',['uses' => 'app\wingu\paypalController@payment', 'as' => 'wingu.subscription.paypal']);
Route::get('/subscriptions/paypal/callback',['uses' => 'app\wingu\paypalController@callback', 'as' => 'wingu.subscription.paypal.callback']);
Route::get('/subscriptions/paypal/cancel',['uses' => 'app\wingu\paypalController@cancel', 'as' => 'wingu.subscription.paypal.cancel']);

//ipay
Route::get('/application/ipay/callback',['uses' => 'app\wingu\ipayController@callback', 'as' => 'wingu.application.payment']);

//tracking
Route::get('track/email/{mailCode}', ['uses' => 'app\wingu\trackerController@email']);
Route::get('track/invoice/{trackCode}/{invoiceID}', ['uses' => 'app\wingu\trackerController@invoice']);
Route::get('track/salesorder/{trackCode}/{salesID}', ['uses' => 'app\wingu\trackerController@salesorder']);
Route::get('track/quote/{trackCode}', ['uses' => 'app\wingu\trackerController@quote']);

//test lab section
Route::get('/lab/mailchimp', 'lab\mailchimpController@index');

//callbacks
Route::get('/callbacks/ipay/{business_code}',['uses' => 'app\callbacks\callbacksController@ipay', 'as' => 'callback.ipay']);

//daraja callback
Route::get('/callback/daraja/{business_code}',['uses' => 'app\callbacks\darajaController@callback', 'as' => 'daraja.payment.callback']);
Route::get('/callback/daraja/{business_code}/cancel',['uses' => 'app\callbacks\darajaController@cancel', 'as' => 'daraja.payment.cancel.callback']);

//flutterwave
Route::post('/application/flutterwave/pay',['uses' => 'app\wingu\flutterwaveController@pay', 'as' => 'wingu.application.flutterwave.pay']);
Route::get('/application/flutterwave/callback',['uses' => 'app\wingu\flutterwaveController@callback', 'as' => 'wingu.application.flutterwave.callback']);

Route::get('/ticket', ['uses' => 'app\wingu\winguplusController@tickets']);
Route::get('/ticket/{ticketCode}/details', ['uses' => 'app\wingu\winguplusController@ticket_details', 'as' => 'wingu.ticket.details']);

//pesapal
Route::get('/callbacks/pesapal/{business_code}',['uses' => 'app\callbacks\callbacksController@pesapal', 'as' => 'callback.pesapal']);


