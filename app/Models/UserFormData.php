<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFormData extends Model
{
    use HasFactory;

    protected $fillable = ['assign_form_id', 'form_id', 'user_id', 'form_data', 'values'];

    public function assignForm()
    {
        return $this->belongsTo(UserAssignForm::class, 'assign_form_id');
    }

    public function form()
    {
        return $this->belongsTo(FormBuilder::class, 'form_id');

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
