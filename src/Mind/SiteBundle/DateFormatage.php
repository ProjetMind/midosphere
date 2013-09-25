<?php

namespace Mind\SiteBundle;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateFormatage
 *
 * @author root
 */
class DateFormatage {
    
    public $lesMoments = array('y', 'm', 'd', 'h', 'i', 's');


    public function getDate($dateDePublication){
     
        //print_r($dateDePublication);
        //Om met le format de la date en français
        $dateCourante                   = new \DateTime();
        $dateIntervale                  = date_diff($dateDePublication, $dateCourante);
        $dateArrayFormater['message']   = $this->getMessage($dateIntervale);
        $dateArrayFormater['dateFr']    = date_format($dateDePublication, "d-m-y h-i-s");
        $dateDePublication              = get_object_vars($dateDePublication);
        $dateArrayFormater['datePub']   = $dateDePublication['date'];
        
        return $dateArrayFormater;
        
    }
    
    protected function getMessage($dateIntervale){
        
        $intervaleMinimum = 0;
        $message ="";
        $lesMoments = $this->lesMoments;
        $differenceIndice = 0;
        $dateIntervale = get_object_vars($dateIntervale);
        
        while ($intervaleMinimum == 0 and $differenceIndice < 6){
            
            $intervaleMinimum = $dateIntervale[$lesMoments[$differenceIndice]];
            if(!$intervaleMinimum != 0){
                $differenceIndice++;
            }
            
        }
        $debutMessage = "il y'a ";
        
        switch ($differenceIndice){
            
            
            case 0: 
                $message = " an(s).";
                break;
            
            case 1:
                $message = " mois";
                break;
            
            case 2:
                $message = " jour(s)";
                break;
            
            case 3:
                $message = " heure(s)";
                break;
            
            case 4:
                $message = " minute(s)";
                break;
            
            case 5:
                $message = " seconde(s)";
                break;
            
        }
        
        return $debutMessage.$intervaleMinimum.$message;
    }
    
    
    
}

?>
