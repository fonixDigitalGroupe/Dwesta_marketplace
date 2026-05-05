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
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentification
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // OAuth
    Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

    // Password Reset
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Email Verification Routes
    Route::get('/email/verify', [VerifyEmailController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [VerifyEmailController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');


    // Routes nécessitant une vérification d'email
    Route::middleware(['verified'])->group(function () {
        // Account Dashboard
        Route::get('/mon-compte', [\App\Http\Controllers\AccountController::class, 'index'])->name('account.index');

        // Profil
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
        
        // Mes Achats
        Route::get('/mes-achats', [\App\Http\Controllers\AccountController::class, 'orders'])->name('account.orders');
        Route::get('/mes-avis', [\App\Http\Controllers\AvisController::class, 'mesAvis'])->name('account.avis');

        // Mon Porte-Monnaie (Crédits)
        Route::prefix('mon-compte/credits')->name('account.credits.')->group(function () {
            Route::get('/', [\App\Http\Controllers\CreditController::class, 'index'])->name('index');
            Route::post('/checkout', [\App\Http\Controllers\CreditController::class, 'buyPack'])->name('checkout');
            Route::get('/success', [\App\Http\Controllers\CreditController::class, 'success'])->name('success');
        });

    // Vendeur
    Route::prefix('vendeur')->name('vendeur.')->group(function () {
        Route::get('/create', [VendeurController::class, 'create'])->name('create');
        Route::post('/particulier', [VendeurController::class, 'storeParticulier'])->name('store.particulier');
        Route::post('/professionnel', [VendeurController::class, 'storeProfessionnel'])->name('store.professionnel');
        Route::get('/mon-compte', [VendeurController::class, 'show'])->name('show');
        Route::get('/mes-annonces', [VendeurController::class, 'mesAnnonces'])->name('mes-annonces');
        Route::get('/mes-ventes', [VendeurController::class, 'orders'])->name('orders');
        Route::get('/mes-ventes/{order}', [VendeurController::class, 'orderShow'])->name('orders.show');
        Route::put('/{vendeur}/document-particulier', [VendeurController::class, 'updateDocumentParticulier'])->name('update.document.particulier');
        Route::put('/{vendeur}/document-professionnel', [VendeurController::class, 'updateDocumentProfessionnel'])->name('update.document.professionnel');

        // Wallet & Escrow
        Route::get('/wallet', [VendeurWalletController::class, 'index'])->name('wallet.index');
        Route::post('/wallet/withdraw', [VendeurWalletController::class, 'requestWithdrawal'])->name('wallet.withdraw');
    });

    // Abonnements
    Route::prefix('abonnements')->name('abonnements.')->group(function () {
        Route::get('/', [AbonnementController::class, 'index'])->name('index');
        Route::post('/checkout', [AbonnementController::class, 'checkout'])->name('checkout');
        Route::post('/subscribe', [AbonnementController::class, 'subscribe'])->name('subscribe');
        Route::post('/cancel', [AbonnementController::class, 'cancel'])->name('cancel');
    });

    // Cartes Cadeaux
    Route::prefix('cartes-cadeaux')->name('gift-cards.')->group(function () {
        Route::get('/', [\App\Http\Controllers\GiftCardController::class, 'index'])->name('index');
        Route::get('/succes', [\App\Http\Controllers\GiftCardController::class, 'success'])->name('success');
        Route::post('/redeem', [\App\Http\Controllers\GiftCardController::class, 'redeem'])->name('redeem');
        Route::post('/buy', [\App\Http\Controllers\GiftCardController::class, 'buy'])->name('buy');
    });

    // Page Pro (routes spécifiques AVANT la route avec paramètre)
    Route::prefix('page-pro')->name('page-pro.')->group(function () {
        Route::get('/edit', [PageProController::class, 'edit'])->name('edit');
        Route::put('/update', [PageProController::class, 'update'])->name('update');
    });

    // Avis
    Route::prefix('annonces/{annonce}/avis')->name('avis.')->group(function () {
        Route::get('/', [AvisController::class, 'index'])->name('index');
        Route::get('/create', [AvisController::class, 'create'])->name('create');
        Route::post('/', [AvisController::class, 'store'])->name('store');
    });

    // Admin - Vérification vendeurs
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::prefix('vendeurs')->name('vendeurs.')->group(function () {
            Route::get('/verification', [VendeurVerificationController::class, 'index'])->name('verification.index');
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


        // Litiges
        Route::prefix('litiges')->name('litiges.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\LitigeController::class, 'index'])->name('index');
            Route::get('/{litige}', [\App\Http\Controllers\Admin\LitigeController::class, 'show'])->name('show');
            Route::put('/{litige}', [\App\Http\Controllers\Admin\LitigeController::class, 'resolve'])->name('resolve');
        });

        // Modération Annonces
        Route::prefix('annonces')->name('annonces.')->group(function () {
            Route::get('/moderation', [\App\Http\Controllers\Admin\AnnonceModerationController::class, 'index'])->name('moderation.index');
            Route::post('/{annonce}/approve', [\App\Http\Controllers\Admin\AnnonceModerationController::class, 'approve'])->name('moderation.approve');
            Route::post('/{annonce}/reject', [\App\Http\Controllers\Admin\AnnonceModerationController::class, 'reject'])->name('moderation.reject');
        });

        // Gestion des Utilisateurs
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

        // Gestion des Codes Promo (Coupons)
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
        Route::patch('coupons/{coupon}/toggle-status', [\App\Http\Controllers\Admin\CouponController::class, 'toggleActive'])->name('coupons.toggle-status');

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

        // Système de crédits
        Route::prefix('credits')->name('credits.')->group(function () {
            Route::get('/',               [\App\Http\Controllers\Admin\CreditController::class, 'dashboard'])->name('dashboard');
            // Packs
            Route::get('/packs',          [\App\Http\Controllers\Admin\CreditController::class, 'packsIndex'])->name('packs');
            Route::get('/packs/create',   [\App\Http\Controllers\Admin\CreditController::class, 'packsCreate'])->name('packs.create');
            Route::post('/packs',         [\App\Http\Controllers\Admin\CreditController::class, 'packsStore'])->name('packs.store');
            Route::get('/packs/{pack}/edit', [\App\Http\Controllers\Admin\CreditController::class, 'packsEdit'])->name('packs.edit');
            Route::put('/packs/{pack}',   [\App\Http\Controllers\Admin\CreditController::class, 'packsUpdate'])->name('packs.update');
            Route::patch('/packs/{pack}/toggle-status', [\App\Http\Controllers\Admin\CreditController::class, 'packsToggleStatus'])->name('packs.toggle-status');
            Route::delete('/packs/{pack}',[\App\Http\Controllers\Admin\CreditController::class, 'packsDestroy'])->name('packs.destroy');
            // Services
            Route::get('/services',       [\App\Http\Controllers\Admin\CreditController::class, 'servicesIndex'])->name('services');
            Route::get('/services/create',[\App\Http\Controllers\Admin\CreditController::class, 'servicesCreate'])->name('services.create');
            Route::post('/services',      [\App\Http\Controllers\Admin\CreditController::class, 'servicesStore'])->name('services.store');
            Route::get('/services/{service}/edit', [\App\Http\Controllers\Admin\CreditController::class, 'servicesEdit'])->name('services.edit');
            Route::put('/services/{service}',      [\App\Http\Controllers\Admin\CreditController::class, 'servicesUpdate'])->name('services.update');
            Route::delete('/services/{service}',   [\App\Http\Controllers\Admin\CreditController::class, 'servicesDestroy'])->name('services.destroy');
            // Attribution manuelle
            Route::get('/attribuer',      [\App\Http\Controllers\Admin\CreditController::class, 'attribuerForm'])->name('attribuer');
            Route::post('/attribuer',     [\App\Http\Controllers\Admin\CreditController::class, 'attribuerStore'])->name('attribuer.store');
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
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
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
        Route::post('/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
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

// Webhook Stripe (Public)
Route::post('/webhook/stripe', [\App\Http\Controllers\StripeWebhookController::class, 'handle'])->name('stripe.webhook');

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
