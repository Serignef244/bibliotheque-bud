<?php

return [
    'roles' => [
        'admin' => ['*'],
        'bibliothecaire' => [
            'view_dashboard',
            'manage_ouvrages',
            'manage_adherents',
            'manage_prets',
            'manage_penalites',
            'view_statistiques',
            'manage_utilisateurs',
        ],
        'adherent' => [
            'view_catalogue',
            'view_mes_prets',
            'prolonger_pret',
            'view_mes_penalites',
        ],
    ],

    'permissions' => [
        'view_dashboard',
        'manage_ouvrages',
        'manage_adherents',
        'manage_prets',
        'manage_penalites',
        'view_statistiques',
        'manage_utilisateurs',
        'manage_parametres',
        'view_logs',
        'view_catalogue',
        'view_mes_prets',
        'prolonger_pret',
        'view_mes_penalites',
    ],
];
