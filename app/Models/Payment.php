<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
    use HasFactory;
    protected $fillable = ['student_id','fee_structure_id','transaction_id','paypal_order_id','amount','currency','status','payment_method','receipt_no','notes','paid_at'];
    protected $casts = ['amount'=>'decimal:2','paid_at'=>'datetime'];
    public function student()      { return $this->belongsTo(Student::class); }
    public function feeStructure() { return $this->belongsTo(FeeStructure::class); }
    protected static function booted(): void {
        static::creating(function (Payment $p) {
            if (empty($p->receipt_no)) $p->receipt_no = 'RCP-'.strtoupper(uniqid());
        });
    }
}
