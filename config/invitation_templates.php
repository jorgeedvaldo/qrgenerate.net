<?php

/*
|--------------------------------------------------------------------------
| Invitation Templates
|--------------------------------------------------------------------------
| Every template keeps the same sections and the same content — what changes
| is the dress: palette, typeface, the floral motif drawn in the corners and
| whether the information cards are solid or sit transparent on the paper.
|
| foil / foil_light are the two stops of the metallic lettering on the names
| and the keepsake card — gold on the warm templates, the palette's own tone
| on the others.
|
| primary / accent are only the SUGGESTED colours: the builder copies them
| into the colour pickers when a template is chosen, and the couple may then
| tune them. Everything else here is applied as-is.
*/

return [

    'lilas' => [
        'label'    => ['pt' => 'Lilás', 'en' => 'Lilac'],
        'primary'  => '#7c6bab',
        'accent'   => '#4f4278',
        'paper'    => '#f7f5fb',
        'ink'      => '#2f2a3d',
        'font'     => 'cormorant',
        'foil'     => '#6d5c9c',
        'foil_light' => '#cdbfe6',
        'ornament' => 'wisteria',
        'cards'    => 'solid',
        'radius'   => '16px',
    ],

    'botanico' => [
        'label'    => ['pt' => 'Botânico', 'en' => 'Botanical'],
        'primary'  => '#8a9a7b',
        'accent'   => '#4a5a46',
        'paper'    => '#faf7ef',
        'ink'      => '#3a3a30',
        'font'     => 'cormorant',
        'foil'     => '#6f8060',
        'foil_light' => '#cfdcc0',
        'ornament' => 'botanical',
        'cards'    => 'outline',
        'radius'   => '14px',
    ],

    'classico' => [
        'label'    => ['pt' => 'Clássico', 'en' => 'Classic'],
        'primary'  => '#b08968',
        'accent'   => '#7f5539',
        'paper'    => '#fdfbf7',
        'ink'      => '#2d2825',
        'font'     => 'playfair',
        'foil'     => '#b6893e',
        'foil_light' => '#e2c78a',
        'ornament' => 'frame',
        'cards'    => 'outline',
        'radius'   => '6px',
    ],

    'romantico' => [
        'label'    => ['pt' => 'Romântico', 'en' => 'Romantic'],
        'primary'  => '#d08b94',
        'accent'   => '#96505a',
        'paper'    => '#fdf7f7',
        'ink'      => '#3b2b2e',
        'font'     => 'cormorant',
        'foil'     => '#b5707a',
        'foil_light' => '#f0c9ce',
        'ornament' => 'roses',
        'cards'    => 'solid',
        'radius'   => '18px',
    ],

    'tropical' => [
        'label'    => ['pt' => 'Tropical', 'en' => 'Tropical'],
        'primary'  => '#4f8a6d',
        'accent'   => '#2f5c49',
        'paper'    => '#f5faf6',
        'ink'      => '#23332a',
        'font'     => 'montserrat',
        'foil'     => '#3f7a5e',
        'foil_light' => '#b3dcc6',
        'ornament' => 'palm',
        'cards'    => 'outline',
        'radius'   => '14px',
    ],

    'marinho' => [
        'label'    => ['pt' => 'Marinho', 'en' => 'Navy'],
        'primary'  => '#3b5a8c',
        'accent'   => '#1f3356',
        'paper'    => '#f5f7fb',
        'ink'      => '#1d2735',
        'font'     => 'playfair',
        'foil'     => '#2f4a78',
        'foil_light' => '#b9cbe8',
        'ornament' => 'frame',
        'cards'    => 'solid',
        'radius'   => '8px',
    ],

    'terracota' => [
        'label'    => ['pt' => 'Terracota', 'en' => 'Terracotta'],
        'primary'  => '#c8714f',
        'accent'   => '#9e4a32',
        'paper'    => '#fdf6f0',
        'ink'      => '#2d2825',
        'font'     => 'cormorant',
        'foil'     => '#b05d3c',
        'foil_light' => '#f0c2a8',
        'ornament' => 'sprig',
        'cards'    => 'outline',
        'radius'   => '16px',
    ],

    'esmeralda' => [
        'label'    => ['pt' => 'Esmeralda', 'en' => 'Emerald'],
        'primary'  => '#2f6f5e',
        'accent'   => '#1b4438',
        'paper'    => '#f4f8f6',
        'ink'      => '#1f2e29',
        'font'     => 'lora',
        'foil'     => '#26604f',
        'foil_light' => '#a9d4c4',
        'ornament' => 'bough',
        'cards'    => 'solid',
        'radius'   => '12px',
    ],

    'dourado' => [
        'label'    => ['pt' => 'Dourado', 'en' => 'Gold'],
        'primary'  => '#b6893e',
        'accent'   => '#8a6224',
        'paper'    => '#fcf9f2',
        'ink'      => '#2e2821',
        'font'     => 'playfair',
        'foil'     => '#b6893e',
        'foil_light' => '#e2c78a',
        'ornament' => 'wreath',
        'cards'    => 'outline',
        'radius'   => '10px',
    ],

    'moderno' => [
        'label'    => ['pt' => 'Moderno', 'en' => 'Modern'],
        'primary'  => '#4a4440',
        'accent'   => '#2d2825',
        'paper'    => '#ffffff',
        'ink'      => '#1c1917',
        'font'     => 'montserrat',
        'foil'     => '#6b625c',
        'foil_light' => '#cfc8c2',
        'ornament' => 'none',
        'cards'    => 'outline',
        'radius'   => '2px',
    ],

];
