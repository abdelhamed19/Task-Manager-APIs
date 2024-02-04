<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',"completed","project_id"];
    protected  $casts= [
        'completed' => 'boolean'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id'
    ];
    public function scopeFilter($query,$completed)
    {
        return $query->where('completed', $completed);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function booted()
    {
        static::addGlobalScope("creator",function (Builder $builder){
            $builder->where("user_id",Auth::id())->
            orWhereIn("project_id",Auth::user()->memberships->pluck('id'));
        });
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
