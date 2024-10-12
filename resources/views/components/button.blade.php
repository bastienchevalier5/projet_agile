@props(['type' => 'submit', 'color' => 'secondary', 'actionType' => null, 'entityType' => null])

@php
    // Déterminer le message de confirmation basé sur l'action et le type d'entité
    $confirmationMessage = match ($actionType) {
        'modify' => match ($entityType) {
            'motif' => 'Êtes-vous sûr de vouloir modifier ce motif ?',
            'absence' => 'Êtes-vous sûr de vouloir modifier cette absence ?',
            'user' => 'Êtes-vous sûr de vouloir modifier cet utilisateur ?',
            default => 'Êtes-vous sûr de vouloir modifier cet élément ?',
        },
        'delete' => match ($entityType) {
            'motif' => 'Êtes-vous sûr de vouloir supprimer ce motif ?',
            'absence' => 'Êtes-vous sûr de vouloir supprimer cette absence ?',
            'user' => 'Êtes-vous sûr de vouloir supprimer cet utilisateur ?',
            default => 'Êtes-vous sûr de vouloir supprimer cet élément ?',
        },
        'add' => match ($entityType) {
            'motif' => 'Êtes-vous sûr de vouloir ajouter ce motif ?',
            'absence' => 'Êtes-vous sûr de vouloir ajouter cette absence ?',
            'user' => 'Êtes-vous sûr de vouloir ajouter cet utilisateur ?',
            default => 'Êtes-vous sûr de vouloir ajouter cet élément ?',
        },
        default => 'Êtes-vous sûr de vouloir procéder ?',
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "mb-5 btn btn-$color", 'onclick' => "return confirm('$confirmationMessage');"]) }}>
    {{ $slot }}
</button>
