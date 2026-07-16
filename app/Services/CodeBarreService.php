<?php

namespace App\Services;

/**
 * Service de génération de codes-barres Code128 en SVG (sans dépendance externe).
 * Utilise l'algorithme Code128B pour les codes alphanumériques.
 */
class CodeBarreService
{
    // Table des codes Code128 B (valeur → pattern binaire sur 11 bits)
    private const CODE128B = [
        ' '=>'11011001100','!'=>'11001101100','"'=>'11001100110','#'=>'10010011000',
        '$'=>'10010001100','%'=>'10001001100','&'=>'10011001000','\''=>'10011000100',
        '('=>'10001100100',')'=>'11001001000','*'=>'11001000100','+'=>'11000100100',
        ','=>'10110011100','-'=>'10011011100','.'=>'10011001110','/'=>'10111001100',
        '0'=>'10011101100','1'=>'10011100110','2'=>'11001110010','3'=>'11001011100',
        '4'=>'11001001110','5'=>'11011100100','6'=>'11001110100','7'=>'11101101110',
        '8'=>'11101001100','9'=>'11100101100','A'=>'11100100110','B'=>'11101100100',
        'C'=>'11100110100','D'=>'11100110010','E'=>'11011011000','F'=>'11011000110',
        'G'=>'11000110110','H'=>'10100011000','I'=>'10001011000','J'=>'10001000110',
        'K'=>'10011000010','L'=>'10000110100','M'=>'10000110010','N'=>'11000010010',
        'O'=>'11001010000','P'=>'11110111010','Q'=>'11000010100','R'=>'10001111010',
        'S'=>'10100111100','T'=>'10010111100','U'=>'10010011110','V'=>'10111100100',
        'W'=>'10011110100','X'=>'10011110010','Y'=>'11110100100','Z'=>'11110010100',
        '-'=>'11110010010',
    ];

    /**
     * Génère un SVG de code-barres Code128 pour la chaîne donnée.
     */
    public function genererSvg(string $code, int $hauteur = 60, int $largeurBarre = 2): string
    {
        $barres = $this->encoder($code);
        $largeurTotale = strlen($barres) * $largeurBarre + 20;

        $svg  = '<svg xmlns="http://www.w3.org/2000/svg" ';
        $svg .= "width=\"{$largeurTotale}\" height=\"" . ($hauteur + 20) . '">';
        $svg .= '<rect width="100%" height="100%" fill="white"/>';

        $x = 10;
        foreach (str_split($barres) as $bit) {
            if ($bit === '1') {
                $svg .= "<rect x=\"{$x}\" y=\"5\" width=\"{$largeurBarre}\" height=\"{$hauteur}\" fill=\"black\"/>";
            }
            $x += $largeurBarre;
        }

        // Texte sous le code-barres
        $centreX = $largeurTotale / 2;
        $textY   = $hauteur + 16;
        $svg .= "<text x=\"{$centreX}\" y=\"{$textY}\" ";
        $svg .= 'text-anchor="middle" font-family="monospace" font-size="10" fill="black">';
        $svg .= htmlspecialchars($code) . '</text>';
        $svg .= '</svg>';

        return $svg;
    }

    /**
     * Encode la chaîne en séquence binaire Code128B.
     */
    private function encoder(string $code): string
    {
        $code = strtoupper($code);
        // START B = 104
        $bits = '11010010000';

        $somme = 104;
        foreach (str_split($code) as $i => $char) {
            $valeur = ord($char) - 32;
            $somme += ($i + 1) * $valeur;
            $pattern = self::CODE128B[$char] ?? self::CODE128B[' '];
            $bits .= $pattern;
        }

        // Checksum
        $checkVal = $somme % 103;
        // On mappe le checkVal vers le pattern (simplification : utiliser espace → Z plage)
        $checkChar = chr($checkVal + 32);
        $bits .= self::CODE128B[$checkChar] ?? '11011001100';

        // STOP
        $bits .= '1100011101011';

        return $bits;
    }
}
