<?php

namespace App\Http\Livewire\Admin;

use App\Models\Event as ModelsEvent;
use App\Models\EventCategory;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Event extends Component
{
    use WithFileUploads;
    public $tbl_events_id;
    public $event_name;
    public $event_date;
    public $event_fee;
    public $event_banner;
    public $event_description;
    public $event_narasumber;
    public $event_benefit;
    public $event_note;
    public $event_start;
    public $event_end;
    public $event_banner_path;
    public $event_category_id;


    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.tbl-events', [
            'items' => ModelsEvent::all(),
            'event_categories' => EventCategory::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $event_banner = $this->event_banner_path->store('upload', 'public');
        $data = [
            'event_name'  => $this->event_name,
            'event_date'  => date('Y-m-d H:i:s', strtotime($this->event_date)),
            'event_fee'  => $this->event_fee,
            'event_banner'  => $event_banner,
            'event_description'  => $this->event_description,
            'event_narasumber'  => $this->event_narasumber,
            'event_benefit'  => $this->event_benefit,
            'event_note'  => $this->event_note,
            'event_start'  => $this->event_start,
            'event_end'  => $this->event_end
        ];

        $event = ModelsEvent::create($data);
        $event->eventCategories()->attach($this->event_category_id);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'event_name'  => $this->event_name,
            'event_date'  => date('Y-m-d H:i:s', strtotime($this->event_date)),
            'event_fee'  => $this->event_fee,
            'event_banner'  => $this->event_banner,
            'event_description'  => $this->event_description,
            'event_narasumber'  => $this->event_narasumber,
            'event_benefit'  => $this->event_benefit,
            'event_note'  => $this->event_note,
            'event_start'  => $this->event_start,
            'event_end'  => $this->event_end
        ];
        $row = ModelsEvent::find($this->tbl_events_id);
        $row->eventCategories()->sync($this->event_category_id);

        if ($this->event_banner_path) {
            $event_banner = $this->event_banner_path->store('upload', 'public');
            $data = ['event_banner' => $event_banner];
            if (Storage::exists('public/' . $this->event_banner)) {
                Storage::delete('public/' . $this->event_banner);
            }
        }

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsEvent::find($this->tbl_events_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'event_name'  => 'required',
            'event_date'  => 'required',
            'event_fee'  => 'required',
            'event_description'  => 'required',
            'event_narasumber'  => 'required',
            'event_benefit'  => 'required',
            'event_note'  => 'required',
            'event_start'  => 'required',
            'event_end'  => 'required'
        ];

        if (!$this->update_mode) {
            $rule['event_banner_path'] = 'required|image';
        }

        return $this->validate($rule);
    }

    public function getDataById($tbl_events_id)
    {
        $tbl_events = ModelsEvent::find($tbl_events_id);
        $this->tbl_events_id = $tbl_events->id;
        $this->event_name = $tbl_events->event_name;
        $this->event_date = $tbl_events->event_date;
        $this->event_fee = $tbl_events->event_fee;
        $this->event_banner = $tbl_events->event_banner;
        $this->event_description = $tbl_events->event_description;
        $this->event_narasumber = $tbl_events->event_narasumber;
        $this->event_benefit = $tbl_events->event_benefit;
        $this->event_note = $tbl_events->event_note;
        $this->event_start = $tbl_events->event_start;
        $this->event_end = $tbl_events->event_end;
        $this->event_category_id = $tbl_events->eventCategories()->pluck('event_category_id')->toArray();
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_events_id)
    {
        $tbl_events = ModelsEvent::find($tbl_events_id);
        $this->tbl_events_id = $tbl_events->id;
    }

    public function toggleForm($form)
    {
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->_reset();
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->tbl_events_id = null;
        $this->event_name = null;
        $this->event_date = null;
        $this->event_fee = null;
        $this->event_banner = null;
        $this->event_banner_path = null;
        $this->event_description = null;
        $this->event_narasumber = null;
        $this->event_benefit = null;
        $this->event_note = null;
        $this->event_start = null;
        $this->event_end = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
