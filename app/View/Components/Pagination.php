<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class Pagination extends Component
{
    /**
     * Create a new component instance.
     */
    public $models;
    public $currentPage;
    public $totalEntries;
    public $totalPages;

    public function __construct(LengthAwarePaginator $models)
    {
        $this->models = $models;
        $this->currentPage = $models->currentPage();
        $this->totalEntries = $models->total();
        $this->totalPages = $models->lastPage();
    }

    public function render()
    {
        return view('components.pagination');
    }

}
