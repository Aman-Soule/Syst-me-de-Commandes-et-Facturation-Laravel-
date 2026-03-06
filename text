Dans le modèle, le cast 'burgers_snapshot' => 'array' fait que Laravel sérialise/désérialise automatiquement le JSON — tu manipules un tableau PHP normal sans jamais appeler json_encode ou json_decode manuellement.

Fonctionnalités Laravel utilisées
Eloquent ORM & relations
Tu as utilisé belongsToMany pour la relation many-to-many entre Commande et burgers via la table pivot commande_burger. Le withPivot('quantite') permet d'accéder à la colonne supplémentaire de la table pivot avec $burger->pivot->quantite. Le withTimestamps() ajoute automatiquement created_at et updated_at à la table pivot.
findOrFail($id)
Au lieu de find($id) qui retourne null si l'élément n'existe pas, findOrFail lève automatiquement une exception HTTP 404. C'est la bonne pratique dans les controllers pour éviter les erreurs nulles silencieuses.
Mass assignment & $fillable
Le tableau $fillable dans chaque modèle protège contre l'injection de champs non autorisés via create() ou update(). Sans lui, Laravel bloque toute insertion par sécurité.
Casts
Le tableau $casts dans les modèles dit à Laravel comment convertir automatiquement les colonnes. 'burgers_snapshot' => 'array' convertit le JSON en tableau PHP, 'supprime_le' => 'datetime' transforme la string SQL en objet Carbon, ce qui te permet d'appeler $archive->supprime_le->format('d/m/Y H:i') directement dans la vue.
Carbon (dates)
now() retourne un objet Carbon représentant la date et heure actuelles. C'est utilisé pour remplir supprime_le au moment de l'archivage. Carbon est intégré nativement à Laravel.
redirect()->route() avec with()
redirect()->route('commandes.liste')->with('success', '...') redirige vers une route nommée et flash un message en session pour un seul affichage. Dans la vue, session('success') récupère ce message.
auth()->check() et auth()->user()
auth()->check() retourne true si un utilisateur est connecté. auth()->user()->name récupère son nom. Utilisé dans les controllers d'archivage pour savoir qui a supprimé l'élément.
detach() sur une relation pivot
Avant de supprimer une commande, $commande->burgers()->detach() supprime toutes les lignes liées dans la table commande_burger. Sans ça, tu aurais une erreur de contrainte de clé étrangère en base.
Route Model Binding vs $id manuel
Laravel permet deux approches : injecter directement l'objet dans le controller (Commande $commande) via le Route Model Binding automatique, ou récupérer manuellement avec findOrFail($id). Tu as choisi la deuxième pour garder le contrôle explicite sur la récupération.
Migrations
Chaque migration définit la structure d'une table avec Schema::create. Le type json utilisé pour burgers_snapshot est supporté nativement par MySQL/PostgreSQL et Laravel. ->useCurrent() sur un champ timestamp met automatiquement la date courante à l'insertion.
latest() et get()
BurgerArchive::latest('supprime_le')->get() récupère tous les enregistrements triés par supprime_le décroissant. latest() sans argument utilise created_at par défaut.
