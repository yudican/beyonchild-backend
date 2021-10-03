<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>mentors</span>
                        </a>
                        <div class="pull-right">
                            @if (auth()->user()->hasTeamPermission($curteam, request()->segment(1).':create'))
                            @if (!$form && !$modal)
                            <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i
                                    class="fas fa-times"></i> Cancel</button>
                            @else
                            <button class="btn btn-primary btn-sm"
                                wire:click="{{$modal ? 'showModal' : 'toggleForm(true)'}}"><i class="fas fa-plus"></i>
                                Add
                                New</button>
                            @endif
                            @endif
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <livewire:table.mentor-table />
        </div>

        {{-- Modal form --}}
        <div id="form-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize" id="my-modal-title">
                            {{$update_mode ? 'Update' : 'Tambah'}} mentors</h5>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-6">
                            <x-text-field type="text" name="mentor_name" label="Name" />
                            <x-text-field type="text" name="mentor_title" label="Title" />
                            <x-text-field type="text" name="mentor_link_meet" label="Link Meet" />
                            <x-text-field type="number" name="mentor_benefit" label="Benefit" />
                        </div>
                        <div class="col-md-6">
                            <x-text-field type="text" name="mentor_phone" label="Phone" />
                            <x-text-field type="text" name="mentor_email" label="Email" />
                            <x-text-field type="number" name="mentor_experient" label="Experient" />
                            <x-select name="education_level_id" label="Education Level">
                                <option value="">Select Level</option>
                                @foreach ($levels as $level)
                                <option value="{{$level->id}}">{{$level->education_level_name}}</option>
                                @endforeach
                            </x-select>
                        </div>

                        <div class="col-md-12">
                            <div wire:ignore
                                class="form-group @error('mentor_description')has-error has-feedback @enderror">
                                <label for="mentor_description" class="text-capitalize">Description</label>
                                <textarea wire:model="mentor_description" id="mentor_description"
                                    class="form-control"></textarea>
                                @error('mentor_description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div wire:ignore
                                class="form-group @error('mentor_topic_description')has-error has-feedback @enderror">
                                <label for="mentor_topic_description" class="text-capitalize">Topic</label>
                                <textarea wire:model="mentor_topic_description" id="mentor_topic_description"
                                    class="form-control"></textarea>
                                @error('mentor_topic_description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>




                    </div>
                    <div class="modal-footer">

                        <button type="button" wire:click={{$update_mode ? 'update' : 'store'}}
                            class="btn btn-primary btn-sm"><i class="fa fa-check pr-2"></i>Simpan</button>

                        <button class="btn btn-danger btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Batal</a>

                    </div>
                </div>
            </div>
        </div>


        {{-- Modal confirm --}}
        <div id="confirm-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data ini.?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click='delete' class="btn btn-danger btn-sm"><i
                                class="fa fa-check pr-2"></i>Ya, Hapus</button>
                        <button class="btn btn-primary btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{asset('assets/js/plugin/summernote/summernote-bs4.min.js')}}"></script>

    <script>
        document.addEventListener('livewire:load', function(e) {
            window.livewire.on('showModal', (data) => {
                $('#form-modal').modal('show')
            });

            window.livewire.on('loadForm', (data) => {
                $('#mentor_description').summernote({
                    placeholder: 'mentor_description',
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                    tabsize: 2,
                    height: 300,
                    callbacks: {
                        onChange: function(contents, $editable) {
                            @this.set('mentor_description', contents);
                        }
                    }
                });
                $('#mentor_topic_description').summernote({
                    placeholder: 'mentor_topic_description',
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                    tabsize: 2,
                    height: 300,
                    callbacks: {
                            onChange: function(contents, $editable) {
                                @this.set('mentor_topic_description', contents);
                        }
                    }
                });
            });

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
                $('#form-modal').modal('hide')
            });
        })
    </script>
    @endpush
</div>