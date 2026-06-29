<?php

use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\VendeurVerificationController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AnnonceMediaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageProController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\VendeurController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VendeurWalletController;
use App\Http\Controllers\GiftCardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/offres/{slug}', [\App\Http\Controllers\BannerLandingController::class, 'show'])->name('banner.landing');
Route::get('/promotions/{code}', [\App\Http\Controllers\CouponLandingController::class, 'show'])->name('coupons.landing');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/conditions-generales', [PageController::class, 'terms'])->name('terms');
Route::get('/vie-privee', [PageController::class, 'privacy'])->name('privacy');
Route::get('/gestion-cookies', [PageController::class, 'cookies'])->name('cookies');
Route::get('/besoin-aide', [PageController::class, 'help'])->name('help');
Route::get('/signaler-contenu', [PageController::class, 'report'])->name('report');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/ouvrir-eshop', [PageController::class, 'eshop'])->name('eshop.landing');
Route::get('/astuces-vendeurs', [PageController::class, 'sellerTips'])->name('vendeur.astuces');
Route::get('/le-choix', [PageController::class, 'leChoix'])->name('le-choix');
Route::get('/la-securite', [PageController::class, 'laSecurite'])->name('la-securite');
Route::get('/service-clients', [PageController::class, 'serviceClients'])->name('service-clients');
Route::get('/expedition', [PageController::class, 'expedition'])->name('expedition');

// Espace Partenaire (PWA livreurs & transporteurs) : voir routes/partenaire.php



// Authentification
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register/check-email', [RegisterController::class, 'checkEmail'])->name('register.check-email');

    // OAuth
    Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

    // Password Reset
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

    // OTP Verification Routes (Session based)
    Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('otp.verify');
    Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify.post');
    Route::post('/verify-otp/resend', [OtpController::class, 'resend'])->name('otp.resend');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Email Verification Routes
    Route::get('/email/verify', [VerifyEmailController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [VerifyEmailController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');



    // Routes nécessitant une vérification d'email (espace client/vendeur, interdit au staff)
    Route::middleware(['verified', 'customer'])->group(function () {
        // Account Dashboard
        Route::get('/mon-compte', [\App\Http\Controllers\AccountController::class, 'index'])->name('account.index');
        Route::post('/mon-compte/update-location', [\App\Http\Controllers\AccountController::class, 'updateLocation'])->name('account.update-location');

        // Profil
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

        // Mes Achats
        Route::get('/mes-achats', [\App\Http\Controllers\AccountController::class, 'orders'])->name('account.orders');
        Route::get('/mes-achats/{order}', [\App\Http\Controllers\AccountController::class, 'orderShow'])->name('account.orders.show');
        Route::get('/mes-achats/{order}/suivi', [\App\Http\Controllers\AccountController::class, 'orderTracking'])->name('account.orders.tracking');
        Route::post('/mes-achats/{order}/annuler', [\App\Http\Controllers\AccountController::class, 'cancelOrder'])->name('account.orders.cancel');
        Route::get('/mes-avis', [\App\Http\Controllers\AvisController::class, 'mesAvis'])->name('account.avis');

        // Mon Porte-Monnaie (Crédits)
        Route::prefix('mon-compte/credits')->name('account.credits.')->group(function () {
            Route::get('/', [\App\Http\Controllers\CreditController::class, 'index'])->name('index');
            Route::post('/checkout', [\App\Http\Controllers\CreditController::class, 'buyPack'])->name('checkout');
            Route::get('/success', [\App\Http\Controllers\CreditController::class, 'success'])->name('success');
            Route::delete('/transactions/{id}', [\App\Http\Controllers\CreditController::class, 'destroyTransaction'])->name('transactions.destroy');
        });

        // Vendeur
        Route::prefix('vendeur')->name('vendeur.')->group(function () {
            Route::get('/create', [VendeurController::class, 'create'])->name('create');
            Route::post('/particulier', [VendeurController::class, 'storeParticulier'])->name('store.particulier');
            Route::post('/professionnel', [VendeurController::class, 'storeProfessionnel'])->name('store.professionnel');
            Route::get('/mon-compte', [VendeurController::class, 'show'])->name('show');
            Route::get('/mes-annonces', [VendeurController::class, 'mesAnnonces'])->name('mes-annonces');
            Route::get('/mes-commandes', [VendeurController::class, 'orders'])->name('orders');
            Route::get('/mes-commandes/{order}', [VendeurController::class, 'orderShow'])->name('orders.show');
            Route::get('/mes-commandes/{order}/facture', [VendeurController::class, 'invoice'])->name('orders.invoice');
            Route::get('/statistiques', [VendeurController::class, 'stats'])->name('stats');
            Route::put('/{vendeur}/document-particulier', [VendeurController::class, 'updateDocumentParticulier'])->name('update.document.particulier');
            Route::put('/{vendeur}/document-professionnel', [VendeurController::class, 'updateDocumentProfessionnel'])->name('update.document.professionnel');

            // Wallet & Escrow
            Route::get('/wallet', [VendeurWalletController::class, 'index'])->name('wallet.index');
            Route::post('/wallet/withdraw', [VendeurWalletController::class, 'requestWithdrawal'])->name('wallet.withdraw');
        });

        // Abonnements
        Route::prefix('abonnements')->name('abonnements.')->group(function () {
            Route::get('/', [AbonnementController::class, 'index'])->name('index');
            Route::get('/mon-abonnement', [AbonnementController::class, 'monAbonnement'])->name('mon-abonnement');
            Route::get('/checkout', [AbonnementController::class, 'checkout'])->name('checkout');
            Route::get('/{abonnement}', [AbonnementController::class, 'show'])->name('show');
            Route::post('/initiate', [AbonnementController::class, 'initiate'])->name('initiate');
            Route::post('/subscribe', [AbonnementController::class, 'subscribe'])->name('subscribe');
            Route::post('/cancel', [AbonnementController::class, 'cancel'])->name('cancel');
        });

        // Cartes Cadeaux
        Route::prefix('cartes-cadeaux')->name('gift-cards.')->group(function () {
            Route::get('/', [GiftCardController::class, 'index'])->name('index');
            Route::get('/succes', [GiftCardController::class, 'success'])->name('success');
            Route::post('/redeem', [GiftCardController::class, 'redeem'])->name('redeem');
            Route::post('/buy', [GiftCardController::class, 'buy'])->name('buy');
            Route::get('/checkout', [GiftCardController::class, 'checkout'])->name('checkout');
            Route::post('/confirm', [GiftCardController::class, 'confirm'])->name('confirm');
            Route::delete('/{giftCard}', [GiftCardController::class, 'destroy'])->name('destroy');
            Route::post('/apply-checkout', [GiftCardController::class, 'applyToCheckout'])->name('apply-checkout');
            Route::post('/check-balance', [GiftCardController::class, 'checkBalance'])->name('check-balance');
        });

        // Page Pro (routes spécifiques AVANT la route avec paramètre)
        Route::prefix('page-pro')->name('page-pro.')->group(function () {
            Route::get('/edit', [PageProController::class, 'edit'])->name('edit');
            Route::match(['post', 'put'], '/update', [PageProController::class, 'update'])->name('update');
        });

        // Avis
        Route::prefix('annonces/{annonce}/avis')->name('avis.')->group(function () {
            Route::get('/', [AvisController::class, 'index'])->name('index');
            Route::get('/create', [AvisController::class, 'create'])->name('create');
            Route::post('/', [AvisController::class, 'store'])->name('store');
        });

        // Admin - Vérification vendeurs
        Route::prefix('admin')->name('admin.')->middleware('staff')->group(function () {
            Route::prefix('vendeurs')->name('vendeurs.')->group(function () {
                // Route::get('/verification', [VendeurVerificationController::class, 'index'])->name('verification.index');
                Route::get('/verification/{vendeur}', [VendeurVerificationController::class, 'show'])->name('verification.show');
                Route::post('/verification/{vendeur}/approve', [VendeurVerificationController::class, 'approve'])->name('verification.approve');
                Route::post('/verification/{vendeur}/reject', [VendeurVerificationController::class, 'reject'])->name('verification.reject');
            });

            // Gestion des catégories (Admin)
            Route::prefix('categories')->name('categories.')->group(function () {
                Route::get('/niveau-1', [AdminCategoryController::class, 'indexL1'])->name('l1');
                Route::get('/niveau-2', [AdminCategoryController::class, 'indexL2'])->name('l2');
                Route::get('/niveau-3', [AdminCategoryController::class, 'indexL3'])->name('l3');
                Route::patch('/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('toggle-status');
            });
            Route::resource('categories', AdminCategoryController::class)->names([
                'index' => 'categories.index',
                'create' => 'categories.create',
                'store' => 'categories.store',
                'show' => 'categories.show',
                'edit' => 'categories.edit',
                'update' => 'categories.update',
                'destroy' => 'categories.destroy',
            ]);

            // Gestion des abonnements (Packs)
            Route::patch('abonnements/{abonnement}/toggle-status', [\App\Http\Controllers\Admin\AbonnementController::class, 'toggleStatus'])->name('abonnements.toggle-status');
            Route::resource('abonnements', \App\Http\Controllers\Admin\AbonnementController::class)->names([
                'index' => 'abonnements.index',
                'create' => 'abonnements.create',
                'store' => 'abonnements.store',
                'show' => 'abonnements.show',
                'edit' => 'abonnements.edit',
                'update' => 'abonnements.update',
                'destroy' => 'abonnements.destroy',
            ]);

            // Modération des avis (Admin)
            Route::prefix('avis')->name('avis.')->group(function () {
                Route::get('/moderation', [AvisController::class, 'moderation'])->name('moderation');
                Route::post('/{avis}/approve', [AvisController::class, 'approve'])->name('approve');
                Route::post('/{avis}/reject', [AvisController::class, 'reject'])->name('reject');
            });

            // Admin root - dashboard
            Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

            // Messagerie admin (envoi de messages aux vendeurs / clients)
            Route::prefix('messagerie')->name('messagerie.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\MessagerieController::class, 'index'])->name('index');
                Route::post('/send', [\App\Http\Controllers\Admin\MessagerieController::class, 'send'])->name('send');
                Route::get('/{conversation}', [\App\Http\Controllers\Admin\MessagerieController::class, 'show'])->name('show');
                Route::post('/{conversation}/reply', [\App\Http\Controllers\Admin\MessagerieController::class, 'reply'])->name('reply');
                Route::delete('/{conversation}', [\App\Http\Controllers\Admin\MessagerieController::class, 'destroy'])->name('destroy');
            });


            // Litiges
            Route::prefix('litiges')->name('litiges.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\LitigeController::class, 'index'])->name('index');
                Route::get('/{litige}', [\App\Http\Controllers\Admin\LitigeController::class, 'show'])->name('show');
                Route::put('/{litige}', [\App\Http\Controllers\Admin\LitigeController::class, 'resolve'])->name('resolve');
            });

            // Gestion Annonces (Articles)
            Route::prefix('annonces')->name('annonces.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\AnnonceController::class, 'index'])->name('index');
                Route::post('/{annonce}/approve', [\App\Http\Controllers\Admin\AnnonceController::class, 'approve'])->name('moderation.approve');
                Route::post('/{annonce}/reject', [\App\Http\Controllers\Admin\AnnonceController::class, 'reject'])->name('moderation.reject');
            });

            // Gestion des Commandes
            Route::prefix('orders')->name('orders.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('index');
                Route::get('/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('show');
            });

            // Gestion Finance
            Route::prefix('finance')->name('finance.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\FinanceController::class, 'index'])->name('index');
            });

            // Gestion des Utilisateurs
            Route::post('/users/{user}/send-credentials', [\App\Http\Controllers\Admin\UserController::class, 'sendCredentials'])->name('users.send-credentials');
            Route::patch('/users/{user}/suspend', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.suspend');
            Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

            // Gestion des Rôles & Permissions
            Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);

            // Gestion Logistique
            Route::prefix('transporteurs')->name('transporteurs.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\TransporteurController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\Admin\TransporteurController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\Admin\TransporteurController::class, 'store'])->name('store');
                Route::get('/{transporteur}', [\App\Http\Controllers\Admin\TransporteurController::class, 'show'])->name('show');
                Route::get('/{transporteur}/edit', [\App\Http\Controllers\Admin\TransporteurController::class, 'edit'])->name('edit');
                Route::put('/{transporteur}', [\App\Http\Controllers\Admin\TransporteurController::class, 'update'])->name('update');
                Route::delete('/{transporteur}', [\App\Http\Controllers\Admin\TransporteurController::class, 'destroy'])->name('destroy');
                Route::post('/{transporteur}/approve', [\App\Http\Controllers\Admin\TransporteurController::class, 'approve'])->name('approve');
                Route::post('/{transporteur}/reject', [\App\Http\Controllers\Admin\TransporteurController::class, 'reject'])->name('reject');
            });

            Route::prefix('livreurs')->name('livreurs.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\LivreurController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\Admin\LivreurController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\Admin\LivreurController::class, 'store'])->name('store');
                Route::get('/{livreur}', [\App\Http\Controllers\Admin\LivreurController::class, 'show'])->name('show');
                Route::get('/{livreur}/edit', [\App\Http\Controllers\Admin\LivreurController::class, 'edit'])->name('edit');
                Route::put('/{livreur}', [\App\Http\Controllers\Admin\LivreurController::class, 'update'])->name('update');
                Route::delete('/{livreur}', [\App\Http\Controllers\Admin\LivreurController::class, 'destroy'])->name('destroy');
                Route::post('/{livreur}/approve', [\App\Http\Controllers\Admin\LivreurController::class, 'approve'])->name('approve');
                Route::post('/{livreur}/reject', [\App\Http\Controllers\Admin\LivreurController::class, 'reject'])->name('reject');
            });

            Route::resource('point-relais', \App\Http\Controllers\Admin\PointRelaisController::class)->parameters([
                'point-relais' => 'point_relais'
            ]);

            // Gestion des Bannières
            Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
            Route::patch('banners/{banner}/toggle-status', [\App\Http\Controllers\Admin\BannerController::class, 'toggleStatus'])->name('banners.toggle-status');

            // Hub Promotions & Campagnes (Cibles vendeurs)
            Route::get('promotions', [\App\Http\Controllers\Admin\PromotionController::class, 'index'])->name('promotions.index');
            Route::resource('campaigns', \App\Http\Controllers\Admin\CampaignController::class)->except(['show']);

            // Gestion des Codes Promo (Coupons)
            Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class)->except(['index']);
            Route::patch('coupons/{coupon}/toggle-status', [\App\Http\Controllers\Admin\CouponController::class, 'toggleActive'])->name('coupons.toggle-status');

            // Gestion des Cartes Cadeaux
            Route::patch('gift_cards/{giftCardOption}/toggle-status', [\App\Http\Controllers\Admin\GiftCardOptionController::class, 'toggleStatus'])->name('gift_cards.toggle-status');
            Route::resource('gift_cards', \App\Http\Controllers\Admin\GiftCardOptionController::class)->parameters(['gift_cards' => 'giftCardOption']);

            // Gestion des Actualités (Highlights)
            Route::resource('highlight-tabs', \App\Http\Controllers\Admin\HighlightTabController::class);
            Route::patch('highlight-tabs/{highlightTab}/toggle-status', [\App\Http\Controllers\Admin\HighlightTabController::class, 'toggleStatus'])->name('highlight-tabs.toggle-status');
            Route::resource('highlights', \App\Http\Controllers\Admin\HighlightController::class);
            Route::patch('highlights/{highlight}/toggle-status', [\App\Http\Controllers\Admin\HighlightController::class, 'toggleStatus'])->name('highlights.toggle-status');

            // Gestion des critères de filtrage
            Route::get('filters/categories/{category}/children', [\App\Http\Controllers\Admin\CategoryFilterController::class, 'getChildren'])->name('filters.categories.children');
            Route::patch('filters/{filter}/toggle-status', [\App\Http\Controllers\Admin\CategoryFilterController::class, 'toggleStatus'])->name('filters.toggle-status');
            Route::resource('filters', \App\Http\Controllers\Admin\CategoryFilterController::class);

            // Configuration Générale
            Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
            Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
            Route::get('/settings/visibility', [\App\Http\Controllers\Admin\SettingController::class, 'visibility'])->name('settings.visibility');
            Route::get('/settings/visibility/create', [\App\Http\Controllers\Admin\SettingController::class, 'visibilityCreate'])->name('settings.visibility.create');
            Route::post('/settings/visibility', [\App\Http\Controllers\Admin\SettingController::class, 'visibilityStore'])->name('settings.visibility.store');
            Route::get('/settings/visibility/{service}/edit', [\App\Http\Controllers\Admin\SettingController::class, 'visibilityEdit'])->name('settings.visibility.edit');
            Route::put('/settings/visibility/{service}', [\App\Http\Controllers\Admin\SettingController::class, 'visibilityUpdate'])->name('settings.visibility.update');
            Route::delete('/settings/visibility/{service}', [\App\Http\Controllers\Admin\SettingController::class, 'visibilityDestroy'])->name('settings.visibility.destroy');
            Route::patch('/settings/visibility/{service}/toggle', [\App\Http\Controllers\Admin\SettingController::class, 'visibilityToggle'])->name('settings.visibility.toggle');

            // Gestion des Frais de Livraison
            Route::prefix('shipping')->name('shipping.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\ShippingRuleController::class, 'index'])->name('index');
                Route::post('/', [\App\Http\Controllers\Admin\ShippingRuleController::class, 'store'])->name('store');
                Route::put('/{shippingRule}', [\App\Http\Controllers\Admin\ShippingRuleController::class, 'update'])->name('update');
                Route::delete('/{shippingRule}', [\App\Http\Controllers\Admin\ShippingRuleController::class, 'destroy'])->name('destroy');
                Route::patch('/{shippingRule}/toggle', [\App\Http\Controllers\Admin\ShippingRuleController::class, 'toggle'])->name('toggle');
            });

            // Gestion des Pays
            Route::patch('countries/{country}/toggle-status', [\App\Http\Controllers\Admin\CountryController::class, 'toggleStatus'])->name('countries.toggle-status');
            // Régions d'un pays
            Route::post('countries/{country}/import-geography', [\App\Http\Controllers\Admin\CountryController::class, 'importGeography'])->name('countries.import-geography');
            Route::post('countries/{country}/regions', [\App\Http\Controllers\Admin\CountryController::class, 'storeRegion'])->name('countries.regions.store');
            Route::patch('regions/{region}/toggle', [\App\Http\Controllers\Admin\CountryController::class, 'toggleRegion'])->name('countries.regions.toggle');
            Route::delete('regions/{region}', [\App\Http\Controllers\Admin\CountryController::class, 'destroyRegion'])->name('countries.regions.destroy');
            Route::resource('countries', \App\Http\Controllers\Admin\CountryController::class);

            // Système de crédits
            Route::prefix('credits')->name('credits.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\CreditController::class, 'dashboard'])->name('dashboard');
                // Packs
                Route::get('/packs', [\App\Http\Controllers\Admin\CreditController::class, 'packsIndex'])->name('packs');
                Route::get('/packs/create', [\App\Http\Controllers\Admin\CreditController::class, 'packsCreate'])->name('packs.create');
                Route::post('/packs', [\App\Http\Controllers\Admin\CreditController::class, 'packsStore'])->name('packs.store');
                Route::get('/packs/{pack}/edit', [\App\Http\Controllers\Admin\CreditController::class, 'packsEdit'])->name('packs.edit');
                Route::put('/packs/{pack}', [\App\Http\Controllers\Admin\CreditController::class, 'packsUpdate'])->name('packs.update');
                Route::patch('/packs/{pack}/toggle-status', [\App\Http\Controllers\Admin\CreditController::class, 'packsToggleStatus'])->name('packs.toggle-status');
                Route::delete('/packs/{pack}', [\App\Http\Controllers\Admin\CreditController::class, 'packsDestroy'])->name('packs.destroy');
                // Services
                Route::get('/services', [\App\Http\Controllers\Admin\CreditController::class, 'servicesIndex'])->name('services');
                Route::get('/services/create', [\App\Http\Controllers\Admin\CreditController::class, 'servicesCreate'])->name('services.create');
                Route::post('/services', [\App\Http\Controllers\Admin\CreditController::class, 'servicesStore'])->name('services.store');
                Route::get('/services/{service}/edit', [\App\Http\Controllers\Admin\CreditController::class, 'servicesEdit'])->name('services.edit');
                Route::put('/services/{service}', [\App\Http\Controllers\Admin\CreditController::class, 'servicesUpdate'])->name('services.update');
                Route::delete('/services/{service}', [\App\Http\Controllers\Admin\CreditController::class, 'servicesDestroy'])->name('services.destroy');
                // Attribution manuelle
                Route::get('/attribuer', [\App\Http\Controllers\Admin\CreditController::class, 'attribuerForm'])->name('attribuer');
                Route::post('/attribuer', [\App\Http\Controllers\Admin\CreditController::class, 'attribuerStore'])->name('attribuer.store');
            });
        });

        // Documents sécurisés (accessibles uniquement aux admins)
        Route::get('/documents/{path}', [DocumentController::class, 'show'])
            ->middleware('role:admin')
            ->name('documents.show');

        // Annonces (routes spécifiques AVANT la route publique)
        Route::prefix('annonces')->name('annonces.')->group(function () {
            Route::get('/', [AnnonceController::class, 'index'])->name('index');
            Route::get('/create', [AnnonceController::class, 'create'])->name('create');
            Route::post('/', [AnnonceController::class, 'store'])->name('store');
            Route::get('/import', [AnnonceController::class, 'showImportForm'])->name('import');
            Route::post('/import', [AnnonceController::class, 'importCSV'])->name('import.store');
            Route::get('/template', [AnnonceController::class, 'downloadTemplate'])->name('template');
            Route::get('/{annonce}/preview', [AnnonceController::class, 'preview'])->name('preview');
            Route::get('/{annonce}/edit', [AnnonceController::class, 'edit'])->name('edit');
            Route::put('/{annonce}', [AnnonceController::class, 'update'])->name('update');
            Route::post('/{annonce}/publier', [AnnonceController::class, 'publier'])->name('publier');
            Route::delete('/{annonce}', [AnnonceController::class, 'destroy'])->name('destroy');

            // Médias des annonces
            Route::prefix('{annonce}/medias')->name('medias.')->group(function () {
                Route::post('/photos', [AnnonceMediaController::class, 'uploadPhoto'])->name('upload-photo');
                Route::post('/videos', [AnnonceMediaController::class, 'uploadVideo'])->name('upload-video');
                Route::post('/reorder', [AnnonceMediaController::class, 'reorder'])->name('reorder');
                Route::post('/{media}/set-main', [AnnonceMediaController::class, 'setMainPhoto'])->name('set-main');
                Route::delete('/{media}', [AnnonceMediaController::class, 'destroy'])->name('destroy');
            });
        });

        // Checkout
        Route::prefix('checkout')->name('checkout.')->group(function () {
            Route::get('/etape-1', [CheckoutController::class, 'step1'])->name('step1');
            Route::post('/etape-1', [CheckoutController::class, 'postStep1'])->name('postStep1');
            Route::get('/etape-2', [CheckoutController::class, 'step2'])->name('step2');
            Route::get('/paydunya-token', [CheckoutController::class, 'paydunyaToken'])->name('paydunya.token');
            Route::post('/process', [CheckoutController::class, 'process'])->name('process');
            Route::get('/payer/{token}', [CheckoutController::class, 'showPaymentPage'])->name('pay');
            Route::post('/process-softpay/{token}', [CheckoutController::class, 'processSoftPay'])->name('process-softpay');
            Route::get('/succes', [CheckoutController::class, 'success'])->name('success');
        });

        // Logistique & Scan
        Route::prefix('logistique')->group(function () {
            Route::get('/transporteur', [\App\Http\Controllers\Logistics\TransporteurDashboardController::class, 'index'])
                ->middleware('role:transporteur|admin')
                ->name('transporteur.dashboard');

            Route::post('/transporteur/{order}/pickup', [\App\Http\Controllers\Logistics\TransporteurDashboardController::class, 'pickup'])
                ->middleware('role:transporteur|admin')
                ->name('transporteur.pickup');

            Route::post('/transporteur/{order}/dropoff', [\App\Http\Controllers\Logistics\TransporteurDashboardController::class, 'dropoff'])
                ->middleware('role:transporteur|admin')
                ->name('transporteur.dropoff');

            Route::get('/livreur', [\App\Http\Controllers\Logistics\LivreurDashboardController::class, 'index'])
                ->middleware('role:livreur|admin')
                ->name('livreur.dashboard');

            Route::get('/livreur/available', [\App\Http\Controllers\Logistics\LivreurDashboardController::class, 'availableOrders'])
                ->middleware('role:livreur|admin')
                ->name('livreur.orders.available');

            Route::get('/livreur/ongoing', [\App\Http\Controllers\Logistics\LivreurDashboardController::class, 'ongoingOrders'])
                ->middleware('role:livreur|admin')
                ->name('livreur.orders.ongoing');

            Route::get('/livreur/history', [\App\Http\Controllers\Logistics\LivreurDashboardController::class, 'deliveryHistory'])
                ->middleware('role:livreur|admin')
                ->name('livreur.orders.history');

            Route::post('/livreur/{order}/pickup', [\App\Http\Controllers\Logistics\LivreurDashboardController::class, 'pickup'])
                ->middleware('role:livreur|admin')
                ->name('livreur.pickup');

            Route::post('/livreur/{order}/delivered', [\App\Http\Controllers\Logistics\LivreurDashboardController::class, 'delivered'])
                ->middleware('role:livreur|admin')
                ->name('livreur.delivered');

            Route::get('/relais', [\App\Http\Controllers\Logistics\PointRelaisDashboardController::class, 'index'])
                ->middleware('role:point_relais|admin')
                ->name('relais.dashboard');

            Route::get('/scan', [ScanController::class, 'index'])
                ->middleware('permission:scanner qr code')
                ->name('scan.index');

            Route::post('/scan', [ScanController::class, 'process'])
                ->middleware('permission:scanner qr code')
                ->name('scan.process');

            Route::get('/suivi/{reference}', [ScanController::class, 'track'])->name('scan.track');

            Route::post('/vendeur/orders/{order}/ready', [\App\Http\Controllers\LogisticsController::class, 'markAsReady'])->name('logistics.markAsReady');
        });

        // Crédits & Porte-Monnaie
        Route::prefix('credits')->name('credits.')->group(function () {
            Route::get('/', [CreditController::class, 'index'])->name('index');
            Route::post('/buy', [CreditController::class, 'buyPack'])->name('buy');
        });

        // Abonnements group removed (duplicate)

        // Messagerie
        Route::prefix('messagerie')->name('conversations.')->group(function () {
            Route::get('/', [ConversationController::class, 'index'])->name('index');
            Route::get('/create', [ConversationController::class, 'create'])->name('create');
            Route::post('/', [ConversationController::class, 'store'])->name('store');
            Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
            Route::delete('/{conversation}', [ConversationController::class, 'destroy'])->name('destroy');
            Route::post('/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
            Route::delete('/{conversation}/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
            Route::delete('/{conversation}/annonce', [ConversationController::class, 'removeAnnonce'])->name('remove-annonce');
        });

        // Favoris
        Route::get('/favoris', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/annonces/{annonce}/favorite', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');

        // Reviews (Avis global)
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    }); // Fin du middleware 'verified'
});

// Annonces publiques (accessible sans authentification) - DOIT être APRÈS les routes authentifiées
Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])->name('annonces.show');

// Page Pro publique (accessible sans authentification) - DOIT être APRÈS les routes authentifiées pour éviter les conflits
Route::get('/page-pro/{slug}', [PageProController::class, 'show'])->name('page-pro.show');

// Catégories publiques (accessible sans authentification)
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Collections / Promos (Bannières)
Route::get('/collections/{slug}', [App\Http\Controllers\CollectionController::class, 'show'])->name('collections.show');

// Recherche publique
Route::get('/recherche', [\App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
Route::get('/api/search/autocomplete', [\App\Http\Controllers\SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::get('/api/categories/{category}/filters', [CategoryController::class, 'getFilters'])->name('api.categories.filters');
Route::get('/api/campaigns/check-promo', [\App\Http\Controllers\CampaignPromoController::class, 'check'])->name('api.campaigns.check-promo');
Route::get('/api/campaigns/has-active', [\App\Http\Controllers\CampaignPromoController::class, 'hasActive'])->name('api.campaigns.has-active');

// Campaign Landing Page
Route::get('/offres-speciales/{campaign}', [\App\Http\Controllers\CampaignLandingController::class, 'show'])->name('campaign.landing');

// Webhook Stripe (Legacy)
Route::post('/webhook/stripe', [\App\Http\Controllers\StripeWebhookController::class, 'handle'])->name('stripe.webhook');

// PayDunya Callback & Return Routes
Route::get('/paydunya/success', [\App\Http\Controllers\PayDunyaCallbackController::class, 'success'])->name('paydunya.success');
Route::get('/paydunya/cancel', [\App\Http\Controllers\PayDunyaCallbackController::class, 'cancel'])->name('paydunya.cancel');
Route::post('/paydunya/callback', [\App\Http\Controllers\PayDunyaCallbackController::class, 'callback'])->name('paydunya.callback');

// Panier
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter', [CartController::class, 'store'])->name('cart.store');
Route::patch('/panier/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/panier/supprimer/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/panier/vider', [CartController::class, 'clear'])->name('cart.clear');

// Routes de succès/annulation pour les abonnements (besoin d'être dans auth pour rediriger vers le dashboard par exemple)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/abonnements/succes', [AbonnementController::class, 'success'])->name('abonnements.success');
});

// Registration Step 2: Complete Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/register/complete', [RegisterController::class, 'showCompletionForm'])->name('register.complete');
    Route::post('/register/complete', [RegisterController::class, 'completeRegistration'])->name('register.complete.post');
});
