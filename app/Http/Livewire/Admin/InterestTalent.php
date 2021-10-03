<?php

namespace App\Http\Livewire\Admin;

use App\Models\InterestTalent as ModelsInterestTalent;
use Livewire\Component;


class InterestTalent extends Component
{
    
    public $tbl_interest_talent_id;
    public $talent_name;
    
   

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
        
        $data = ['talent_name'  => $this->talent_name];

        ModelsInterestTalent::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['talent_name'  => $this->talent_name];
        $row = ModelsInterestTalent::find($this->tbl_interest_talent_id);

        

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
            'talent_name'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_interest_talent_id)
    {
        $tbl_interest_talent = ModelsInterestTalent::find($tbl_interest_talent_id);
        $this->tbl_interest_talent_id = $tbl_interest_talent->id;
        $this->talent_name = $tbl_interest_talent->talent_name;
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
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
