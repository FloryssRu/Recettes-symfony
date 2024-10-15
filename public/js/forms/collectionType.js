// Ajout d'un item dans les formulaires avec CollectionType

const newItem = (e) => {
    // On récupère ce qu'il y a dans l'attribut data-attribute de notre champ
    let collectionHolder = document.querySelector(e.currentTarget.dataset.collection);

    if (collectionHolder == null) {
        collectionHolder = document.querySelector(
            e.currentTarget.dataset.collection + e.currentTarget.dataset.number
        );
    }

    const item = document.createElement('div');
    item.classList.add('one-form-widget');

    // On met un index incrémental pour le nom du champ
    item.innerHTML += collectionHolder
        .dataset
        .prototype
        .replace(/__name__/g, collectionHolder.dataset.index)
        .replace(/_ingredients_0_/g, '_ingredients_'+ collectionHolder.dataset.index +'_')
        .replace(/\[ingredients\]\[0\]/g, '[ingredients]['+ collectionHolder.dataset.index +']')
        .replace(/_steps_0_/g, '_steps_'+ collectionHolder.dataset.index +'_')
        .replace(/\[steps\]\[0\]/g, '[steps]['+ collectionHolder.dataset.index +']')
    ;
    
    item.querySelector(".btn-remove").addEventListener('click', () => item.remove());
    collectionHolder.appendChild(item);

    document.querySelectorAll('.btn-new').forEach(btn => btn.addEventListener("click", newItem));

    collectionHolder.dataset.index++;
};

document.querySelectorAll('.btn-new').forEach(btn => btn.addEventListener("click", newItem));

// Maintenant que nos forms items sont créés,
// on ajoute un listener pour le bouton remove qui vient d'apparaitre
document.querySelectorAll('.btn-remove').forEach(
    btn => btn.addEventListener('click', (e) => e.currentTarget.closest(".form-item").remove())
);
