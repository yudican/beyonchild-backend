<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\Event;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;

class EventTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_events';
    public $hide = [];


    public function builder()
    {
        return Event::query();
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('event_name')->label('Event name')->searchable(),
            Column::name('event_date')->label('Event date')->searchable(),
            Column::name('event_fee')->label('Event fee')->searchable(),
            Column::callback(['event_banner'], function ($image) {
                return view('livewire.components.photo', [
                    'image_url' => asset('storage/' . $image),
                ]);
            })->label(__('banner')),
            // Column::name('event_description')->label('Event description')->searchable(),
            // Column::name('event_narasumber')->label('Event narasumber')->searchable(),
            // Column::name('event_benefit')->label('Event benefit')->searchable(),
            // Column::name('event_note')->label('Event note')->searchable(),
            Column::name('event_start')->label('Event start')->searchable(),
            Column::name('event_end')->label('Event end')->searchable(),

            Column::callback(['id'], function ($id) {
                return view('livewire.components.action-button', [
                    'id' => $id,
                    'segment' => request()->segment(1)
                ]);
            })->label(__('Aksi')),
        ];
    }

    public function getDataById($id)
    {
        $this->emit('getDataById', $id);
    }

    public function getId($id)
    {
        $this->emit('getId', $id);
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }

    public function toggle($index)
    {
        if ($this->sort == $index) {
            $this->initialiseSort();
        }

        $column = HideableColumn::where([
            'table_name' => $this->table_name,
            'column_name' => $this->columns[$index]['name'],
            'index' => $index,
            'user_id' => auth()->user()->id
        ])->first();

        if (!$this->columns[$index]['hidden']) {
            unset($this->activeSelectFilters[$index]);
        }

        $this->columns[$index]['hidden'] = !$this->columns[$index]['hidden'];

        if (!$column) {
            HideableColumn::updateOrCreate([
                'table_name' => $this->table_name,
                'column_name' => $this->columns[$index]['name'],
                'index' => $index,
                'user_id' => auth()->user()->id
            ]);
        } else {
            $column->delete();
        }
    }
}
