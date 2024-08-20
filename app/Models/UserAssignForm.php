<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAssignForm extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'form_id'];

    public function form()
    {
        return $this->belongsTo(FormBuilder::class, 'form_id');

    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function formData()
    {
        return $this->belongsTo(UserFormData::class,  'id', 'assign_form_id');
    }
}
