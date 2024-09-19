<x-admin-layout>
    <form action="{{ route('ajouterService') }}" method="post">
        <div>
            <div>
                <label for="nomservice">Nom du service</label>
                <input type="text" name="nomservice" id="nomservice">
            </div>

            <div>
                <label for="categorieservice">Catégorie</label>
                <input type="text" name="categorieservice" id="categorieservice">
            </div>

            <div>
                <label for="descriptionservice">Description</label>
                <textarea name="descriptionservice" id="descriptionservice" cols="30" rows="10"></textarea>
            </div>

            <div>
                <label for="dureeservice">Durée</label>
                <input type="number" name="dureeservice" id="dureeservice">
            </div>

            <div>
                <label for="prixservice">Prix</label>
                <input type="number" name="prixservice" id="prixservice">
            </div>

            <input type="checkbox" name="taxableservice" id="taxableservice" value="Taxable">
        </div>

        <div>
            <input type="checkbox" name="pauserdv" id="pauserdv" value="Je veux une pause après les rendez-vous pour ce service">

            <div>
                <label for="dureepause">Durée de la pause (en minute)</label>
                <input type="number" name="dureepause" id="dureepause">
            </div>
        </div>

        <div>
            <input type="checkbox" name="rdvderniereminute" id="rdvderniereminute" value="Je veux empêcher les rendez-vous de dernière minute">

            <div>
                <label for="tempsavantrdv">Temps minimum précédant le rendez-vous pour la prise de rendez-vous en ligne (en heure)</label>
                <input type="number" name="tempsavantrdv" id="tempsavantrdv">
            </div>
        </div>

        <div>
            <input type="checkbox" name="personneacharge" id="personneacharge" value="Permettre aux clients de prendre rendez-vous pour leur enfant ou une personne à charge">
        </div>

        <div>
            <input type="submit" value="Enregistrer">
            <input type="reset" value="Annuler">
        </div>
    </form>
</x-admin-layout>
