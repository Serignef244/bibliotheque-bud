# 📚 PROJET : GESTION DE BIBLIOTHÈQUE

## 🎯 OBJECTIF DU PROJET
Développer une application web de gestion de bibliothèque pour les bibliothèques publiques et privées.

## 📋 CONTEXTE
Ce projet est réalisé dans le cadre d'un stage pour l'obtention de la licence professionnelle en Génie Logiciel à l'Institut Supérieur d'Informatique (ISI).

## 🛠️ TECHNOLOGIES
- Backend : Laravel 11 (PHP 8.2)
- Frontend : Blade + Tailwind CSS + Alpine.js + Livewire
- Base de données : MySQL 8.0
- Authentification : Laravel Breeze
- Rôles & Permissions : Spatie/laravel-permission
- PDF : barryvdh/laravel-dompdf
- QR Code : simplesoftwareio/simple-qrcode
- Export : maatwebsite/excel
- Devise : FCFA (Franc CFA)

## 📦 MODULES À DÉVELOPPER (7 modules)

### Module 1 : Gestion des ouvrages
- CRUD ouvrages (ajout, modification, suppression, archivage)
- Gestion des catégories (arborescence)
- Gestion des exemplaires
- Génération automatique de codes-barres
- Recherche avancée (titre, auteur, ISBN, catégorie)
- Upload de couverture

### Module 2 : Gestion des adhérents
- Inscription des adhérents
- Modification et radiation
- Types d'adhérents (Étudiant, Enseignant, Externe)
- Génération carte PDF avec QR code
- Gestion des statuts (actif, suspendu, expiré, radié)
- Upload photo d'identité

### Module 3 : Gestion des prêts et retours
- Enregistrement prêt (scan code-barres)
- Enregistrement retour
- Calcul automatique date retour
- Prolongation de prêt (limité à 1 fois)
- Vérification disponibilité
- Limite d'emprunts par type d'adhérent
- Alertes retards (interface + email)

### Module 4 : Gestion des pénalités
- Calcul automatique des pénalités (FCFA/jour)
- Tarif paramétrable par type d'adhérent
- Enregistrement paiement (partiel/total)
- Historique des pénalités
- Seuil de blocage automatique

### Module 5 : Espace adhérent
- Consultation catalogue public
- Recherche en ligne
- Connexion sécurisée
- Visualisation prêts en cours
- Consultation historique personnel
- Prolongation en ligne

### Module 6 : Tableaux de bord et statistiques
- Compteurs (livres, adhérents actifs, prêts en cours)
- Graphiques (évolution prêts, top livres)
- Export Excel/CSV

### Module 7 : Administration
- Gestion des utilisateurs (CRUD)
- Gestion des rôles et permissions
- Configuration (durée prêt, tarifs, seuils)
- Logs d'activité

## 🗂️ STRUCTURE DU PROJET
bibliotheque-bud/
│
├── .env
├── .env.example
├── .editorconfig
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── vite.config.js
├── tailwind.config.js
├── phpunit.xml
├── README.md
│
├── app/
│   │
│   ├── Console/
│   │   ├── Kernel.php
│   │   └── Commands/
│   │       ├── VerifierRetards.php
│   │       ├── CalculerPenalites.php
│   │       ├── VerifierAdhesionsExpirees.php
│   │       ├── EnvoyerRappels.php
│   │       └── SauvegarderBase.php
│   │
│   ├── DTO/
│   │   ├── OuvrageDTO.php
│   │   ├── AdherentDTO.php
│   │   ├── PretDTO.php
│   │   └── PenaliteDTO.php
│   │
│   ├── Enums/
│   │   ├── RoleUtilisateur.php
│   │   ├── StatutAdherent.php
│   │   ├── StatutExemplaire.php
│   │   ├── StatutPret.php
│   │   ├── StatutPenalite.php
│   │   └── TypeNotification.php
│   │
│   ├── Events/
│   │   ├── PretEffectue.php
│   │   ├── LivreRetourne.php
│   │   ├── PenalitePayee.php
│   │   └── AdherentInscrit.php
│   │
│   ├── Exceptions/
│   │   ├── Handler.php
│   │   ├── PretNonEligibleException.php
│   │   ├── AdherentBloqueException.php
│   │   └── ExemplaireIndisponibleException.php
│   │
│   ├── Helpers/
│   │   ├── helpers.php
│   │   ├── DateHelper.php
│   │   └── MoneyHelper.php
│   │
│   ├── Http/
│   │   │
│   │   ├── Controllers/
│   │   │   │
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── PasswordResetController.php
│   │   │   │
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── OuvrageController.php
│   │   │   │   ├── CategorieController.php
│   │   │   │   ├── ExemplaireController.php
│   │   │   │   ├── AdherentController.php
│   │   │   │   ├── TypeAdherentController.php
│   │   │   │   ├── PretController.php
│   │   │   │   ├── PenaliteController.php
│   │   │   │   ├── PaiementController.php
│   │   │   │   ├── UtilisateurController.php
│   │   │   │   ├── ParametreController.php
│   │   │   │   ├── RapportController.php
│   │   │   │   └── JournalController.php
│   │   │   │
│   │   │   └── Adherent/
│   │   │       ├── TableauBordController.php
│   │   │       ├── CatalogueController.php
│   │   │       ├── PretController.php
│   │   │       ├── ProfilController.php
│   │   │       └── PenaliteController.php
│   │   │
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   ├── CheckRole.php
│   │   │   ├── JournalActivite.php
│   │   │   └── PreventBackHistory.php
│   │   │
│   │   └── Requests/
│   │       ├── OuvrageRequest.php
│   │       ├── AdherentRequest.php
│   │       ├── PretRequest.php
│   │       ├── PenaliteRequest.php
│   │       ├── PaiementRequest.php
│   │       ├── UtilisateurRequest.php
│   │       └── ParametreRequest.php
│   │
│   ├── Jobs/
│   │   ├── ExportExcel.php
│   │   ├── ExportCSV.php
│   │   ├── GenererCartePDF.php
│   │   ├── GenererCodeBarre.php
│   │   ├── GenererQRCode.php
│   │   ├── EnvoyerNotification.php
│   │   └── SauvegardeAutomatique.php
│   │
│   ├── Listeners/
│   │   ├── EnvoyerConfirmationPret.php
│   │   ├── MettreAJourDisponibilite.php
│   │   ├── CalculerPenaliteAutomatique.php
│   │   ├── EnvoyerCarteAdherent.php
│   │   └── JournaliserAction.php
│   │
│   ├── Livewire/
│   │   │
│   │   ├── Ouvrages/
│   │   │   ├── OuvrageTable.php
│   │   │   ├── OuvrageForm.php
│   │   │   ├── OuvrageSearch.php
│   │   │   └── ExemplaireManager.php
│   │   │
│   │   ├── Adherents/
│   │   │   ├── AdherentTable.php
│   │   │   ├── AdherentForm.php
│   │   │   └── AdherentSearch.php
│   │   │
│   │   ├── Prets/
│   │   │   ├── PretTable.php
│   │   │   ├── PretForm.php
│   │   │   ├── ScanCodeBarre.php
│   │   │   └── ProlongationForm.php
│   │   │
│   │   ├── Penalites/
│   │   │   ├── PenaliteTable.php
│   │   │   └── PaiementForm.php
│   │   │
│   │   ├── Dashboard/
│   │   │   ├── StatWidget.php
│   │   │   ├── GraphiqueEmprunts.php
│   │   │   ├── OuvragesPopulaires.php
│   │   │   └── AlertesRetards.php
│   │   │
│   │   └── Catalogue/
│   │       ├── CataloguePublic.php
│   │       └── RechercheAvancee.php
│   │
│   ├── Mail/
│   │   ├── RappelEcheanceMail.php
│   │   ├── RetardMail.php
│   │   ├── PenaliteMail.php
│   │   └── CarteAdherentMail.php
│   │
│   ├── Models/
│   │   ├── Utilisateur.php
│   │   ├── Ouvrage.php
│   │   ├── Categorie.php
│   │   ├── Exemplaire.php
│   │   ├── Adherent.php
│   │   ├── TypeAdherent.php
│   │   ├── Pret.php
│   │   ├── Penalite.php
│   │   ├── Paiement.php
│   │   ├── Notification.php
│   │   ├── JournalActivite.php
│   │   └── Parametre.php
│   │
│   ├── Notifications/
│   │   ├── PretEffectueNotification.php
│   │   ├── RappelEcheanceNotification.php
│   │   ├── RetardNotification.php
│   │   └── PenaliteNotification.php
│   │
│   ├── Observers/
│   │   ├── PretObserver.php
│   │   ├── AdherentObserver.php
│   │   ├── OuvrageObserver.php
│   │   └── ExemplaireObserver.php
│   │
│   ├── Policies/
│   │   ├── OuvragePolicy.php
│   │   ├── AdherentPolicy.php
│   │   ├── PretPolicy.php
│   │   ├── PenalitePolicy.php
│   │   └── UtilisateurPolicy.php
│   │
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   └── RouteServiceProvider.php
│   │
│   ├── Repositories/
│   │   ├── Interfaces/
│   │   │   ├── OuvrageRepositoryInterface.php
│   │   │   ├── AdherentRepositoryInterface.php
│   │   │   ├── PretRepositoryInterface.php
│   │   │   ├── PenaliteRepositoryInterface.php
│   │   │   └── ExemplaireRepositoryInterface.php
│   │   │
│   │   ├── OuvrageRepository.php
│   │   ├── AdherentRepository.php
│   │   ├── PretRepository.php
│   │   ├── PenaliteRepository.php
│   │   ├── ExemplaireRepository.php
│   │   └── CategorieRepository.php
│   │
│   ├── Rules/
│   │   ├── ISBNValideRule.php
│   │   ├── CodeBarreUniqueRule.php
│   │   ├── QuotaPretRule.php
│   │   └── AdherentActifRule.php
│   │
│   ├── Services/
│   │   ├── OuvrageService.php
│   │   ├── AdherentService.php
│   │   ├── PretService.php
│   │   ├── PenaliteService.php
│   │   ├── PaiementService.php
│   │   ├── CodeBarreService.php
│   │   ├── QRCodeService.php
│   │   ├── CarteAdherentService.php
│   │   ├── NotificationService.php
│   │   ├── ExportService.php
│   │   ├── RapportService.php
│   │   └── StatistiqueService.php
│   │
│   └── Traits/
│       ├── HasCodeBarre.php
│       ├── HasQRCode.php
│       └── HasJournal.php
│
├── bootstrap/
│   ├── app.php
│   └── cache/
│
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   ├── bibliotheque.php        ← barème pénalités, quotas, durées prêts
│   └── permissions.php         ← rôles et droits d'accès
│
├── database/
│   │
│   ├── factories/
│   │   ├── OuvrageFactory.php
│   │   ├── AdherentFactory.php
│   │   ├── ExemplaireFactory.php
│   │   └── PretFactory.php
│   │
│   ├── migrations/
│   │   ├── 2024_01_01_000000_create_utilisateurs_table.php
│   │   ├── 2024_01_01_000001_create_type_adherents_table.php
│   │   ├── 2024_01_01_000002_create_categories_table.php
│   │   ├── 2024_01_01_000003_create_ouvrages_table.php
│   │   ├── 2024_01_01_000004_create_exemplaires_table.php
│   │   ├── 2024_01_01_000005_create_adherents_table.php
│   │   ├── 2024_01_01_000006_create_prets_table.php
│   │   ├── 2024_01_01_000007_create_penalites_table.php
│   │   ├── 2024_01_01_000008_create_paiements_table.php
│   │   ├── 2024_01_01_000009_create_notifications_table.php
│   │   ├── 2024_01_01_000010_create_journal_activites_table.php
│   │   └── 2024_01_01_000011_create_parametres_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UtilisateurSeeder.php
│       ├── TypeAdherentSeeder.php
│       ├── CategorieSeeder.php
│       └── ParametreSeeder.php
│
├── docs/
│   ├── diagrammes/
│   │   ├── contexte.png
│   │   ├── cas-utilisation-general.png
│   │   ├── cas-utilisation-ouvrages.png
│   │   ├── cas-utilisation-prets.png
│   │   ├── cas-utilisation-adherents.png
│   │   └── diagramme-classes.png
│   │
│   ├── captures/
│   │   ├── page-accueil.png
│   │   ├── page-connexion.png
│   │   ├── tableau-bord-admin.png
│   │   ├── gestion-ouvrages.png
│   │   ├── gestion-adherents.png
│   │   ├── gestion-prets.png
│   │   └── gestion-penalites.png
│   │
│   ├── manuel-utilisateur/
│   │   ├── guide-admin.pdf
│   │   ├── guide-bibliothecaire.pdf
│   │   └── guide-adherent.pdf
│   │
│   └── api/
│       └── documentation.md
│
├── public/
│   ├── css/
│   ├── js/
│   ├── images/
│   │   └── logo-bud.png
│   ├── storage/                ← symlink → storage/app/public
│   ├── favicon.ico
│   └── index.php
│
├── resources/
│   │
│   ├── css/
│   │   └── app.css
│   │
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   │
│   ├── images/
│   │   └── logo.png
│   │
│   ├── lang/
│   │   └── fr/
│   │       ├── auth.php
│   │       ├── validation.php
│   │       └── messages.php
│   │
│   └── views/
│       │
│       ├── layouts/
│       │   ├── app.blade.php          ← layout principal
│       │   ├── admin.blade.php        ← layout admin/bibliothécaire
│       │   ├── adherent.blade.php     ← layout espace adhérent
│       │   └── guest.blade.php        ← layout pages publiques
│       │
│       ├── components/
│       │   ├── alert.blade.php
│       │   ├── badge.blade.php
│       │   ├── bouton.blade.php
│       │   ├── carte-stat.blade.php
│       │   ├── modal.blade.php
│       │   ├── pagination.blade.php
│       │   └── table-vide.blade.php
│       │
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── reset-password.blade.php
│       │
│       ├── admin/
│       │   │
│       │   ├── dashboard/
│       │   │   └── index.blade.php
│       │   │
│       │   ├── ouvrages/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── show.blade.php
│       │   │
│       │   ├── categories/
│       │   │   ├── index.blade.php
│       │   │   └── create.blade.php
│       │   │
│       │   ├── exemplaires/
│       │   │   ├── index.blade.php
│       │   │   └── codes-barres.blade.php
│       │   │
│       │   ├── adherents/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── show.blade.php
│       │   │
│       │   ├── types-adherents/
│       │   │   ├── index.blade.php
│       │   │   └── create.blade.php
│       │   │
│       │   ├── prets/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   └── show.blade.php
│       │   │
│       │   ├── penalites/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   │
│       │   ├── paiements/
│       │   │   └── index.blade.php
│       │   │
│       │   ├── utilisateurs/
│       │   │   ├── index.blade.php
│       │   │   └── create.blade.php
│       │   │
│       │   ├── parametres/
│       │   │   └── index.blade.php
│       │   │
│       │   ├── rapports/
│       │   │   └── index.blade.php
│       │   │
│       │   └── journaux/
│       │       └── index.blade.php
│       │
│       ├── adherent/
│       │   │
│       │   ├── tableau-bord/
│       │   │   └── index.blade.php
│       │   │
│       │   ├── catalogue/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   │
│       │   ├── prets/
│       │   │   ├── index.blade.php
│       │   │   └── prolongation.blade.php
│       │   │
│       │   ├── penalites/
│       │   │   └── index.blade.php
│       │   │
│       │   └── profil/
│       │       └── index.blade.php
│       │
│       ├── livewire/
│       │   │
│       │   ├── ouvrages/
│       │   │   ├── ouvrage-table.blade.php
│       │   │   ├── ouvrage-form.blade.php
│       │   │   ├── ouvrage-search.blade.php
│       │   │   └── exemplaire-manager.blade.php
│       │   │
│       │   ├── adherents/
│       │   │   ├── adherent-table.blade.php
│       │   │   ├── adherent-form.blade.php
│       │   │   └── adherent-search.blade.php
│       │   │
│       │   ├── prets/
│       │   │   ├── pret-table.blade.php
│       │   │   ├── pret-form.blade.php
│       │   │   ├── scan-code-barre.blade.php
│       │   │   └── prolongation-form.blade.php
│       │   │
│       │   ├── penalites/
│       │   │   ├── penalite-table.blade.php
│       │   │   └── paiement-form.blade.php
│       │   │
│       │   ├── dashboard/
│       │   │   ├── stat-widget.blade.php
│       │   │   ├── graphique-emprunts.blade.php
│       │   │   ├── ouvrages-populaires.blade.php
│       │   │   └── alertes-retards.blade.php
│       │   │
│       │   └── catalogue/
│       │       ├── catalogue-public.blade.php
│       │       └── recherche-avancee.blade.php
│       │
│       ├── pdf/
│       │   ├── carte-adherent.blade.php
│       │   ├── recu-paiement.blade.php
│       │   └── rapport-periode.blade.php
│       │
│       └── errors/
│           ├── 403.blade.php
│           ├── 404.blade.php
│           └── 500.blade.php
│
├── routes/
│   ├── web.php                 ← point d'entrée, inclut les autres
│   ├── admin.php               ← routes admin et bibliothécaire
│   ├── adherent.php            ← routes espace adhérent
│   ├── api.php                 ← routes API REST
│   ├── console.php             ← commandes Artisan planifiées
│   └── channels.php            ← broadcasting (temps réel)
│
├── storage/
│   │
│   ├── app/
│   │   ├── public/
│   │   │   ├── couvertures/    ← images des ouvrages
│   │   │   ├── photos/         ← photos des adhérents
│   │   │   ├── cartes/         ← cartes adhérents PDF générées
│   │   │   ├── codes-barres/   ← images codes-barres
│   │   │   └── qr-codes/       ← images QR codes
│   │   │
│   │   ├── exports/
│   │   │   ├── excel/
│   │   │   ├── csv/
│   │   │   └── pdf/
│   │   │
│   │   └── sauvegardes/
│   │
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   └── views/
│   │
│   └── logs/
│       └── laravel.log
│
├── tests/
│   │
│   ├── Feature/
│   │   ├── Auth/
│   │   │   └── LoginTest.php
│   │   ├── Ouvrages/
│   │   │   └── OuvrageTest.php
│   │   ├── Adherents/
│   │   │   └── AdherentTest.php
│   │   └── Prets/
│   │       └── PretTest.php
│   │
│   └── Unit/
│       ├── PenaliteServiceTest.php
│       ├── CodeBarreServiceTest.php
│       └── DateHelperTest.php
│
├── vendor/
│
└── node_modules/

## 📋 RÈGLES DE DÉVELOPPEMENT

1. **Toujours** utiliser les conventions Laravel (PSR-12)
2. **Toujours** utiliser les Form Requests pour la validation
3. **Toujours** implémenter les Policies pour l'autorisation
4. **Toujours** utiliser les Services pour la logique métier
5. **Toujours** utiliser les Repositories pour l'accès aux données
6. **Toujours** utiliser des DTOs pour le transfert de données
7. **Toujours** utiliser des Enums pour les statuts et types
8. **Jamais** de code métier dans les contrôleurs (utilisation des Services)
9. **Jamais** d'accès direct à la base de données dans les contrôleurs (utilisation des Repositories)
10. **Toujours** commenter les méthodes complexes (PHPDoc)

## 🔗 RELATIONS ET DÉPENDANCES
Ouvrage ──────▶ Categorie (belongsToMany)
│
└──────▶ Exemplaire (hasMany)
│
└──────▶ Pret (hasOne)
│
├──────▶ Adherent (belongsTo)
│
└──────▶ Penalite (hasOne)
│
└──────▶ Paiement (hasOne)

Adherent ──────▶ TypeAdherent (belongsTo)
│
└──────▶ Pret (hasMany)
│
└──────▶ Penalite (hasMany)

Utilisateur ──▶ Adherent (hasOne)
│
└────────▶ JournalActivite (hasMany)

## 📈 SÉQUENCE DE DÉVELOPPEMENT

1. Phase 0 : Fondations (authentification, rôles, layouts, middlewares)
2. Module 1 : Gestion des ouvrages
3. Module 2 : Gestion des adhérents
4. Module 3 : Gestion des prêts et retours
5. Module 4 : Gestion des pénalités
6. Module 5 : Espace adhérent
7. Module 6 : Tableaux de bord et statistiques
8. Module 7 : Administration

## 📝 À FAIRE AVANT DE COMMENCER

- [ ] le dépôt GitHub(https://github.com/Serignef244/bibliotheque-bud)
- [ ] Initialiser le projet Laravel
- [ ] Configurer la base de données
- [ ] Installer les packages nécessaires
- [ ] Configurer Tailwind CSS
- [ ] Créer le fichier .cursorrules
- [ ] Créer la structure de dossiers
- [ ] Commencer le développement !

