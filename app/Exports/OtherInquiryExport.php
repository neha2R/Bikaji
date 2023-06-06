<?php

namespace App\Exports;

use App\OtherFee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
class OtherInquiryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $data;

    public function __construct($data)
    {
         $this->data=$data;
       
    }
    public function collection()
    {
          $i=1;
         foreach($this->data as $one)
         {
           
                $one->uuid=$one->uuid;
                $one->customername=$one->customername;
                $one->mobile=$one->contact;
                $one->details=$one->details;
                if($one->inquirysourcerelation)
                {
                $one->inquirysource=$one->inquirysourcerelation->name ;
                }
                else
                {
                    $one->inquirysource='N/A' ;
   
                }

                $one->created_at=$one->created_at;
                if($one->touserrelation)
                {
                $one->createdby=$one->touserrelation->name;
                }
                else
                {
                    $one->createdby='N/A';  
                }                
                $one->email=$one->email;
                $i++;
         }
        
         return $this->data;

         
    }

    public function headings(): array
    {
        return ["uuid","customername","contact", "details", "inquirysource",'created_at','createdby',"email","mobile"];
    }
}
