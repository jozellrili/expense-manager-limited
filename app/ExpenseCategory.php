<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterByUser;
use Illuminate\Support\Facades\DB;

/**
 * Class ExpenseCategory
 *
 * @package App
 * @property string $name
 * @property string $created_by
 */
class ExpenseCategory extends Model
{
    use FilterByUser;
    
    protected $fillable = ['name', 'description', 'created_by_id'];
    
    
    /**
     * Set to null if empty
     *
     * @param $input
     */
    public function setCreatedByIdAttribute($input)
    {
        $this->attributes['created_by_id'] = $input ? $input : null;
    }
    
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function getAllCategories()
    {
        $categories = DB::table('expense_categories')->get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return $categories;
    }
}
