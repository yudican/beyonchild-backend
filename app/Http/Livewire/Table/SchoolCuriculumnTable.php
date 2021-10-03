<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\SchoolCuriculumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;

class SchoolCuriculumnTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $table_name = 'tbl_school_curiculumns';


    public function builder()
    {
        // return SchoolCuriculumn::query();
        return SchoolCuriculumn::where('school_id', $this->params);
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('curriculumn_name')->label('Curiculumn name'),

            Column::callback(['id'], function ($id) {
                return view('livewire.components.action-button', [
                    'id' => $id,
                    'segment' => request()->segment(1),
                    'confirm' => false
                ]);
            })->label(__('Aksi')),
        ];
    }

    public function getDataById($id)
    {
        $this->emit('getDataChildById', $id);
    }

    public function getId($id)
    {
        SchoolCuriculumn::find($id)->delete();
        $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
        $this->refreshTable();
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
