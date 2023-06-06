<?php

namespace App\Exports;

use App\OtherFee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
class OtherExport implements FromCollection, WithHeadings
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
                $one->mobile=$one->mobile;
                $one->details=$one->details;
                if($one->complainttype)
                {
                $one->complainttype=$one->departmentrelation->name ;
                }
                else
                {
                    $one->complainttype='N/A' ;
   
                }
                $one->complaintsource= $one->complaintsourcerelation->name;
                $one->created_at=$one->created_at;
                if($one->touserrelation)
                {
                    dd($one->touserrelation->name);
                $one->createdby=$one->touserrelation->name;
                }
                else
                {
                    dd('call');
                    $one->createdby='N/A';  
                }
                $one->title=$one->title;
                if($one->is_resolved==1)
                {
                    $one->is_resolved="Resolved";

                }
                else
                {
                    $one->is_resolved="Unresolved";

                }
                $one->email=$one->email;
                $i++;
         }
        
         return $this->data;

         
    }

    public function headings(): array
    {
        return ["uuid","customername","mobile", "details", "complainttype",'complaintsource','created_at','createdby','title',"is_resolved","email"];
    }
}
