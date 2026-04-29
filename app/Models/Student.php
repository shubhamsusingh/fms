<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Student extends Model {
    use HasFactory;
    protected $fillable = ['user_id','enrollment_no','course','branch','semester','batch','phone','address'];
    public function user()     { return $this->belongsTo(User::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function hasPaidFee(): bool {
        return $this->payments()
            ->where('status','completed')
            ->whereHas('feeStructure', fn($q) => $q->where('semester',$this->semester))
            ->exists();
    }
}
