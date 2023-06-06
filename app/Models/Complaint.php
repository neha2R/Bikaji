<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Complaint extends Model
{
    protected $fillable = ['uuid', 'customername', 'details', 'image', 'complainttype', 'complaintsource', 'createdby', 'mobile', 'email', 'title', 'is_resolved', 'customer_type', 'customer_address', 'customer_city', 'customer_state', 'customer_invoice_no', 'purchase_date', 'delivery_date', 'product_category', 'product_name', 'sku', 'mfg', 'batch_number', 'production_facility', 'risk_category', 'complaint_type', 'pin', 'address','product_categoryid'];

    public function departmentrelation()
    {
        return $this->hasOne(Department::class, 'id', 'complainttype');
    }
    public function complaintsourcerelation()
    {
        return $this->hasOne(ComplaintSource::class, 'id', 'complaintsource');
    }

    public function complaintresoultionrelation()
    {
        return $this->hasOne(Resolution::class, 'complaint_id', 'id');
    }
    public function touserrelation(){
        return $this->hasOne(User::class,'id','createdby');
    }
}
