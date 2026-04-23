<?php

namespace App\Exports;

use App\Models\tb_ejecucion;
use App\Models\tb_ejecucion_mes;
use App\Models\tb_meta_mef;
use App\Models\tb_formato12b;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Carbon\Carbon;

class ReportediarioExport implements WithEvents,WithColumnWidths,WithTitle,WithDrawings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use RegistersEventListeners;
    protected $anio;
    protected $rows_total;
    protected $fecha;
    protected $dias_total;
    protected $meses;
    protected $mes;
    protected $data;
    protected $data_mes;
    protected $data_mef;
    protected $data_f12b;
    protected $data_ejecucion;
    protected $data_dia_inversion;
    protected $data_dia_inversion_hoy;

    public function __construct($anio)
    {
        // dd($anio);
        $this->anio = $anio;
        $this->rows_total = 0;
        $this->fecha = date("Y-m-d");
        $fecha_actual = Carbon::now();
        $fecha_actual->subDay();
        $mes =  $fecha_actual->format('m') - 1;
        $this->dias_total = date('t');
        $meses_array = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']; 
        $mes_mef = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre']; 
        $mes_f12b = ['a_enero','a_febrero','a_marzo','a_abril','a_mayo','a_junio','a_julio','a_agosto','a_setiembre','a_octubre','a_noviembre','a_diciembre']; 
        $this->meses = $meses_array[$mes];
        $this->mes = $mes;
        // Data
        $data = tb_ejecucion::select(DB::raw("sum(pim_dia) as pim_dia,sum(dev_dia) as dev_dia , sum(pim_dia) - sum(dev_dia) as pen_dev,
                case when sum(pim_dia) != 0 then round(sum(dev_dia)/sum(pim_dia)*100,2) else 0 end as avance"))
                ->whereRaw("fecha = (select max(fecha) from tb_ejecucion where anio=?)", $this->anio)
                ->where("anio","=",$this->anio)
                ->first();
        
        $data_mef_mes = tb_meta_mef::select(DB::raw("case when sum(".$mes_mef[$mes].") is null then 0 else sum(".$mes_mef[$mes].") end as programacion"))
                ->whereRaw("fecha = (select max(fecha) from tb_meta_mef where anio=?)", $this->anio)
                ->where("anio","=",$this->anio)
                ->first();

        $data_f12b_mes = tb_formato12b::select(DB::raw("case when sum(".$mes_f12b[$mes].") is null then 0 else sum(".$mes_f12b[$mes].") end as programacion"))
                ->whereRaw("fecha = (select max(fecha) from tb_formato12b where anio=?)", $this->anio)
                ->where("anio","=",$this->anio)
                ->first();

        $data_ejec_mes = tb_ejecucion_mes::select(DB::raw(" case when sum(".$mes_mef[$mes].") is null then 0 else sum(".$mes_mef[$mes].") end as ejecucion"))
                ->whereRaw("fecha = (select max(fecha) from tb_ejecucion_mes where anio=?)", $this->anio)
                ->where("anio","=",$this->anio)
                ->first();

        $data_mef = tb_meta_mef::select(DB::raw("case when sum(enero) is null then 0 else sum(enero) end as enero,case when sum(febrero) is null then 0 else sum(febrero) end as febrero,
                case when sum(marzo) is null then 0 else sum(marzo) end as marzo,case when sum(abril) is null then 0 else sum(abril) end as abril,
                case when sum(mayo) is null then 0 else sum(mayo) end as mayo,case when sum(junio) is null then 0 else sum(junio) end as junio,
                case when sum(julio) is null then 0 else sum(julio) end as julio,case when sum(agosto) is null then 0 else sum(agosto) end as agosto,
                case when sum(septiembre) is null then 0 else sum(septiembre) end as septiembre,case when sum(octubre) is null then 0 else sum(octubre) end as octubre,
                case when sum(noviembre) is null then 0 else sum(noviembre) end as noviembre,case when sum(diciembre) is null then 0 else sum(diciembre) end as diciembre"))
                ->whereRaw("fecha = (select max(fecha) from tb_meta_mef where anio=?)", $this->anio)
                ->where("anio","=",$this->anio)
                ->first();
        
        $data_f12b = tb_formato12b::select(DB::raw("case when sum(a_enero) is null then 0 else sum(a_enero) end as enero,case when sum(a_febrero) is null then 0 else sum(a_febrero) end as febrero,
                case when sum(a_marzo) is null then 0 else sum(a_marzo) end as marzo,case when sum(a_abril) is null then 0 else sum(a_abril) end as abril,
                case when sum(a_mayo) is null then 0 else sum(a_mayo) end as mayo,case when sum(a_junio) is null then 0 else sum(a_junio) end as junio,
                case when sum(a_julio) is null then 0 else sum(a_julio) end as julio,case when sum(a_agosto) is null then 0 else sum(a_agosto) end as agosto,
                case when sum(a_setiembre) is null then 0 else sum(a_setiembre) end as septiembre,case when sum(a_octubre) is null then 0 else sum(a_octubre) end as octubre,
                case when sum(a_noviembre) is null then 0 else sum(a_noviembre) end as noviembre,case when sum(a_diciembre) is null then 0 else sum(a_diciembre) end as diciembre"))
                ->whereRaw("fecha = (select max(fecha) from tb_formato12b where anio=?)", $this->anio)
                ->where("anio","=",$this->anio)
                ->first();
        
        $data_ejecucion = tb_ejecucion_mes::select(DB::raw("case when sum(enero) is null then 0 else sum(enero) end as enero,case when sum(febrero) is null then 0 else sum(febrero) end as febrero,
                case when sum(marzo) is null then 0 else sum(marzo) end as marzo,case when sum(abril) is null then 0 else sum(abril) end as abril,
                case when sum(mayo) is null then 0 else sum(mayo) end as mayo,case when sum(junio) is null then 0 else sum(junio) end as junio,
                case when sum(julio) is null then 0 else sum(julio) end as julio,case when sum(agosto) is null then 0 else sum(agosto) end as agosto,
                case when sum(septiembre) is null then 0 else sum(septiembre) end as septiembre,case when sum(octubre) is null then 0 else sum(octubre) end as octubre,
                case when sum(noviembre) is null then 0 else sum(noviembre) end as noviembre,case when sum(diciembre) is null then 0 else sum(diciembre) end as diciembre"))
                ->whereRaw("fecha = (select max(fecha) from tb_ejecucion_mes where anio=?)", $this->anio)
                ->where("anio","=",$this->anio)
                ->first();
        
        $data_dia_inversion_hoy = DB::table("vw_inversiones_diario")->select()->where('fecha',DB::RAW("(select max(fecha) from vw_inversiones_diario)"))->orderBy("meta_mes","desc")->orderBy("dev_mes","desc")->get();
            
        $data_dia_inversion = DB::table("vw_inversiones_diario")->select()->get();
        
        $this->data = $data;
        $this->data_mes = (object) [
            "programacion" => $data_f12b_mes->programacion,
            "ejecucion" => $data_ejec_mes->ejecucion,
            "pen_ejec" => $data_f12b_mes->programacion - $data_ejec_mes->ejecucion,
            "avance" => $data_f12b_mes->programacion != 0 ? round($data_ejec_mes->ejecucion/$data_f12b_mes->programacion*100,2) : 0
        ];
        $this->data_mef = $data_mef;
        $this->data_f12b = $data_f12b;
        $this->data_ejecucion = $data_ejecucion;
        $this->data_dia_inversion = $data_dia_inversion;
        $this->data_dia_inversion_hoy = $data_dia_inversion_hoy;
    }
    
    public function title(): string
    {
        return 'REPORTE DIARIO';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,
            'C' => 34,
            'D' => 34,
            'E' => 36,
            'F' => 28,
            'G' => 34,
            'H' => 34,
            'I' => 34,
            'J' => 34,
            'K' => 34,
            'L' => 34,            
            'M' => 34,
            'N' => 34
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('/imagenes/png/icono.png'));
        $drawing->setHeight(210);
        $drawing->setCoordinates('A3');

        return $drawing;
    }

    public static function afterSheet(AfterSheet $event) 
    {
        //VARIABLES
        $data = $event->getConcernable()->data;
        $data_mes = $event->getConcernable()->data_mes;
        $fecha = $event->getConcernable()->fecha;
        $anio = $event->getConcernable()->anio;
        $mes = $event->getConcernable()->mes;
        $meses = $event->getConcernable()->meses;
        $dias_total = $event->getConcernable()->dias_total;
        $data_mef = $event->getConcernable()->data_mef;
        $data_f12b = $event->getConcernable()->data_f12b;
        $data_ejecucion = $event->getConcernable()->data_ejecucion;
        $data_dia_inversion = $event->getConcernable()->data_dia_inversion;
        $data_dia_inversion_hoy = $event->getConcernable()->data_dia_inversion_hoy;

        $event->sheet->getDelegate()->mergeCells('A1:N1');
        $event->sheet->getDelegate()->mergeCells('A2:N2');


        // TAMAÑO DE FILAS
        $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('3')->setRowHeight(93);
        $event->sheet->getDelegate()->getRowDimension('4')->setRowHeight(93);
        $event->sheet->getDelegate()->getRowDimension('5')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('6')->setRowHeight(61);
        $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('8')->setRowHeight(64);
        $event->sheet->getDelegate()->getRowDimension('9')->setRowHeight(55);
        $event->sheet->getDelegate()->getRowDimension('10')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('11')->setRowHeight(61);
        $event->sheet->getDelegate()->getRowDimension('12')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('13')->setRowHeight(64);
        $event->sheet->getDelegate()->getRowDimension('14')->setRowHeight(55);
        $event->sheet->getDelegate()->getRowDimension('15')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('16')->setRowHeight(61);
        $event->sheet->getDelegate()->getRowDimension('17')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('18')->setRowHeight(31);
        $event->sheet->getDelegate()->getRowDimension('19')->setRowHeight(31);
        $event->sheet->getDelegate()->getRowDimension('20')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('23')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('26')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('29')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('31')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('32')->setRowHeight(26);
        $event->sheet->getDelegate()->getRowDimension('35')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('37')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('38')->setRowHeight(26);
        $event->sheet->getDelegate()->getRowDimension('39')->setRowHeight(26);

        $event->sheet->getDelegate()->setCellValue('C3',"ACTUALIZADO AL");
        $event->sheet->getDelegate()->mergeCells('C3:D3');
        $event->sheet->getDelegate()->getStyle('C3:D3')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 26],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('C4',$fecha);
        $event->sheet->getDelegate()->mergeCells('C4:D4');
        $event->sheet->getDelegate()->getStyle('C4:D4')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 26],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                // 'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('F3',"SEGUIMIENTO DE INVERSIONES " . $anio);
        $event->sheet->getDelegate()->mergeCells('F3:N4');
        $event->sheet->getDelegate()->getStyle('F3:N4')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 72],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
            ]
        );
        $event->sheet->getDelegate()->mergeCells('A5:N5');
        
        // INICIO DE RESUMEN GLOBAL
        $event->sheet->getDelegate()->setCellValue('A6',"RESUMEN MUNICIPALIDAD DE HUARAL");
        $event->sheet->getDelegate()->mergeCells('A6:N6');
        $event->sheet->getDelegate()->getStyle('A6:N6')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 48],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );

        $event->sheet->getDelegate()->mergeCells('A7:N7');
        $event->sheet->getDelegate()->setCellValue('C8',"PIM");
        $event->sheet->getDelegate()->mergeCells('C8:D8');
        $event->sheet->getDelegate()->getStyle('C8:D8')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 24],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('C9',$data->pim_dia,2);
        $event->sheet->getDelegate()->getStyle('C9')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->mergeCells('C9:D9');
        $event->sheet->getDelegate()->getStyle('C9:D9')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 28],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );

        $event->sheet->getDelegate()->setCellValue('F8',"DEVENGADO ACTUAL");
        $event->sheet->getDelegate()->mergeCells('F8:G8');
        $event->sheet->getDelegate()->getStyle('F8:G8')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 24],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('F9',$data->dev_dia,2);
        $event->sheet->getDelegate()->getStyle('F9')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->mergeCells('F9:G9');
        $event->sheet->getDelegate()->getStyle('F9:G9')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 28],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );

        $event->sheet->getDelegate()->setCellValue('I8',"PENDIENTE DEVENGADO A 31 DICIEMBRE");
        $event->sheet->getDelegate()->mergeCells('I8:J8');
        $event->sheet->getDelegate()->getStyle('I8:J8')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 24],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('I9',$data->pen_dev,2);
        $event->sheet->getDelegate()->getStyle('I9')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->mergeCells('I9:J9');
        $event->sheet->getDelegate()->getStyle('I9:J9')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 28],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );

        $event->sheet->getDelegate()->setCellValue('L8',"AVANCE(%)");
        $event->sheet->getDelegate()->mergeCells('L8:M8');
        $event->sheet->getDelegate()->getStyle('L8:M8')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 24],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('L9',$data->avance,2);
        $event->sheet->getDelegate()->getStyle('L9')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_0);
        $event->sheet->getDelegate()->mergeCells('L9:M9');
        $event->sheet->getDelegate()->getStyle('L9:M9')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 28],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->mergeCells('A10:N10');
        // FIN DE RESUMEN GLOBAL

        // INICIO DE RESUMEN MENSUAL
        $event->sheet->getDelegate()->setCellValue('A11',"RESUMEN MUNICIPALIDAD DE HUARAL PARA EL MES DE ". strtoupper($meses) . " - FORMATO N° 12-B");
        $event->sheet->getDelegate()->mergeCells('A11:N11');
        $event->sheet->getDelegate()->getStyle('A11:N11')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 48],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );

        $event->sheet->getDelegate()->mergeCells('A12:N12');
        $event->sheet->getDelegate()->setCellValue('C13',"PROGRAMACION");
        $event->sheet->getDelegate()->mergeCells('C13:D13');
        $event->sheet->getDelegate()->getStyle('C13:D13')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 24],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('C14',$data_mes->programacion,2);
        $event->sheet->getDelegate()->getStyle('C14')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->mergeCells('C14:D14');
        $event->sheet->getDelegate()->getStyle('C14:D14')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 28],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );

        $event->sheet->getDelegate()->setCellValue('F13',"EJECUCION");
        $event->sheet->getDelegate()->mergeCells('F13:G13');
        $event->sheet->getDelegate()->getStyle('F13:G13')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 24],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('F14',$data_mes->ejecucion,2);
        $event->sheet->getDelegate()->getStyle('F14')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->mergeCells('F14:G14');
        $event->sheet->getDelegate()->getStyle('F14:G14')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 28],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );

        $event->sheet->getDelegate()->setCellValue('I13',"PENDIENTE DEVENGADO A " . $dias_total . " " .strtoupper($meses));
        $event->sheet->getDelegate()->mergeCells('I13:J13');
        $event->sheet->getDelegate()->getStyle('I13:J13')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 24],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('I14',$data_mes->pen_ejec,2);
        $event->sheet->getDelegate()->getStyle('I14')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->mergeCells('I14:J14');
        $event->sheet->getDelegate()->getStyle('I14:J14')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 28],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );

        $event->sheet->getDelegate()->setCellValue('L13',"AVANCE(%)");
        $event->sheet->getDelegate()->mergeCells('L13:M13');
        $event->sheet->getDelegate()->getStyle('L13:M13')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 24],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('L14',$data_mes->avance,2);
        $event->sheet->getDelegate()->getStyle('L14')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_0);
        $event->sheet->getDelegate()->mergeCells('L14:M14');
        $event->sheet->getDelegate()->getStyle('L14:M14')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 28],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->mergeCells('A15:N15');
        // FIN DE RESUMEN MENSUAL
        $event->sheet->getDelegate()->setCellValue('A16',"HISTORIAL DE DEVENGADOS Y PROGRAMACION SEGUN FORMATO N° 12-B");
        $event->sheet->getDelegate()->mergeCells('A16:N16');
        $event->sheet->getDelegate()->getStyle('A16:N16')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 48],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        // Enero
        $event->sheet->getDelegate()->mergeCells('A17:N17');
        $event->sheet->getDelegate()->setCellValue('C18',"ENERO");
        $event->sheet->getDelegate()->mergeCells('C18:C19');
        $event->sheet->getDelegate()->getStyle('C18:C19')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('D18',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('D19',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('E18',$data_ejecucion->enero);
        $event->sheet->getDelegate()->setCellValue('E19',$data_f12b->enero);
        $event->sheet->getDelegate()->getStyle('E18:E19')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('D18:E19')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        // Febrero
        $event->sheet->getDelegate()->setCellValue('G18',"FEBRERO");
        $event->sheet->getDelegate()->mergeCells('G18:G19');
        $event->sheet->getDelegate()->getStyle('G18:G19')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('H18',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('H19',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('I18',$data_ejecucion->febrero);
        $event->sheet->getDelegate()->setCellValue('I19',$data_f12b->febrero);
        $event->sheet->getDelegate()->getStyle('I18:I19')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('H18:I19')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        // Marzo
        $event->sheet->getDelegate()->setCellValue('K18',"MARZO");
        $event->sheet->getDelegate()->mergeCells('K18:K19');
        $event->sheet->getDelegate()->getStyle('K18:K19')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('L18',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('L19',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('M18',$data_ejecucion->marzo);
        $event->sheet->getDelegate()->setCellValue('M19',$data_f12b->marzo);
        $event->sheet->getDelegate()->getStyle('M18:M19')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('L18:M19')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->mergeCells('A20:N20');
        // Abril
        $event->sheet->getDelegate()->setCellValue('C21',"ABRIL");
        $event->sheet->getDelegate()->mergeCells('C21:C22');
        $event->sheet->getDelegate()->getStyle('C21:C22')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('D21',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('D22',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('E21',$data_ejecucion->abril);
        $event->sheet->getDelegate()->setCellValue('E22',$data_f12b->abril);
        $event->sheet->getDelegate()->getStyle('E21:E22')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('D21:E22')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        // Mayo
        $event->sheet->getDelegate()->setCellValue('G21',"MAYO");
        $event->sheet->getDelegate()->mergeCells('G21:G22');
        $event->sheet->getDelegate()->getStyle('G21:G22')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('H21',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('H22',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('I21',$data_ejecucion->mayo);
        $event->sheet->getDelegate()->setCellValue('I22',$data_f12b->mayo);
        $event->sheet->getDelegate()->getStyle('I21:I22')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('H21:I22')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        // Junio
        $event->sheet->getDelegate()->setCellValue('K21',"JUNIO");
        $event->sheet->getDelegate()->mergeCells('K21:K22');
        $event->sheet->getDelegate()->getStyle('K21:K22')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('L21',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('L22',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('M21',$data_ejecucion->junio);
        $event->sheet->getDelegate()->setCellValue('M22',$data_f12b->junio);
        $event->sheet->getDelegate()->getStyle('M21:M22')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('L21:M22')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->mergeCells('A23:N23');
        // Julio
        $event->sheet->getDelegate()->setCellValue('C24',"JULIO");
        $event->sheet->getDelegate()->mergeCells('C24:C25');
        $event->sheet->getDelegate()->getStyle('C24:C25')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('D24',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('D25',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('E24',$data_ejecucion->julio);
        $event->sheet->getDelegate()->setCellValue('E25',$data_f12b->julio);
        $event->sheet->getDelegate()->getStyle('E24:E25')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('D24:E25')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        // Agosto
        $event->sheet->getDelegate()->setCellValue('G24',"AGOSTO");
        $event->sheet->getDelegate()->mergeCells('G24:G25');
        $event->sheet->getDelegate()->getStyle('G24:G25')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('H24',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('H25',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('I24',$data_ejecucion->agosto);
        $event->sheet->getDelegate()->setCellValue('I25',$data_f12b->agosto);
        $event->sheet->getDelegate()->getStyle('I24:I25')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('H24:I25')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        // Septiembre
        $event->sheet->getDelegate()->setCellValue('K24',"SEPTIEMBRE");
        $event->sheet->getDelegate()->mergeCells('K24:K25');
        $event->sheet->getDelegate()->getStyle('K24:K25')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('L24',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('L25',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('M24',$data_ejecucion->septiembre);
        $event->sheet->getDelegate()->setCellValue('M25',$data_f12b->septiembre);
        $event->sheet->getDelegate()->getStyle('M24:M25')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('L24:M25')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->mergeCells('A26:N26');
        // Octubre
        $event->sheet->getDelegate()->setCellValue('C27',"OCTUBRE");
        $event->sheet->getDelegate()->mergeCells('C27:C28');
        $event->sheet->getDelegate()->getStyle('C27:C28')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('D27',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('D28',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('E27',$data_ejecucion->octubre);
        $event->sheet->getDelegate()->setCellValue('E28',$data_f12b->octubre);
        $event->sheet->getDelegate()->getStyle('E27:E28')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('D27:E28')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        // Noviembre
        $event->sheet->getDelegate()->setCellValue('G27',"NOVIEMBRE");
        $event->sheet->getDelegate()->mergeCells('G27:G28');
        $event->sheet->getDelegate()->getStyle('G27:G28')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('H27',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('H28',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('I27',$data_ejecucion->noviembre);
        $event->sheet->getDelegate()->setCellValue('I28',$data_f12b->noviembre);
        $event->sheet->getDelegate()->getStyle('I27:I28')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('H27:I28')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        // Diciembre
        $event->sheet->getDelegate()->setCellValue('K27',"DICIEMBRE");
        $event->sheet->getDelegate()->mergeCells('K27:K28');
        $event->sheet->getDelegate()->getStyle('K27:K28')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'DEDDDD']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('L27',"DEVENGADO");
        $event->sheet->getDelegate()->setCellValue('L28',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('M27',$data_ejecucion->diciembre);
        $event->sheet->getDelegate()->setCellValue('M28',$data_f12b->diciembre);
        $event->sheet->getDelegate()->getStyle('M27:M28')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->getStyle('L27:M28')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 22],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->mergeCells('A29:N29');
        // FIN HISTORIAL DEVENGADO Y MEF
        $event->sheet->getDelegate()->setCellValue('A30',"PROGRAMACION (MEF vs FORMATO 12-B)");
        $event->sheet->getDelegate()->mergeCells('A30:N30');
        $event->sheet->getDelegate()->getStyle('A30:N30')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 48],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->mergeCells('A31:N31');
        $event->sheet->getDelegate()->setCellValue('B32',"ENERO");
        $event->sheet->getDelegate()->setCellValue('C32',"FEBRERO");
        $event->sheet->getDelegate()->setCellValue('D32',"MARZO");
        $event->sheet->getDelegate()->setCellValue('E32',"ABRIL");
        $event->sheet->getDelegate()->setCellValue('F32',"MAYO");
        $event->sheet->getDelegate()->setCellValue('G32',"JUNIO");
        $event->sheet->getDelegate()->setCellValue('H32',"JULIO");
        $event->sheet->getDelegate()->setCellValue('I32',"AGOSTO");
        $event->sheet->getDelegate()->setCellValue('J32',"SEPTIEMBRE");
        $event->sheet->getDelegate()->setCellValue('K32',"OCTUBRE");
        $event->sheet->getDelegate()->setCellValue('L32',"NOVIEMBRE");
        $event->sheet->getDelegate()->setCellValue('M32',"DICIEMBRE");
        $event->sheet->getDelegate()->setCellValue('N32',"TOTAL");
        $event->sheet->getDelegate()->getStyle('B32:N32')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 20],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('A33',"F12-B");
        $event->sheet->getDelegate()->setCellValue('A34',"MEF");
        $event->sheet->getDelegate()->getStyle('A33:A34')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 20],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->setCellValue('B33',$data_f12b->enero);
        $event->sheet->getDelegate()->setCellValue('C33',$data_f12b->febrero);
        $event->sheet->getDelegate()->setCellValue('D33',$data_f12b->marzo);
        $event->sheet->getDelegate()->setCellValue('E33',$data_f12b->abril);
        $event->sheet->getDelegate()->setCellValue('F33',$data_f12b->mayo);
        $event->sheet->getDelegate()->setCellValue('G33',$data_f12b->junio);
        $event->sheet->getDelegate()->setCellValue('H33',$data_f12b->julio);
        $event->sheet->getDelegate()->setCellValue('I33',$data_f12b->agosto);
        $event->sheet->getDelegate()->setCellValue('J33',$data_f12b->septiembre);
        $event->sheet->getDelegate()->setCellValue('K33',$data_f12b->octubre);
        $event->sheet->getDelegate()->setCellValue('L33',$data_f12b->noviembre);
        $event->sheet->getDelegate()->setCellValue('M33',$data_f12b->diciembre);
        $total_f12b = $data_f12b->enero + $data_f12b->febrero + $data_f12b->marzo + $data_f12b->abril + $data_f12b->mayo + $data_f12b->junio + $data_f12b->julio + $data_f12b->agosto + $data_f12b->septiembre + $data_f12b->octubre + $data_f12b->noviembre + $data_f12b->diciembre;
        $event->sheet->getDelegate()->setCellValue('N33',$total_f12b);

        $event->sheet->getDelegate()->setCellValue('B34',$data_mef->enero);
        $event->sheet->getDelegate()->setCellValue('C34',$data_mef->febrero);
        $event->sheet->getDelegate()->setCellValue('D34',$data_mef->marzo);
        $event->sheet->getDelegate()->setCellValue('E34',$data_mef->abril);
        $event->sheet->getDelegate()->setCellValue('F34',$data_mef->mayo);
        $event->sheet->getDelegate()->setCellValue('G34',$data_mef->junio);
        $event->sheet->getDelegate()->setCellValue('H34',$data_mef->julio);
        $event->sheet->getDelegate()->setCellValue('I34',$data_mef->agosto);
        $event->sheet->getDelegate()->setCellValue('J34',$data_mef->septiembre);
        $event->sheet->getDelegate()->setCellValue('K34',$data_mef->octubre);
        $event->sheet->getDelegate()->setCellValue('L34',$data_mef->noviembre);
        $event->sheet->getDelegate()->setCellValue('M34',$data_mef->diciembre);
        $total_mef = $data_mef->enero + $data_mef->febrero + $data_mef->marzo + $data_mef->abril + $data_mef->mayo + $data_mef->junio + $data_mef->julio + $data_mef->agosto + $data_mef->septiembre + $data_mef->octubre + $data_mef->noviembre + $data_mef->diciembre;
        $event->sheet->getDelegate()->setCellValue('N34',$total_mef);

        $event->sheet->getDelegate()->getStyle('B33:N34')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 20],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->getStyle('B33:N34')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        // FIN PROGRAMACION MEF VS F12-B
        $event->sheet->getDelegate()->mergeCells('A35:N35');
        $event->sheet->getDelegate()->setCellValue('A36',"RESUMEN DE EJECUCION POR PROYECTO AL MES DE " . strtoupper($meses));
        $event->sheet->getDelegate()->mergeCells('A36:N36');
        $event->sheet->getDelegate()->getStyle('A36:N36')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 48],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->mergeCells('A37:N37');
        $event->sheet->getDelegate()->setCellValue('A38',"N°");
        $event->sheet->getDelegate()->mergeCells('A38:A39');
        $event->sheet->getDelegate()->setCellValue('B38',"CUI");
        $event->sheet->getDelegate()->mergeCells('B38:B39');
        $event->sheet->getDelegate()->setCellValue('C38',"INVERSION");
        $event->sheet->getDelegate()->mergeCells('C38:E39');
        $event->sheet->getDelegate()->setCellValue('F38',"EJECUCION REAL");
        $event->sheet->getDelegate()->mergeCells('F38:H38');
        $event->sheet->getDelegate()->setCellValue('F39',"PROGRAMACION");
        $event->sheet->getDelegate()->setCellValue('G39',"EJECUCION");
        $event->sheet->getDelegate()->setCellValue('H39',"AVANCE(%)");
        $event->sheet->getDelegate()->setCellValue('I38',"DEVENGADO AL ". $fecha);
        $event->sheet->getDelegate()->mergeCells('I38:N38');
        $event->sheet->getDelegate()->setCellValue('I39',"LUN");
        $event->sheet->getDelegate()->setCellValue('J39',"MAR");
        $event->sheet->getDelegate()->setCellValue('K39',"MIE");
        $event->sheet->getDelegate()->setCellValue('L39',"JUE");
        $event->sheet->getDelegate()->setCellValue('M39',"VIE");
        $event->sheet->getDelegate()->setCellValue('N39',"TOTAL DEVENGADO");
        $event->sheet->getDelegate()->getStyle('A38:N39')->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 19],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );

        // PARA LISTADO DE INVERSIONES
        $lunes =  0;
        $martes =  0;
        $miercoles =  0;
        $jueves =  0;
        $viernes =  0;
        $semana = 0;
        // TOTALES
        $t_meta = 0;
        $t_dev = 0;
        $t_lunes =  0;
        $t_martes =  0;
        $t_miercoles =  0;
        $t_jueves =  0;
        $t_viernes =  0;
        $t_semana =  0;
        $t_n_inversion = 0;

        $fila_inicio = 40;
        foreach ($data_dia_inversion_hoy as $key => $item) {
            $lunes = $data_dia_inversion->where('codigo_unico','=',$item->codigo_unico)->where('dia','=','2')->first();
            $martes = $data_dia_inversion->where('codigo_unico','=',$item->codigo_unico)->where('dia','=','3')->first();
            $miercoles = $data_dia_inversion->where('codigo_unico','=',$item->codigo_unico)->where('dia','=','4')->first();
            $jueves = $data_dia_inversion->where('codigo_unico','=',$item->codigo_unico)->where('dia','=','5')->first();
            $viernes = $data_dia_inversion->where('codigo_unico','=',$item->codigo_unico)->where('dia','=','6')->first();
            $semana = (empty($lunes->dif_dev_dia) ? 0 : $lunes->dif_dev_dia) + (empty($martes->dif_dev_dia) ? 0 : $martes->dif_dev_dia) + (empty($miercoles->dif_dev_dia) ? 0 : $miercoles->dif_dev_dia) + (empty($jueves->dif_dev_dia) ? 0 : $jueves->dif_dev_dia )+ (empty($viernes->dif_dev_dia) ? 0 : $viernes->dif_dev_dia);

            $t_meta += empty($item->meta_mes) ? 0 : $item->meta_mes;
            $t_dev += empty($item->dev_mes) ? 0 : $item->dev_mes;
            $t_lunes +=  empty($lunes->dif_dev_dia) ? 0 : $lunes->dif_dev_dia;
            $t_martes +=  empty($martes->dif_dev_dia) ? 0 : $martes->dif_dev_dia;
            $t_miercoles +=  empty($miercoles->dif_dev_dia) ? 0 : $miercoles->dif_dev_dia;
            $t_jueves +=  empty($jueves->dif_dev_dia) ? 0 : $jueves->dif_dev_dia;
            $t_viernes +=  empty($viernes->dif_dev_dia) ? 0 : $viernes->dif_dev_dia;
            $t_semana +=  empty($semana->dif_dev_dia) ? 0 : $semana->dif_dev_dia;
            $t_n_inversion += 1;
            $event->sheet->getDelegate()->getRowDimension($fila_inicio + $key)->setRowHeight(65);
            $event->sheet->getDelegate()->setCellValue('A'.$fila_inicio + $key,$key + 1);
            $event->sheet->getDelegate()->setCellValue('B'.$fila_inicio + $key,$item->codigo_unico);
            $event->sheet->getDelegate()->setCellValue('C'.$fila_inicio + $key,$item->nom_inversion);
            $event->sheet->getDelegate()->mergeCells('C'.$fila_inicio + $key.':'.'E'.$fila_inicio + $key);
            $event->sheet->getDelegate()->setCellValue('F'.$fila_inicio + $key,$item->meta_mes);
            $event->sheet->getDelegate()->getStyle('F'.$fila_inicio + $key)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $event->sheet->getDelegate()->setCellValue('G'.$fila_inicio + $key,$item->dev_mes);
            $event->sheet->getDelegate()->getStyle('G'.$fila_inicio + $key)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            if($item->meta_mes > 0){
                $event->sheet->getDelegate()->setCellValue('H'.$fila_inicio + $key,$item->dev_mes/$item->meta_mes);
            }else{
                $event->sheet->getDelegate()->setCellValue('H'.$fila_inicio + $key,0);
            }
            $event->sheet->getDelegate()->getStyle('H'.$fila_inicio + $key)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
            $event->sheet->getDelegate()->setCellValue('I'.$fila_inicio + $key,empty($lunes->dif_dev_dia) ? 0 : $lunes->dif_dev_dia);
            $event->sheet->getDelegate()->setCellValue('J'.$fila_inicio + $key,empty($martes->dif_dev_dia) ? 0 : $martes->dif_dev_dia);
            $event->sheet->getDelegate()->setCellValue('K'.$fila_inicio + $key,empty($miercoles->dif_dev_dia) ? 0 : $miercoles->dif_dev_dia);
            $event->sheet->getDelegate()->setCellValue('L'.$fila_inicio + $key,empty($jueves->dif_dev_dia) ? 0 : $jueves->dif_dev_dia);
            $event->sheet->getDelegate()->setCellValue('M'.$fila_inicio + $key,empty($viernes->dif_dev_dia) ? 0 : $viernes->dif_dev_dia);
            $event->sheet->getDelegate()->setCellValue('N'.$fila_inicio + $key,empty($semana) ? 0 : $semana);
            $event->sheet->getDelegate()->getStyle('I'.$fila_inicio + $key.':N'.$fila_inicio + $key)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        }
        $event->sheet->getDelegate()->getStyle('A'.$fila_inicio.':N'.$fila_inicio + $t_n_inversion - 1)->applyFromArray(
            [
                'font' => ['size' => 19],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                // 'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );
        $event->sheet->getDelegate()->getStyle('C'.$fila_inicio.':C'.$fila_inicio + $t_n_inversion - 1)->applyFromArray(
            [
                'font' => ['size' => 15],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'left'],
            ]
        );
        // TOTALES
        $event->sheet->getDelegate()->setCellValue('A'.$fila_inicio + $t_n_inversion,$t_n_inversion);
        $event->sheet->getDelegate()->setCellValue('B'.$fila_inicio + $t_n_inversion,"TOTAL");
        $event->sheet->getDelegate()->mergeCells('B'.$fila_inicio + $t_n_inversion.':'.'E'.$fila_inicio + $t_n_inversion);
        $event->sheet->getDelegate()->setCellValue('F'.$fila_inicio + $t_n_inversion,$t_meta);
        $event->sheet->getDelegate()->getStyle('F'.$fila_inicio + $t_n_inversion)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $event->sheet->getDelegate()->setCellValue('G'.$fila_inicio + $t_n_inversion,$t_dev);
        $event->sheet->getDelegate()->getStyle('G'.$fila_inicio + $t_n_inversion)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        if($t_meta > 0){
            $event->sheet->getDelegate()->setCellValue('H'.$fila_inicio + $t_n_inversion,$t_dev/$t_meta);
        }else{
            $event->sheet->getDelegate()->setCellValue('H'.$fila_inicio + $t_n_inversion,0);
        }
        $event->sheet->getDelegate()->getStyle('H'.$fila_inicio + $t_n_inversion,$t_dev)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $event->sheet->getDelegate()->setCellValue('I'.$fila_inicio + $t_n_inversion,empty($t_lunes) ? 0 : $t_lunes);
        $event->sheet->getDelegate()->setCellValue('J'.$fila_inicio + $t_n_inversion,empty($t_martes) ? 0 : $t_martes);
        $event->sheet->getDelegate()->setCellValue('K'.$fila_inicio + $t_n_inversion,empty($t_miercoles) ? 0 : $t_miercoles);
        $event->sheet->getDelegate()->setCellValue('L'.$fila_inicio + $t_n_inversion,empty($t_jueves) ? 0 : $t_jueves);
        $event->sheet->getDelegate()->setCellValue('M'.$fila_inicio + $t_n_inversion,empty($t_viernes->dif_dev_dia) ? 0 : $t_viernes->dif_dev_dia);
        $event->sheet->getDelegate()->setCellValue('N'.$fila_inicio + $t_n_inversion,empty($t_semana) ? 0 : $t_semana);
        $event->sheet->getDelegate()->getStyle('I'.$fila_inicio + $t_n_inversion.':N'.$fila_inicio + $t_n_inversion)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $event->sheet->getDelegate()->getStyle('A'.$fila_inicio + $t_n_inversion.':N'.$fila_inicio + $t_n_inversion)->applyFromArray(
            [
                'font' => ['bold' => true,'size' => 20],
                'alignment' => ['wrapText' => True,'vertical' => 'center','horizontal' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['argb'=> 'FFB5B5']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]
        );

         // IMPRIMIR
        $event->sheet->getDelegate()->getPageSetup()->setPrintArea('A1:N'.$fila_inicio + $t_n_inversion);
        $event->sheet->getDelegate()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,3);
        $event->sheet->getDelegate()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
        $event->sheet->getDelegate()->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A3);
        $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
        $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
        $event->sheet->getDelegate()->getPageMargins()->setRight(0.25);
        $event->sheet->getDelegate()->getPageMargins()->setLeft(0.25);
        $event->sheet->getDelegate()->getPageMargins()->setBottom(0.25);

        //ZOOM
        $event->sheet->getSheetView()->setZoomScale(40);
     }

}