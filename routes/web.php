<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BarCodeController;
use App\Http\Controllers\BarcodeAdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StripeCardController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatisticalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RssController;
use Illuminate\Support\Facades\Route;

Route::get('tuantt', [HomeController::class, 'tuantt']);
Route::get('count-visited', [StatisticalController::class, 'countVisited']);
Route::get('save-cache-visited-website', [StatisticalController::class, 'saveVisitedWebsite']);
Route::get('get-data-ajax-highchart',[StatisticalController::class, 'getDataAjaxHighchart'])->name('client.highchart');
Route::get('get-statistical-7-day-nearest',[StatisticalController::class, 'getStatistical7DayNearest']);
Route::get('get-info-git-pull-nearest',[StatisticalController::class, 'getInfoGitPullNearest'])->name('client.get-info-git-pull-nearest');

// BACKEND
Route::get('/toh-admincp',[AdminController::class, 'getLoginAdmin'])->name('login-admin');
Route::post('/login-admin', [AdminController::class, 'loginAdmin'])->name('post-login-admin');
Route::get('login-admin',function(){
	return redirect('/');
});
Route::get('/logout-admin',[AdminController::class, 'getLogoutAdmin'])->name('logout-admin');

Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix'=>'admincp'],function(){
		Route::get('/',[AdminController::class, 'getAdminCp']);
		
		Route::group(['prefix' => 'menu'],function () {
			Route::post('showMenuAjax',[AdminController::class, 'showMenuAjax'])->name('menu.show-menu-ajax');
			Route::post('setupMenuAjax',[AdminController::class, 'setupMenuAjax'])->name('menu.setup-menu-ajax');
			Route::post('save-menu',[AdminController::class, 'saveMenu'])->name('saveMenu');
		});
		
		Route::group(['prefix' => 'config'],function () {
			Route::get('editInfo',[AdminController::class, 'editInfo'])->name('editInfo');
			Route::get('slide',[AdminController::class, 'slide'])->name('slide');
			Route::post('addSlide', [AdminController::class, 'addSlide'])->name('config.add-slide')->name('addSlide');
			Route::post('editSlide', [AdminController::class, 'editSlide'])->name('config.edit-slide')->name('editSlide');
			Route::post('updateSlide',[AdminController::class, 'updateSlide'])->name('updateSlide');
			Route::get('menu',[AdminController::class, 'setupMenu'])->name('setupMenu');
			Route::put('update-config-home', [AdminController::class, 'updateConfigHome'])->name('config.update-config-home');
			Route::put('update-config-seo', [AdminController::class, 'updateConfigSeo'])->name('config.update-config-seo');
		
			Route::get('ads',[AdminController::class, 'ads']);
			Route::post('ads', [AdminController::class, 'postAds']);
		});

		Route::group(['prefix' => 'affs'],function () {
			Route::get('/', [AffController::class, 'index']);
			Route::post('/', [AffController::class, 'store']);
			Route::get('/create', [AffController::class, 'create']);
			Route::get('/{id}', [AffController::class, 'show']);
			Route::get('/{id}/edit', [AffController::class, 'edit']);
			Route::put('/{id}', [AffController::class, 'update']);
			Route::delete('/{id}', [AffController::class, 'destroy']);
		});
		
		Route::get('users/suggest', [UserController::class, 'suggestSearch']);
		Route::get('users/getDataAjax', [UserController::class, 'getDataAjax']);
		Route::get('users/getInfoByID/{id}', [UserController::class, 'getInfoByID']);
		Route::put('users/updateSefl', [UserController::class, 'updateSefl'])->name('user.updateSefl');
		Route::post('users/info', [UserController::class, 'infoRoleUser']);
		Route::delete('users/delMultiUser',[UserController::class, 'delMultiUser'])->name('delMultiUser');
		Route::resource('users', UserController::class);

		Route::resource('barcode', BarcodeAdminController::class);
		
		Route::get('customers/getDataAjax', [CustomerController::class, 'getDataAjax']);
		Route::delete('customers/delMultiUser', [CustomerController::class, 'delMultiUser'])->name('delMultiUser');
		Route::resource('customers', CustomerController::class);
		
		Route::get('permissions/suggest', [PermissionController::class, 'suggestSearch']);
		Route::get('permissions/getDataAjax', [PermissionController::class, 'getDataAjax']);
		Route::delete('permissions/delMulti', [PermissionController::class, 'delMulti']);
		Route::resource('permissions', PermissionController::class);
		
		Route::get('roles/{id}/listpermission', [RoleController::class, 'listpermission']);
		Route::get('roles/suggest', [RoleController::class, 'suggestSearch']);
		Route::get('roles/getDataAjax', [RoleController::class, 'getDataAjax']);
		Route::get('roles/getInfoByID/{id}', [RoleController::class, 'getInfoByID']);
		Route::delete('roles/delMulti', [RoleController::class, 'delMulti']);
		Route::resource('roles', RoleController::class);
		
		Route::get('pages/getDataAjax', [PageController::class, 'getDataAjax']);
		Route::delete('pages/delMulti', [PageController::class, 'delMulti']);
		Route::resource('pages', PageController::class);
		
		
		Route::get('page-mobile-app', [PageController::class, 'pageMobileApp']);
		Route::post('page-mobile-app/save', [PageController::class, 'pageMobileAppSave']);
		
		Route::get('page-about', [PageController::class, 'pageAbout']);
		Route::post('page-about/save', [PageController::class, 'pageAboutSave']);
		
		Route::get('page-faqs', [PageController::class, 'pageFaqs']);
		Route::post('page-faqs/save', [PageController::class, 'pageFaqsSave']);
		
		Route::get('services/getDataAjax', [ServiceController::class, 'getDataAjax']);
		Route::delete('services/delMulti', [ServiceController::class, 'delMulti']);
		Route::resource('services', ServiceController::class);
		
		Route::get('contacts/getDataAjax', [ContactController::class, 'getDataAjax']);
		Route::delete('contacts/delMulti', [ContactController::class, 'delMulti']);
		
		Route::group(['prefix' => 'posts'],function () {
			Route::get('getDataAjax', [PostController::class, 'getDataAjax']);
			Route::delete('delMulti', [PostController::class, 'delMulti']);
			Route::post('import', [PostController::class, 'import'])->name('posts.import');
		});
		
		Route::resource('posts', PostController::class);
		
		Route::resource('postcategories', PostCategoryController::class);
		
		
		Route::get('list',[UserController::class, 'getUserList'])->name('getUserList');
		
		Route::get('stripe', [StripeCardController::class, 'stripeIndex']);
		Route::post('stripe-account-ajax', [StripeCardController::class, 'stripeAccountAjax']);
		// Route::get('payment-logs', [StripeCardController::class, 'paymentLogs');
		Route::get('payment-logs-ajax', [StripeCardController::class, 'paymentLogsAjax']);
		
		Route::get('payment-logs-ajax', [StripeCardController::class, 'paymentLogsAjax'])->name('payment-data-ajax');
		// Route::delete('location/delMulti', [LocationController::class, 'delMulti');
		Route::resource('payment-logs', StripeCardController::class);
		
		Route::get('location/getDataAjax', [LocationController::class, 'getDataAjax'])->name('location-data-ajax');
		Route::delete('location/delMulti', [LocationController::class, 'delMulti']);
		Route::resource('location', LocationController::class);

		Route::get('redirects/getDataAjax', [RedirectController::class, 'getDataAjax']);
		Route::post('redirects/actionMulti', [RedirectController::class, 'actionMulti']);
		Route::resource('redirects', RedirectController::class);
		
		Route::group(['prefix' => 'articles'], function () {
			Route::get('getDataAjax', [ArticleController::class, 'getDataAjax']);
			Route::get('getArticleAjax', [ArticleController::class, 'getArticleAjax']);
			Route::delete('delMulti', [ArticleController::class, 'delMulti']);
		});
		Route::resource('articles', ArticleController::class);
        // Route::resource('articlecategories', 'App\Http\Controllers\UserController@index');
		Route::resource('articlecategories', ArticleCategoryController::class);

		//barcode
		Route::group(['prefix' => 'barcodes'], function () {
			Route::get('getDataAjax', [BarcodeAdminController::class, 'getDataAjax']);
			Route::get('getBarcodeAjax', [BarcodeAdminController::class, 'getBarcodeAjax']);
			Route::delete('delMulti', [BarcodeAdminController::class, 'delMulti']);
		});
		Route::resource('barcodes', BarcodeAdminController::class);

		// Them Danh muc
		Route::post('articlecategories', [ArticleCategoryController::class, 'store']);
		Route::get('info-cat-article-by-lang', [ArticleCategoryController::class, 'infoCatArticleByLang'])->name('info-cat-article-by-lang');
		
		Route::get('info-config-by-lang', [AdminController::class, 'infoConfigByLang'])->name('config.info-config-by-lang');
		Route::put('update-config-home', [AdminController::class, 'updateConfigHome'])->name('config.update-config-home');
		Route::put('update-config-seo', [AdminController::class, 'updateConfigSeo'])->name('config.update-config-seo');

	});
	
});

//AJAX
Route::get('settingPackageBarCodeAjax',[SettingController::class, 'settingPackageBarCodeAjax'])->name('settingPackageBarCodeAjax');

Route::get('get-barcode-info', [BarCodeController::class, 'getBarcodeJson'])->name('getBarcodeJson');

//FRONTEND
Route::get('/',[PublicController::class, 'getIndex'])->name('index');
Route::get('app', [PagesController::class, 'getAppPage'])->name('getAppPage');
Route::get('about', [PagesController::class, 'getAboutPage'])->name('getAboutPage');
Route::get('add-barcode', [PagesController::class, 'getAddBarcodePage'])->name('getAddBarcodePage');
Route::get('rss/article.xml', [RssController::class, 'indexTest'])->name('client.show-rss');

//update-seo-20/10/2022
Route::get('cat-article/blog', function() {
    return redirect('blog', 301);
});
Route::get('cat-article/new', function() {
    return redirect('new', 301);
});
Route::get('article/tag/{slug}', [ArticleController::class, 'showTagArticle'])->where('slug', '.*')->name('client.show-tag-article');
Route::get('/search',[ArticleController::class, 'search'])->name('search');  

Route::get('ajax/rate',[ArticleController::class, 'rateAjax']);//ajax-rate
Route::post('ajax/comment',[ArticleController::class, 'commentAjax']);//ajax-comment
Route::post('ajax/filter_comment',[ArticleController::class, 'filterCommentAjax']);//ajax-filter-comment
Route::post('ajax/delete_comment',[ArticleController::class, 'deleteCommentAjax']);//ajax-delete-comment
Route::get('ajax/search',[ArticleController::class, 'searchAjax']);//ajax-search
Route::get('ajax/templateShareSocial', [HomeController::class, 'templateShareSocial']);
Route::post('ajax/contact', [HomeController::class, 'postContact']);

Route::get('save-visited-kjq12at', [CronjobController::class, 'saveVisited'])->name('save-visited-kjq12at');//cronjob tinh view

// Route::group(['middleware' => 'authfrontend'], function () {
	Route::group(['prefix' => 'account'],function () {
		Route::get('info/{id}',[TaikhoanController::class, 'getInfoAccount'])->name('getInfoAccount');
	    Route::get('edit/{id}',[TaikhoanController::class, 'getAccountEdit'])->where('id','[0-9]+')->name('getAccountEdit');
	    Route::put('edit/{id}',[TaikhoanController::class, 'putAccountEdit'])->where('id','[0-9]+')->name('putAccountEdit');
	    Route::put('changepassAjax',[PublicController::class, 'changepassAjax'])->name('changepassAjax');
	});

	Route::group(['prefix' => 'barcode'],function () {
		Route::post('uploadImageAjax', [BarCodeController::class, 'uploadImageAjax'])->name('uploadImageAjax');

		Route::get('search',[BarCodeController::class, 'getSearchBarCode'])->name('getSearchBarCode');
		Route::get('list',[BarCodeController::class, 'listBarCodebyUser'])->where('id', '[0-9]+')->name('listBarCodebyUser');
		Route::get('add',[BarCodeController::class, 'getBarCodeAddbyUser'])->name('getBarCodeAddbyUser');
		Route::post('add',[BarCodeController::class, 'postBarCodeAddbyUser'])->name('postBarCodeAddbyUser');
		Route::post('addBarCodeNormalByUserAjax',[BarCodeController::class, 'addBarCodeNormalByUserAjax'])->name('addBarCodeNormalByUserAjax');
	    Route::get('edit/{id}',[BarCodeController::class, 'getBarCodeEditbyUser'])->where('id','[0-9]+')->name('getBarCodeEditbyUser');
	    Route::get('{id}/edit',[BarCodeController::class, 'edit'])->where('id','[0-9]+')->name('getBarCode');
	    Route::put('putBarCodeEditbyUser',[BarCodeController::class, 'putBarCodeEditbyUser'])->where('id','[0-9]+')->name('putBarCodeEditbyUser');
	    Route::get('view/{id}',[BarCodeController::class, 'getBarCode'])->where('id','[0-9]+')->name('getBarCode');
	    Route::put('putStateBarcodeTable',[BarCodeController::class, 'putStateBarcodeTable'])->where('id','[0-9]+')->name('putStateBarcodeTable');
        Route::delete('del',[BarCodeController::class, 'deleteBarCodebyUser'])->name('deleteBarCodebyUser');
        Route::delete('delMulti',[BarCodeController::class, 'deleteMultiBarCodebyUser'])->name('deleteMultiBarCodebyUser');
        Route::get('{slug}', [PublicController::class, 'getSearchBarcode'])->name('seo-barcode');
		Route::get('listBarCodeUserAjax',[BarCodeController::class, 'listBarCodeUserAjax'])->name('listBarCodeUserAjax');
	});

	Route::get('payment',[PaymentController::class, 'getPayment'])->name('getPayment');

	Route::get('paymentHistoryAjax',[PaymentController::class, 'paymentHistoryAjax'])->name('paymentHistoryAjax');
	Route::get('paymentConfirm',[PaymentController::class, 'paymentConfirm'])->name('paymentConfirm');
	Route::post('paymentConfirm',[PaymentController::class, 'postPaymentConfirm'])->name('postPaymentConfirm');
	Route::get('paypal', [PaymentController::class, 'getPaymentStatus'])->name('payment.status');

	Route::get('resultPaymentLocal',[PaymentController::class, 'resultPaymentLocal'])->name('resultPaymentLocal');
	Route::get('resultPaymentInternational',[PaymentController::class, 'resultPaymentInternational'])->name('resultPaymentInternational');
	Route::put('putStatePaymentTable',[PaymentController::class, 'putStatePaymentTable'])->name('putStatePaymentTable');

// });


// Route::get('barcode/{slug}-{id}',[PublicController::class, 'getSearchBarcode')->name('seo-barcode');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/barcode-sitemap.xml', [SitemapController::class, 'barcodes']);
Route::get('/page-sitemap.xml', [SitemapController::class, 'pages']);
Route::get('/article-sitemap.xml', [SitemapController::class, 'articles']);
//AJAX
Route::get('resetCodeAjax',[PublicController::class, 'resetCodeAjax'])->name('resetCodeAjax');
Route::get('resetpass',[PublicController::class, 'resetpass'])->name('resetpass');
Route::put('resetpassAjax',[PublicController::class, 'resetpassAjax'])->name('resetpassAjax');
Route::post('images/uploadImage',[PublicController::class, 'uploadImage'])->name('uploadImage');
Route::post('images/uploadImageBarcode',[PublicController::class, 'uploadImageBarcode'])->name('uploadImageBarcode');
Route::post('get-slug-barcode', [PublicController::class, 'getSlugAjax'])->name('get-slug-barcode');
// Category ( LUÔN ĐẮT Ở CUỐI )
Route::get('{slug}', [ArticleCategoryController::class, 'showCatArticles'])->where('slug', '.*')->name('client.show-cat-article');
Route::get('{cat}/{id}-{slug}', [PagesController::class, 'getDetailPage'])->name('getDetailPage');
