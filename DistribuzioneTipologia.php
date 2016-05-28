<?php

require('BasicEnum.php');

abstract class Tipologia extends BasicEnum
{
    const NonDefinito = 0;
    const Fattura = 1;
    const ContoDeposito = 2;
    const Ricevuta = 3;
}

class DistribuzioneTipologia
{
    public $tipologia;

    public function __construct($tipo) {
        if (is_a($tipo, 'Tipologia')) 
        {
            if (Tipologia::isValidValue($tipo)) {
                switch ($tipo) {
                    case Tipologia::NonDefinito:
                        $this->tipologia = Tipologia::NonDefinito;
                        break;
                    case Tipologia::Fattura:
                        $this->tipologia = Tipologia::Fattura;
                        break;
                    case Tipologia::ContoDeposito:
                        $this->tipologia = Tipologia::ContoDeposito;
                        break;
                    case Tipologia::Ricevuta:
                        $this->tipologia = Tipologia::Ricevuta;
                        break;
                }
            } else {
                $this->tipologia = Tipologia::NonDefinito;
            }
        }
        else
        {
            switch ($tipo) {
                    case 0:
                        $this->tipologia = Tipologia::NonDefinito;
                        break;
                    case 1:
                        $this->tipologia = Tipologia::Fattura;
                        break;
                    case 2:
                        $this->tipologia = Tipologia::ContoDeposito;
                        break;
                    case 3:
                        $this->tipologia = Tipologia::Ricevuta;
                        break;
                }
        }
    }

    public function GetTipologia() {
        switch ($this->tipologia) {
            case Tipologia::NonDefinito:
                return "Non definito";
                break;
            case Tipologia::Fattura:
                return "Fattura";
                break;
            case Tipologia::ContoDeposito:
                return "Conto deposito";
                break;
            case Tipologia::Ricevuta:
                return "Ricevuta";
                break;
        }
    }
    
    public function GetCodice() {
        switch ($this->tipologia) {
            case Tipologia::NonDefinito:
                return "ND";
                break;
            case Tipologia::Fattura:
                return "FE";
                break;
            case Tipologia::ContoDeposito:
                return "CD";
                break;
            case Tipologia::Ricevuta:
                return "RI";
                break;
        }
    }
    
    public function GetTipologiaNumero() {
        switch ($this->tipologia) {
            case Tipologia::NonDefinito:
                return 0;
                break;
            case Tipologia::Fattura:
                return 1;
                break;
            case Tipologia::ContoDeposito:
                return 2;
                break;
            case Tipologia::Ricevuta:
                return 3;
                break;
        }
    }
    
    
}