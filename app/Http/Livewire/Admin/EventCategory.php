<?php

namespace App\Http\Livewire\Admin;

use App\Models\EventCategory as ModelsEventCategory;
use Livewire\Component;


class EventCategory extends Component
{

    public $tbl_event_categories_id;
    public $event_category_name;
    public $event_category_type;
    public $event_is_paid;
    public $event_discount = 0;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.tbl-event-categories', [
            'items' => ModelsEventCategory::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'event_category_name'  => $this->event_category_name,
            'event_category_type'  => $this->event_category_type,
            'event_is_paid'  => $this->event_is_paid,
            'event_discount'  => $this->event_discount
        ];

        ModelsEventCategory::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'event_category_name'  => $this->event_category_name,
            'event_category_type'  => $this->event_category_type,
            'event_is_paid'  => $this->event_is_paid,
            'event_discount'  => $this->event_discount
        ];
        $row = ModelsEventCategory::find($this->tbl_event_categories_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsEventCategory::find($this->tbl_event_categories_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'event_category_name'  => 'required',
            'event_category_type'  => 'required',
            'event_is_paid'  => 'required',
            'event_discount'  => 'max:100'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_event_categories_id)
    {
        $tbl_event_categories = ModelsEventCategory::find($tbl_event_categories_id);
        $this->tbl_event_categories_id = $tbl_event_categories->id;
        $this->event_category_name = $tbl_event_categories->event_category_name;
        $this->event_category_type = $tbl_event_categories->event_category_type;
        $this->event_is_paid = $tbl_event_categories->event_is_paid;
        $this->event_discount = $tbl_event_categories->event_discount;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_event_categories_id)
    {
        $tbl_event_categories = ModelsEventCategory::find($tbl_event_categories_id);
        $this->tbl_event_categories_id = $tbl_event_categories->id;
    }

    public function toggleForm($form)
    {
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->tbl_event_categories_id = null;
        $this->event_category_name = null;
        $this->event_category_type = null;
        $this->event_is_paid = null;
        $this->event_discount = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
