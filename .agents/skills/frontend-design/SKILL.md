---
name: frontend-design
description: >-
  Use this skill when designing, building, or refining web user interfaces, UI components,
  dashboards, views, tables, forms, or navigation. Enforces modern UI/UX design principles,
  eliminates generic AI patterns, and ensures visually distinctive, accessible, and polished frontend code.
---

# Frontend Design & UI/UX Expert Skill

## 1. Philosophie et Approche "Anti-Slop"
L'objectif est d'éviter les interfaces génériques, fades ou stéréotypées ("AI slop") au profit d'un design professionnel digne des meilleurs produits SaaS modernes (Linear, Stripe, Raycast, Vercel).

* **Rejeter les clichés génériques** : Pas de héros centrés avec de simples dégradés violets sans relation avec le sujet.
* **Identité visuelle intentionnelle** : Le design doit refléter le domaine métier (ici : une bibliothèque universitaire moderne, alliant rigueur académique, clarté et modernité numérique).
* **Hiérarchie visuelle forte** : Chaque écran doit guider l'œil sans effort : point focal immédiat, données secondaires en retrait, actions principales évidentes.

---

## 2. Système Visuel & Tokens

### Typographie
* **Corps de texte & UI** : `Inter` ou `sans-serif` moderne (`font-sans`), avec un interlignage aéré (`leading-relaxed`).
* **Titres & En-têtes** : `Poppins` ou `Outfit` (`font-poppins` ou `font-semibold` / `font-bold`), pour apporter du caractère et de l'élégance.
* **Échelle stricte** :
  * `text-xs font-semibold uppercase tracking-wider` : pour les surtitres, badges et en-têtes de table.
  * `text-sm text-slate-600` : pour les descriptions et libellés.
  * `text-base text-slate-800` : pour le corps de texte.
  * `text-xl / text-2xl font-bold text-slate-900` : pour les titres de section.

### Palette de Couleurs (BiblioSmart)
* **Primaire** : `#1E3A8A` (Bleu nuit profond / confiance institutionnelle)
* **Secondaire / Accent** : `#2563EB` (Bleu royal dynamique)
* **Fond d'interface** : Fond clair doux (`bg-slate-50` ou `bg-gray-100/70`), jamais de blanc `#FFFFFF` brut uniforme partout.
* **Surfaces & Cartes** : `bg-white` avec bordures subtiles (`border border-slate-200/80`).
* **États & Badges Métier** :
  * *Disponible / Validé* : `bg-emerald-50 text-emerald-700 border-emerald-200`
  * *En cours / Prêté* : `bg-blue-50 text-blue-700 border-blue-200`
  * *En retard / Alerte* : `bg-rose-50 text-rose-700 border-rose-200`
  * *En attente / Réservé* : `bg-amber-50 text-amber-700 border-amber-200`

### Profondeur, Ombres et Glassmorphism
* **Élévation subtile** : Remplacer les ombres dures par des ombres multi-couches diffuses :
  * `shadow-sm hover:shadow-md transition-shadow duration-200`
* **Cartes modernes** : Coins arrondis généreux (`rounded-xl` ou `rounded-2xl`).
* **Effet Verre Dépoli (Glassmorphism)** sur les barres supérieures ou cartes d'accent :
  * `backdrop-blur-md bg-white/80 border border-white/40`

---

## 3. Directives par Composant

### 1. Boutons & Actions
* **Bouton Primaire** : `bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm hover:shadow active:scale-[0.98] transition-all`
* **Bouton Secondaire** : `bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all`
* **Bouton Danger** : `bg-rose-600 hover:bg-rose-700 text-white font-medium px-4 py-2.5 rounded-lg transition-all`
* **Micro-interaction** : Toujours inclure une transition d'état au survol et au clic (`active:scale-[0.98]`).

### 2. Tableaux & Listes de Données
* Ne jamais afficher un tableau brut sans pagination ou recherche.
* En-tête : `bg-slate-50/75 text-xs font-semibold text-slate-500 uppercase tracking-wider`.
* Lignes : `hover:bg-slate-50/60 transition-colors border-b border-slate-100`.
* Cellules avec espacement confortable : `px-6 py-4`.

### 3. Formulaires & Saisies
* Labels visibles avec espacement net : `block text-sm font-medium text-slate-700 mb-1.5`.
* Inputs stylisés : `rounded-lg border-slate-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all`.
* Messages d'aide et d'erreur clairs sous le champ avec icônes.

### 4. États Vides (Empty States)
* Lorsqu'une liste ou un tableau est vide, ne jamais laisser un espace blanc.
* Toujours afficher : une illustration ou icône douce (`w-12 h-12 text-slate-400 bg-slate-100 rounded-full p-2.5 mx-auto mb-3`), un titre clair ("Aucun ouvrage trouvé"), un sous-titre explicatif et un bouton d'action ("Ajouter un ouvrage").

---

## 4. Checklist de Validation UX/UI
Avant de finaliser une vue :
- [ ] La hiérarchie visuelle est-elle immédiatement évidente ?
- [ ] Les contrastes de texte sont-ils lisibles (WCAG AA) ?
- [ ] Les interactions au survol (`hover:`) et focus (`focus:`) sont-elles fluides ?
- [ ] Le layout est-il parfaitement responsive (mobile, tablette, desktop) ?
- [ ] Les états de chargement ou listes vides sont-ils élégants ?
