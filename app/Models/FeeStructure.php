<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class FeeStructure extends Model {
    use HasFactory;
    protected $fillable = ['course','branch','semester','academic_year','tuition_fee','exam_fee','library_fee','lab_fee','hostel_fee','other_fee','total_fee','due_date'];
    protected $casts = ['due_date'=>'date','tuition_fee'=>'decimal:2','exam_fee'=>'decimal:2','library_fee'=>'decimal:2','lab_fee'=>'decimal:2','hostel_fee'=>'decimal:2','other_fee'=>'decimal:2','total_fee'=>'decimal:2'];
    public function payments() { return $this->hasMany(Payment::class); }
    public function isOverdue(): bool { return $this->due_date->isPast(); }
    protected static function booted(): void {
        static::saving(function (FeeStructure $fs) {
            $fs->total_fee = $fs->tuition_fee + $fs->exam_fee + $fs->library_fee + $fs->lab_fee + $fs->hostel_fee + $fs->other_fee;
        });
    }
}
