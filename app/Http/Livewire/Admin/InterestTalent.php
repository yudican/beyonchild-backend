<?php

namespace App\Http\Livewire\Admin;

use App\Models\InterestTalent as ModelsInterestTalent;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class InterestTalent extends Component
{
    use WithFileUploads;
    public $tbl_interest_talent_id;
    public $talent_name;
    public $image;
    public $description;
    public $image_path;


    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.tbl-interest-talent', [
            'items' => ModelsInterestTalent::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $image = $this->image_path->store('upload', 'public');
        $data = [
            'talent_name'  => $this->talent_name,
            'image'  => $image,
            'description'  => $this->description
        ];

        ModelsInterestTalent::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'talent_name'  => $this->talent_name,
            'image'  => $this->image,
            'description'  => $this->description
        ];
        $row = ModelsInterestTalent::find($this->tbl_interest_talent_id);


        if ($this->image_path) {
            $image = $this->image_path->store('upload', 'public');
            $data = ['image' => $image];
            if (Storage::exists('public/' . $this->image)) {
                Storage::delete('public/' . $this->image);
            }
        }

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsInterestTalent::find($this->tbl_interest_talent_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'talent_name'  => 'required',
            'description'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_interest_talent_id)
    {
        $tbl_interest_talent = ModelsInterestTalent::find($tbl_interest_talent_id);
        $this->tbl_interest_talent_id = $tbl_interest_talent->id;
        $this->talent_name = $tbl_interest_talent->talent_name;
        $this->image = $tbl_interest_talent->image;
        $this->description = $tbl_interest_talent->description;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_interest_talent_id)
    {
        $tbl_interest_talent = ModelsInterestTalent::find($tbl_interest_talent_id);
        $this->tbl_interest_talent_id = $tbl_interest_talent->id;
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
        $this->tbl_interest_talent_id = null;
        $this->talent_name = null;
        $this->image = null;
        $this->image_path = null;
        $this->description = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
