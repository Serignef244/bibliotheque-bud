<?php

namespace App\Livewire\Admin\Ouvrages;

use App\Models\Categorie;
use App\Services\ISBNService;
use Livewire\Component;

class OuvrageForm extends Component
{
    public string $searchIsbn = '';
    public ?array $resultat = null;
    public string $erreur = '';
    public bool $enRecherche = false;

    // Champs du formulaire classique qui seront pré-remplis
    public string $titre = '';
    public string $auteurs = '';
    public string $isbn = '';
    public string $editeur = '';
    public string $annee_publication = '';
    public string $nombre_pages = '';
    public string $description = '';
    public string $image_couverture_url = '';
    
    // On conserve les catégories existantes de la vue pour l'affichage
    public array $categoriesDisponibles = [];
    public array $categoriesSelectionnees = [];

    public function mount(array $categories = [])
    {
        $this->categoriesDisponibles = $categories;
        $this->isbn = old('isbn', '');
        $this->titre = old('titre', '');
        $this->auteurs = old('auteurs', '');
        $this->editeur = old('editeur', '');
        $this->annee_publication = old('annee_publication', '');
        $this->nombre_pages = old('nombre_pages', '');
        $this->description = old('description', '');
        $this->categoriesSelectionnees = old('categories', []);
        $this->image_couverture_url = old('image_couverture_url', '');
    }

    public function search()
    {
        $this->erreur = '';
        $this->resultat = null;

        if (empty(trim($this->searchIsbn))) {
            $this->erreur = 'Veuillez saisir un ISBN.';
            return;
        }

        $this->enRecherche = true;

        try {
            $isbnService = app(ISBNService::class);
            $data = $isbnService->search($this->searchIsbn, request()->ip());

            if ($data) {
                $this->resultat = $data;
            } else {
                $this->erreur = 'Aucun ouvrage trouvé pour cet ISBN.';
            }
        } catch (\Exception $e) {
            $this->erreur = 'Erreur lors de la recherche : ' . $e->getMessage();
        } finally {
            $this->enRecherche = false;
        }
    }

    public function importerData()
    {
        if (!$this->resultat) {
            return;
        }

        $this->titre = $this->resultat['titre'] ?? $this->titre;
        $this->auteurs = $this->resultat['auteur'] ?? $this->auteurs;
        $this->editeur = $this->resultat['editeur'] ?? $this->editeur;
        $this->annee_publication = $this->resultat['annee_publication'] ?? $this->annee_publication;
        $this->description = $this->resultat['description'] ?? $this->description;
        $this->nombre_pages = $this->resultat['nombre_pages'] ?? $this->nombre_pages;
        $this->isbn = $this->resultat['isbn'] ?? $this->searchIsbn;

        if (!empty($this->resultat['couverture'])) {
            $this->image_couverture_url = $this->resultat['couverture'];
        }

        // On pourrait tenter un matching pour la catégorie, 
        // mais le bibliothécaire garde le contrôle manuel comme demandé.
        
        // On ferme le panneau de résultat
        $this->resultat = null;
        $this->searchIsbn = '';
        
        $this->dispatch('data-imported');
    }

    public function ignorerData()
    {
        $this->resultat = null;
        $this->searchIsbn = '';
        $this->erreur = '';
    }

    public function render()
    {
        return view('livewire.admin.ouvrages.ouvrage-form');
    }
}
