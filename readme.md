# Cahier des Charges : Gestionnaire de Contacts PHP

### 🔹 1. Affichage (READ)
- Lister l'intégralité des contacts présents en base de données.
- **Sécurité :** Utiliser systématiquement `htmlspecialchars()` pour protéger l'affichage des données.

### 🔹 2. Ajout (CREATE)
- Mettre en place un formulaire d'insertion.
- **Validations obligatoires :**
    - Le champ **nom** ne doit pas être vide.
    - L'**email** doit être au format valide (utiliser `filter_var`).
- **Persistance :** Insertion via PDO.
- **Logique :** Utiliser des structures conditionnelles pour gérer les succès et les erreurs.

### 🔹 3. Modification (UPDATE)
- Pré-remplir le formulaire avec les données existantes du contact sélectionné.
- Appliquer les modifications en base de données.

### 🔹 4. Suppression (DELETE)
- Permettre la suppression d'un contact.
- **Sécurité :** L'action doit impérativement passer par une méthode **POST**.

### 🔹 5. Sécurité : TOKEN CSRF
- Générer un token unique stocké en session.
- Vérifier la validité du token pour chaque action de type **POST** :
    - Création
    - Mise à jour
    - Suppression

### 🔹 6. Organisation du code (Fonctions)
- **Centralisation :** Toutes les opérations (logique métier et requêtes) doivent être regroupées dans le fichier `functions.php`.

---

### ⚠️ Contraintes techniques
* **Architecture :** PHP procédural uniquement.
* **Base de données :** Utilisation de l'extension **PDO** obligatoire.
* **Sécurité SQL :** Utilisation des **requêtes préparées** systématique pour éviter les injections SQL.