<?php

namespace App\Http\Livewire\Dashboard\Tables;

use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\Order;
use App\Models\Orders;
use App\Models\Page;
use App\Models\WeQuiz;
use App\Models\WeQuizResult;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class WeQuizResultsTable extends DataTableComponent
{
    use DispatchSupport;

    public ?int $searchFilterDebounce = 800;

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    public bool $columnSelect = true;

    public int $perPage = 25;

    public array $perPageAccepted = [10, 25, 50, 100];

    public array $bulkActions = [

    ];

    protected string $pageName = 'quiz_results';

    protected string $tableName = 'quiz_results';

    public $weQuiz;

    public function filters(): array
    {
        return [
            'passed' => Filter::make('Quiz passed')
                        ->select([
                            '' => translate('All'),
                            1 => translate('Passed'),
                            0 => translate('Not Passed'),
                        ])
        ];
    }

    public function mount($weQuiz) {
        $this->weQuiz = $weQuiz;

        parent::mount();
    }

    public function columns(): array
    {
        return [
            Column::make('ID')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('User')
                ->excludeFromSelectable(),
            Column::make('Passed', 'quiz_passed')
                ->excludeFromSelectable(),
            Column::make('Submitted', 'created_at')
                ->excludeFromSelectable(),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        return $this->weQuiz->results()->getQuery()
            ->when($this->getFilter('passed'), fn ($query, $passed) => $query->where('quiz_passed', $passed));
    }

    public function rowView(): string
    {
        return 'frontend.dashboard.we-quiz.row-quiz-result';
    }
}
