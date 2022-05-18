<?php

namespace App\Rules;

use App\Models\EmployeeTransaction;
use App\Models\Project;
use Illuminate\Contracts\Validation\Rule;

class EmployeeProgress implements Rule
{
    public $project_id;
    public $progress;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value == 0) {
            $this->message();
            return 0;
        }
        $project_unit = Project::where('id', $this->project_id)->value('units');
        $total_units = EmployeeTransaction::where('project_id', $this->project_id)->sum('units');
        $this->progress = $pending_units = $project_unit - $total_units;
        return $value <= $pending_units;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your progress couldn\'t be saved. Please chek your total progress.';
    }
}
