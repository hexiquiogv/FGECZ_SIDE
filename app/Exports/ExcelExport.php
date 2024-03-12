<?php
 namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\datos_expediente\de_datosgenerales;

class ExcelExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct(string $dateS,string $dateF)
    {
        $this->dateS = $dateS;
        $this->dateF = $dateF;
        
        return $this;
    }
        
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sqlIDS=de_datosgenerales::whereBetween('created_at', [$this->dateS, $this->dateF])->pluck('id');
        $sheets = [];
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'base_carpetas');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'base_objetos');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'base_narcoticos');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'base_vehiculos');            
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'base_victimas');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'base_imputados');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'base_delitos');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'base_relacion');

            $sheets[] = new datosExpediente($sqlIDS->toArray(),'base_causasPenales');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_acumuladas');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_delitos');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_victimas');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_medidasProteccion');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_imputados');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_relacion_imputados');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_actosInvestigacion');   
            //$sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_actosConSinControl');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_audienciaInicial');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_prorrogas');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_medidasCautelares');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_acuerdosReparatorios');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_susCondicionales');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_suspension');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_etapaIntermedia');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_mediosPruebas');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_suspensionJuicio');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_pruebas');
            $sheets[] = new datosExpediente($sqlIDS->toArray(),'causas_recursos');
                     
            
        return $sheets;
    }
}