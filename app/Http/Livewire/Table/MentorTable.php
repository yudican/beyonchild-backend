<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\Mentor;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;

class MentorTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    // public $hideable = 'select';
    public $table_name = 'tbl_mentors';
    public $hide = [];


    public function builder()
    {
        return Mentor::query()->where('school_id', $this->params);
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('mentor_name')->label('Name')->searchable(),
            Column::name('mentor_title')->label('Title')->searchable(),
            Column::name('mentor_link_meet')->label('Link Meet')->searchable(),
            Column::name('mentor_phone')->label('Phone')->searchable(),
            Column::name('mentor_email')->label('Email')->searchable(),
            Column::name('mentor_experient')->label('Experient')->searchable(),
            Column::name('mentor_benefit')->label('Benefit')->searchable(),
            // Column::name('mentor_description')->label('Description')->searchable(),
            // Column::name('mentor_topic_description')->label('Topic')->searchable(),
            Column::name('level.education_level_name')->label('Education Level')->searchable(),

            Column::callback(['id'], function ($id) {
                return view('livewire.components.action-button', [
                    'id' => $id,
                    'segment' => request()->route()->getName()
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
