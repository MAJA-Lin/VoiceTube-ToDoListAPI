<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Attachment;
use App\Models\User;

class ToDoList extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
    ];

    protected $hidden = array('user_id');

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'done_at'];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByUserId(\Illuminate\Database\Eloquent\Builder $query, int $userId)
    {
        return $query->where('user_id', '=', $userId);
    }
}
