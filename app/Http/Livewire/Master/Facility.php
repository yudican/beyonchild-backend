<?php

namespace App\Http\Livewire\Master;

use App\Models\Facility as ModelsFacility;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Facility extends Component
{
    use WithFileUploads;
    public $tbl_facilities_id;
    public $facility_name;
    public $facility_icon;
    public $facility_icon_path;


    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.master.tbl-facilities', [
            'items' => ModelsFacility::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $facility_icon = $this->facility_icon_path->store('upload', 'public');
        $data = [
            'facility_name'  => $this->facility_name,
            'facility_icon'  => $facility_icon,
        ];

        ModelsFacility::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'facility_name'  => $this->facility_name,
            'facility_icon'  => $this->facility_icon
        ];
        $row = ModelsFacility::find($this->tbl_facilities_id);


        if ($this->facility_icon_path) {
            $facility_icon = $this->facility_icon_path->store('upload', 'public');
            $data = ['facility_icon' => $facility_icon];
            if (Storage::exists('public/' . $this->facility_icon)) {
                Storage::delete('public/' . $this->facility_icon);
            }
        }

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsFacility::find($this->tbl_facilities_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = ['facility_name'  => 'required'];

        $rule['facility_icon_path'] = 'image';
        if (!$this->update_mode) {
            $rule['facility_icon_path'] = 'required|image';
        }

        return $this->validate($rule);
    }

    public function getDataById($tbl_facilities_id)
    {
        $tbl_facilities = ModelsFacility::find($tbl_facilities_id);
        $this->tbl_facilities_id = $tbl_facilities->id;
        $this->facility_name = $tbl_facilities->facility_name;
        $this->facility_icon = $tbl_facilities->facility_icon;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_facilities_id)
    {
        $tbl_facilities = ModelsFacility::find($tbl_facilities_id);
        $this->tbl_facilities_id = $tbl_facilities->id;
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
        $this->tbl_facilities_id = null;
        $this->facility_name = null;
        $this->facility_icon = null;
        $this->facility_icon_path = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
