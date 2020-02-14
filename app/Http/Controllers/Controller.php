<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\dnm_catalogos\cat\DiasFeriados;
use Carbon\Carbon;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function replaceAccents($str) {

        $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");

        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");

        return str_replace($search, $replace, $str);
    }

    public static function numAletras($num, $fem = false, $dec = true) //$num es el numero que recibe cualquiera los otros parametros no se para que son
    {
        $matuni[2] = "dos";
        $matuni[3] = "tres";
        $matuni[4] = "cuatro";
        $matuni[5] = "cinco";
        $matuni[6] = "seis";
        $matuni[7] = "siete";
        $matuni[8] = "ocho";
        $matuni[9] = "nueve";
        $matuni[10] = "diez";
        $matuni[11] = "once";
        $matuni[12] = "doce";
        $matuni[13] = "trece";
        $matuni[14] = "catorce";
        $matuni[15] = "quince";
        $matuni[16] = "diecis&eacute;is";
        $matuni[17] = "diecisiete";
        $matuni[18] = "dieciocho";
        $matuni[19] = "diecinueve";
        $matuni[20] = "veinte";
        $matunisub[2] = "dos";
        $matunisub[3] = "tres";
        $matunisub[4] = "cuatro";
        $matunisub[5] = "quin";
        $matunisub[6] = "seis";
        $matunisub[7] = "sete";
        $matunisub[8] = "ocho";
        $matunisub[9] = "nove";

        $matdec[2] = "veint";
        $matdec[3] = "treinta";
        $matdec[4] = "cuarenta";
        $matdec[5] = "cincuenta";
        $matdec[6] = "sesenta";
        $matdec[7] = "setenta";
        $matdec[8] = "ochenta";
        $matdec[9] = "noventa";
        $matsub[3] = 'mill';
        $matsub[5] = 'bill';
        $matsub[7] = 'mill';
        $matsub[9] = 'trill';
        $matsub[11] = 'mill';
        $matsub[13] = 'bill';
        $matsub[15] = 'mill';
        $matmil[4] = 'millones';
        $matmil[6] = 'billones';
        $matmil[7] = 'de billones';
        $matmil[8] = 'millones de billones';
        $matmil[10] = 'trillones';
        $matmil[11] = 'de trillones';
        $matmil[12] = 'millones de trillones';
        $matmil[13] = 'de trillones';
        $matmil[14] = 'billones de trillones';
        $matmil[15] = 'de billones de trillones';
        $matmil[16] = 'millones de billones de trillones';

        //Zi hack
        $float = explode('.', $num);
        $num = $float[0];

        $num = trim((string)@$num);
        if ($num[0] == '-') {
            $neg = 'menos ';
            $num = substr($num, 1);
        } else
            $neg = '';
        while ($num[0] == '0') $num = substr($num, 1);
        if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
        $zeros = true;
        $punt = false;
        $ent = '';
        $fra = '';
        for ($c = 0; $c < strlen($num); $c++) {
            $n = $num[$c];
            if (!(strpos(".,'''", $n) === false)) {
                if ($punt) break;
                else {
                    $punt = true;
                    continue;
                }

            } elseif (!(strpos('0123456789', $n) === false)) {
                if ($punt) {
                    if ($n != '0') $zeros = false;
                    $fra .= $n;
                } else

                    $ent .= $n;
            } else

                break;

        }
        $ent = '     ' . $ent;
        if ($dec and $fra and !$zeros) {
            $fin = ' coma';
            for ($n = 0; $n < strlen($fra); $n++) {
                if (($s = $fra[$n]) == '0')
                    $fin .= ' cero';
                elseif ($s == '1')
                    $fin .= $fem ? ' una' : ' un';
                else
                    $fin .= ' ' . $matuni[$s];
            }
        } else
            $fin = '';
        if ((int)$ent === 0) return 'Cero ' . $fin;
        $tex = '';
        $sub = 0;
        $mils = 0;
        $neutro = false;
        while (($num = substr($ent, -3)) != '   ') {
            $ent = substr($ent, 0, -3);
            if (++$sub < 3 and $fem) {
                $matuni[1] = 'una';
                $subcent = 'as';
            } else {
                $matuni[1] = $neutro ? 'un' : 'uno';
                $subcent = 'os';
            }
            $t = '';
            $n2 = substr($num, 1);
            if ($n2 == '00') {
            } elseif ($n2 < 21)
                $t = ' ' . $matuni[(int)$n2];
            elseif ($n2 < 30) {
                $n3 = $num[2];
                if ($n3 != 0) $t = 'i' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            } else {
                $n3 = $num[2];
                if ($n3 != 0) $t = ' y ' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }
            $n = $num[0];
            if ($n == 1) {
                $t = ' ciento' . $t;
            } elseif ($n == 5) {
                $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
            } elseif ($n != 0) {
                $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
            }
            if ($sub == 1) {
            } elseif (!isset($matsub[$sub])) {
                if ($num == 1) {
                    $t = ' mil';
                } elseif ($num > 1) {
                    $t .= ' mil';
                }
            } elseif ($num == 1) {
                $t .= ' ' . $matsub[$sub] . '?n';
            } elseif ($num > 1) {
                $t .= ' ' . $matsub[$sub] . 'ones';
            }
            if ($num == '000') $mils++;
            elseif ($mils != 0) {
                if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
                $mils = 0;
            }
            $neutro = true;
            $tex = $t . $tex;
        }
        $tex = $neg . substr($tex, 1) . $fin;
        //Zi hack --> return ucfirst($tex);
        //$end_num=ucfirst($tex).' '.$float[1].'/100';
        // return ucfirst($tex); ucfirst es la primera letra en mayuscula
        return $tex;
    }

    public function convertDateToText($date){
        //$h=date('H',strtotime($date));
        //$mi=date('i',strtotime($date));
        $y=date('Y',strtotime($date));
        $d=date('d',strtotime($date));
        $m=date('m',strtotime($date));

        //$hora=$this->numAletras($h);
        //$min=$this->numAletras($mi);
        $dias=$this->numAletras($d);
        $year=$this->numAletras($y);

        $meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");

        $datetext=$dias." de ".$meses[$m-1]." de ".$year;

        return $datetext;
    }
       public function convertFechaHora($date){

        $h=date('H',strtotime($date));
        $mi=date('i',strtotime($date));
        $y=date('Y',strtotime($date));
        $d=date('d',strtotime($date));
        $m=date('m',strtotime($date));

        $hora=$this->numAletras($h);
        $min=$this->numAletras($mi);
        $dias=$this->numAletras($d);
        $year=$this->numAletras($y);

        $meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");

        $datetext="a las ".$hora." horas y ".$min." minutos del día ". $dias." de ".$meses[$m-1]." de ".$year;

        return $datetext;
    }


    public function getDiasHabiles($fechaInicial,$fechaFinal){
        $anioInicial = $fechaInicial->format('Y');
        $anioFinal =$fechaFinal->format('Y');
        $anios = [];
        $anios[] = $anioInicial;
        $anios[] = $anioFinal;
        $diasFeriados = DiasFeriados::whereIn('ano',$anios)->get();

        $arrayDias = [];
        if(count($diasFeriados)>0){
          foreach ($diasFeriados as $fecha) {
                $search = ["[","]"]; //quitando esos caracteres de la columna
                $detalle = str_replace($search,"",$fecha->dia);
                $detalle = explode(",",$detalle);

            foreach ($detalle as $key => $value) {
              $mesDia = str_replace('"',"",$value);
              $arrayDias[] = Carbon::parse($fecha->ano.'-'.$mesDia)->format('Y-m-d');
            }
          }
        }

        $diasHabilesFiltrados = $fechaFinal->diffInDaysFiltered(function(Carbon $date) use ($arrayDias){
            return !$date->isWeekend() && !in_array($date->format('Y-m-d'), $arrayDias);
        }, $fechaInicial);

        return $diasHabilesFiltrados;
    }
    public function getPlazo($plazo,$diasPlazo){
    $diasPlazo = (int)$diasPlazo;
    $plazo = (int)$plazo;

    //Evitando division entre 0
    if($plazo==0)
      return 'label-default';

    $porcentaje = $diasPlazo * 100 / $plazo;

    if($porcentaje<34)
      return 'label-primary';

    if($porcentaje<67)
      return 'label-warning';

    return 'label-danger';
  }
}
