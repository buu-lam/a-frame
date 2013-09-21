<?php
namespace af;

function cleanmail($mail)
{
    $mail   =   \af\noaccent($mail);
    $mail   =   \strtolower($mail);
    
    $arr    =   array(
        '([;,:!])'      =>  '.',
        '(\.+)'         =>  '.',
        '(^[.-])'       =>  '',
        '(-+)'          =>  '-',
        '([^a-z0-9]?@+[^a-z0-9]?)' =>  '@',
        '(\^)'          =>  '@',
        '(^([^@]+)alive\.fr$)'    =>  '$1@live.fr',
        '(([a-z0-9])(yahoo|yopmail|hotmail|free|gmail|wanadoo|orange))'    =>  '$1@$2',
        '(([^a-z0-9]+)(yahoo|yopmail|hotmail|free|gmail|wanadoo|orange))'    =>  '@$2',
        '(wanado\.)'    =>  'wanadoo.',
        '([@ ](orange|neuf|live|free|sfr)(([ .](fr)?)?)$)'    =>  '@$1.fr',
        '(laposte\.(ent|etn|net|nte|ten|tne)?$)'    =>  'laposte.net',
        '([\s\r\n]+)'   =>  '',
        '(\.[cxv][o0]m\.?$)'    =>  '.com',
        '(\.((l|s)?(f|ffr|fr|frr|r).?)$)'      =>  '.fr',
        '(\.g$)'    =>  '.fr',
        '([^@a-z0-9._-])'=> '',
        
    );
    
    $mail   =   \preg_replace(array_keys($arr), array_values($arr), $mail);
    
    return $mail;
}

function ismail($mail)
{
    if (strpos($mail, 'wanado.fr')) return false;
    return preg_match("/^[a-zA-Z0-9_]+(([._-]?[a-zA-Z0-9]+)*)@(([a-zA-Z0-9]+[.-]?)+)([a-zA-Z0-9]+)\.(([a-zA-Z0-9]{2})|biz|net|com|gov|mil|org|edu|int|info)$/", $mail);
}

/**
 * retourne une écriture d'un email humainement difficilement lisible, 
 * mais traitable par une machine.
 * @param string $mail
 * @return string
 */
function protectmail($mail)
{
    $protectmail = '';
    $length =   \strlen($mail);
    for($rnk = 0; $rnk < $length; $rnk++)
    {
        $protectmail .= '&#' . ord($mail{$rnk});
    }

    return $protectmail;
}
