<?php

namespace App\Http\Livewire\Admin;

use App\Models\SmartCategory as ModelsSmartCategory;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class SmartCategory extends Component
{
    use WithFileUploads;
    public $tbl_smart_categories_id;
    public $category_name;
    public $category_description;
    public $category_icon;
    public $category_icon_path;


    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.tbl-smart-categories', [
            'items' => ModelsSmartCategory::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $category_icon = $this->category_icon_path->store('upload', 'public');
        $data = [
            'category_name'  => $this->category_name,
            'category_description'  => $this->category_description,
            'category_icon'  => $category_icon,
        ];

        ModelsSmartCategory::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'category_name'  => $this->category_name,
            'category_description'  => $this->category_description,
            'category_icon'  => $this->category_icon
        ];
        $row = ModelsSmartCategory::find($this->tbl_smart_categories_id);


        if ($this->category_icon_path) {
            $category_icon = $this->category_icon_path->store('upload', 'public');
            $data = ['category_icon' => $category_icon];
            if (Storage::exists('public/' . $this->category_icon)) {
                Storage::delete('public/' . $this->category_icon);
            }
        }

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsSmartCategory::find($this->tbl_smart_categories_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'category_name'  => 'required',
            'category_description'  => 'required',
            'category_icon_path'  => 'required'
        ];

        if (!$this->update_mode) {
            $rule['category_icon_path'] = 'required|image';
        }

        return $this->validate($rule);
    }

    public function getDataById($tbl_smart_categories_id)
    {
        $this->_reset();
        $tbl_smart_categories = ModelsSmartCategory::find($tbl_smart_categories_id);
        $this->tbl_smart_categories_id = $tbl_smart_categories->id;
        $this->category_name = $tbl_smart_categories->category_name;
        $this->category_description = $tbl_smart_categories->category_description;
        $this->category_icon = $tbl_smart_categories->category_icon;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_smart_categories_id)
    {
        $this->_reset();
        $tbl_smart_categories = ModelsSmartCategory::find($tbl_smart_categories_id);
        $this->tbl_smart_categories_id = $tbl_smart_categories->id;
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
        $this->tbl_smart_categories_id = null;
        $this->category_name = null;
        $this->category_description = null;
        $this->category_icon = null;
        $this->category_icon_path = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
