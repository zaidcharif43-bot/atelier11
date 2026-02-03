# 💻 Exemples de Code - Système d'Authentification

## 🔐 1. Vérification du Rôle dans une Vue Blade

### Vérifier si l'utilisateur est Admin
```blade
@auth
    @if(Auth::user()->isAdmin())
        <p>Vous êtes administrateur</p>
        <a href="{{ route('espaceadmin') }}">Accéder à l'espace admin</a>
    @endif
@endauth
```

### Vérifier si l'utilisateur est User
```blade
@auth
    @if(Auth::user()->isUser())
        <p>Bienvenue client!</p>
        <a href="{{ route('espaceclient') }}">Voir les promotions</a>
    @endif
@endauth
```

### Menu Complet Adaptatif
```blade
<nav>
    <a href="{{ route('home') }}">Accueil</a>
    <a href="{{ route('produits.index') }}">Boutique</a>
    
    @auth
        @if(Auth::user()->isAdmin())
            <a href="{{ route('produits.manage') }}">Gérer Produits</a>
            <a href="{{ route('espaceadmin') }}">Espace Admin</a>
        @elseif(Auth::user()->isUser())
            <a href="{{ route('espaceclient') }}">Espace Client</a>
        @endif
        
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @else
        <a href="{{ route('login') }}">Connexion</a>
        <a href="{{ route('register') }}">Inscription</a>
    @endauth
</nav>
```

## 🛡️ 2. Protection des Routes

### Routes ADMIN uniquement
```php
// routes/web.php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/espaceadmin', [ProduitController::class, 'espaceadmin'])->name('espaceadmin');
    Route::get('/produits/manage', [RproductController::class, 'manage'])->name('produits.manage');
    Route::get('/produits/create', [RproductController::class, 'create'])->name('produits.create');
    Route::post('/produits/store', [RproductController::class, 'store'])->name('produits.store');
    Route::get('/produits/{id}/edit', [RproductController::class, 'edit'])->name('produits.edit');
    Route::put('/produits/{id}', [RproductController::class, 'update'])->name('produits.update');
    Route::delete('/produits/{id}', [RproductController::class, 'destroy'])->name('produits.delete');
});
```

### Routes USER uniquement
```php
// routes/web.php
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/espaceclient', [ProduitController::class, 'espaceclient'])->name('espaceclient');
    Route::get('/mon-profil', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/mes-commandes', [OrderController::class, 'index'])->name('user.orders');
});
```

### Route avec authentification simple (tous les connectés)
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/mon-compte', [AccountController::class, 'show'])->name('account');
});
```

## 👤 3. Création d'Utilisateurs

### Via RegisterController (automatique à l'inscription)
```php
// app/Http/Controllers/Auth/RegisterController.php
protected function create(array $data)
{
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => 'USER', // Rôle par défaut
    ]);
}
```

### Manuellement dans un Controller
```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Créer un utilisateur standard
$user = User::create([
    'name' => 'Jean Dupont',
    'email' => 'jean@example.com',
    'password' => Hash::make('password123'),
    'role' => User::USER_ROLE,
]);

// Créer un administrateur
$admin = User::create([
    'name' => 'Admin Principal',
    'email' => 'admin@example.com',
    'password' => Hash::make('admin123'),
    'role' => User::ADMIN_ROLE,
]);
```

### Via Tinker (console)
```bash
php artisan tinker
```
```php
>>> use App\Models\User;
>>> use Illuminate\Support\Facades\Hash;
>>> User::create(['name' => 'Test User', 'email' => 'test@test.com', 'password' => Hash::make('password'), 'role' => 'USER']);
```

### Via Seeder
```php
// database/seeders/UsersSeeder.php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

public function run(): void
{
    User::create([
        'name' => 'Admin',
        'email' => 'admin@clotheszc.com',
        'password' => Hash::make('admin123'),
        'role' => User::ADMIN_ROLE,
    ]);

    User::create([
        'name' => 'Client',
        'email' => 'client@clotheszc.com',
        'password' => Hash::make('client123'),
        'role' => User::USER_ROLE,
    ]);
}
```

## 🔍 4. Vérifications dans les Controllers

### Vérifier le rôle dans un Controller
```php
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            // Logique spécifique admin
            return view('admin.products.index');
        }
        
        // Logique pour tous les utilisateurs
        return view('products.index');
    }
    
    public function create()
    {
        // Vérification manuelle (en plus du middleware)
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }
        
        return view('products.create');
    }
}
```

### Obtenir l'utilisateur connecté
```php
// Récupérer l'utilisateur
$user = Auth::user();

// Accéder aux propriétés
$name = Auth::user()->name;
$email = Auth::user()->email;
$role = Auth::user()->role;

// Vérifier le rôle
if (Auth::user()->isAdmin()) {
    // Logique admin
}

// Vérifier si connecté
if (Auth::check()) {
    // Utilisateur connecté
}
```

## 🛠️ 5. Middleware Personnalisé

### Créer un Middleware
```bash
php artisan make:middleware IsAdmin
```

### Code du Middleware IsAdmin
```php
// app/Http/Middleware/IsAdmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté.');
        }

        // Vérifier si l'utilisateur est admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès interdit. Vous devez être administrateur.');
        }

        return $next($request);
    }
}
```

### Enregistrer le Middleware
```php
// bootstrap/app.php
return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'user' => \App\Http\Middleware\IsUser::class,
        ]);
    })
    ->create();
```

## 📊 6. Afficher des Données Selon le Rôle

### Controller avec logique conditionnelle
```php
public function dashboard()
{
    $user = Auth::user();
    
    if ($user->isAdmin()) {
        // Statistiques complètes pour admin
        $stats = [
            'totalUsers' => User::count(),
            'totalProducts' => Produit::count(),
            'totalOrders' => Order::count(),
            'revenue' => Order::sum('total'),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
    
    if ($user->isUser()) {
        // Données personnelles pour user
        $orders = Order::where('user_id', $user->id)->get();
        $favoriteProducts = $user->favoriteProducts()->get();
        
        return view('user.dashboard', compact('orders', 'favoriteProducts'));
    }
}
```

### Vue avec affichage conditionnel
```blade
<div class="dashboard">
    <h1>Tableau de Bord</h1>
    
    @if(Auth::user()->isAdmin())
        {{-- Statistiques Admin --}}
        <div class="admin-stats">
            <div class="stat-card">
                <h3>Utilisateurs</h3>
                <p>{{ $totalUsers }}</p>
            </div>
            <div class="stat-card">
                <h3>Produits</h3>
                <p>{{ $totalProducts }}</p>
            </div>
        </div>
        
        <a href="{{ route('produits.create') }}" class="btn">Ajouter un produit</a>
    @elseif(Auth::user()->isUser())
        {{-- Informations Client --}}
        <div class="user-info">
            <h2>Mes Commandes</h2>
            @foreach($orders as $order)
                <div class="order-card">
                    <p>Commande #{{ $order->id }}</p>
                    <p>{{ $order->total }}€</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
```

## 🎨 7. Composants Réutilisables

### Créer un Component pour le menu utilisateur
```bash
php artisan make:component UserMenu
```

```php
// app/View/Components/UserMenu.php
namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class UserMenu extends Component
{
    public $user;
    
    public function __construct()
    {
        $this->user = Auth::user();
    }
    
    public function render()
    {
        return view('components.user-menu');
    }
}
```

```blade
{{-- resources/views/components/user-menu.blade.php --}}
@auth
    <div class="user-menu">
        <button class="user-btn">
            <i class="fas fa-user"></i>
            {{ $user->name }}
        </button>
        
        <div class="dropdown">
            @if($user->isAdmin())
                <a href="{{ route('espaceadmin') }}">Espace Admin</a>
                <a href="{{ route('produits.manage') }}">Gérer Produits</a>
            @elseif($user->isUser())
                <a href="{{ route('espaceclient') }}">Espace Client</a>
            @endif
            
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Déconnexion
            </a>
        </div>
    </div>
@endauth
```

### Utiliser le Component
```blade
<nav>
    <a href="{{ route('home') }}">Accueil</a>
    <a href="{{ route('produits.index') }}">Boutique</a>
    <x-user-menu />
</nav>
```

## 🔄 8. Redirection Après Connexion

### Rediriger selon le rôle
```php
// app/Http/Controllers/Auth/LoginController.php
protected function authenticated(Request $request, $user)
{
    if ($user->isAdmin()) {
        return redirect()->route('espaceadmin');
    }
    
    if ($user->isUser()) {
        return redirect()->route('espaceclient');
    }
    
    return redirect()->route('home');
}
```

### Rediriger vers la page demandée
```php
// Dans le middleware
if (!Auth::check()) {
    return redirect()->route('login')
        ->with('intended', $request->url());
}

// Après connexion
return redirect()->intended(route('home'));
```

## 📝 9. Formulaires avec Protection CSRF

### Formulaire de déconnexion
```blade
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<a href="{{ route('logout') }}" 
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Déconnexion
</a>
```

### Formulaire de modification de rôle (Admin uniquement)
```blade
@if(Auth::user()->isAdmin())
    <form action="{{ route('user.update.role', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <select name="role">
            <option value="USER" {{ $user->role == 'USER' ? 'selected' : '' }}>User</option>
            <option value="ADMIN" {{ $user->role == 'ADMIN' ? 'selected' : '' }}>Admin</option>
        </select>
        
        <button type="submit">Modifier le rôle</button>
    </form>
@endif
```

## 🎯 10. Tests et Débogage

### Afficher le rôle de l'utilisateur
```blade
@auth
    <p>Connecté en tant que: {{ Auth::user()->name }} ({{ Auth::user()->role }})</p>
@endauth
```

### Tester les permissions
```php
// Dans un controller ou une vue
dump(Auth::check()); // true/false
dump(Auth::user()); // Objet User ou null
dump(Auth::user()->role); // 'USER' ou 'ADMIN'
dump(Auth::user()->isAdmin()); // true/false
dump(Auth::user()->isUser()); // true/false
```

### Vérifier les routes protégées
```bash
php artisan route:list
```

---

Ces exemples couvrent les cas d'usage les plus courants du système d'authentification et de gestion des rôles!
