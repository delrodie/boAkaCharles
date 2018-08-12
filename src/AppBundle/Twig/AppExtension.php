<?php

namespace AppBundle\Twig;

use DateTime;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('duree', array($this, 'calculTemps'))
        );
    }

    public function calculTemps($publication)
    {
        $now = strtotime(date('Y-m-d h:i:s',time())) ; 
        $date_publication = strtotime($publication);

        $diff = abs($now - $date_publication); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
        $retour = array();
    
        $tmp = $diff;
        $retour['second'] = $tmp % 60; 
    
        $tmp = floor( ($tmp - $retour['second']) /60 );
        $retour['minute'] = $tmp % 60;
    
        $tmp = floor( ($tmp - $retour['minute']) /60 ); 
        $retour['hour'] = $tmp % 24;
    
        $tmp = floor( ($tmp - $retour['hour'])  /24 );
        $retour['day'] = $tmp % 30;

        $tmp = floor( ($tmp - $retour['day']) /30);
        $retour['month'] = $tmp % 12; 

        $tmp = floor ( ($tmp - $retour['month']) / 12);
        $retour['year'] = $tmp;

        if ($retour['year'] == 0) {
            if ($retour['month'] == 0) {
                if ($retour['day'] == 0){
                    if ($retour['hour'] == 0) {
                        if ($retour['minute'] == 0) {
                            return $retour['second'].' s';
                        } else {
                            return $retour['minute'].' m';
                        }                
                    }else {
                        return $retour['hour'].' h';
                    }
                }elseif ($retour['day'] == 1) {
                    return $retour['day'].' jour';
                }else {
                    return $retour ['day'].' jours';
                }
            } else {
                return $retour['month'].' mois';
            }
        } elseif ($retour['year'] == 1) {
            return $retour['year'].' an';
        }else {
            return $retour['year'].' ans';
        }
        
        
    }
    
}