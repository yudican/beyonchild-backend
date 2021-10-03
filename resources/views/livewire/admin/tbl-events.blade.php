<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>events</span>
                        </a>
                        <div class="pull-right">
                            @if ($form_active)
                            <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i
                                    class="fas fa-times"></i> Cancel</button>
                            @else
                            <button class="btn btn-primary btn-sm"
                                wire:click="{{$modal ? 'showModal' : 'toggleForm(true)'}}"><i class="fas fa-plus"></i>
                                Add
                                New</button>
                            @endif
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @if ($form_active)
            <div class="card">
                <div class="card-body">
                    <x-text-field type="text" name="event_name" label="Event name" />
                    <x-text-field type="date" name="event_date" label="Event date" />
                    <x-text-field type="number" name="event_fee" label="Event fee" />
                    <x-select name="event_category_id" label="Category" id="choices-multiple-remove-button" multiple
                        ignore>
                        @foreach ($event_categories as $event_category)
                        <option value="{{$event_category->id}}">{{$event_category->event_category_name}}</option>
                        @endforeach
                    </x-select>
                    <x-text-field type="time" name="event_start" label="Event start" />
                    <x-text-field type="time" name="event_end" label="Event end" />
                    <x-input-photo foto="{{$event_banner}}" path="{{optional($event_banner_path)->temporaryUrl()}}"
                        name="event_banner_path" label="Event banner" />
                    <div wire:ignore class="form-group @error('event_description')has-error has-feedback @enderror">
                        <label for="event_description" class="text-capitalize">Event description</label>
                        <textarea wire:model="event_description" id="event_description" class="form-control"></textarea>
                        @error('event_description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div wire:ignore class="form-group @error('event_narasumber')has-error has-feedback @enderror">
                        <label for="event_narasumber" class="text-capitalize">Event narasumber</label>
                        <textarea wire:model="event_narasumber" id="event_narasumber" class="form-control"></textarea>
                        @error('event_narasumber')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div wire:ignore class="form-group @error('event_benefit')has-error has-feedback @enderror">
                        <label for="event_benefit" class="text-capitalize">Event benefit</label>
                        <textarea wire:model="event_benefit" id="event_benefit" class="form-control"></textarea>
                        @error('event_benefit')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div wire:ignore class="form-group @error('event_note')has-error has-feedback @enderror">
                        <label for="event_note" class="text-capitalize">Event note</label>
                        <textarea wire:model="event_note" id="event_note" class="form-control"></textarea>
                        @error('event_note')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group">
                        <button class="btn btn-primary pull-right"
                            wire:click="{{$update_mode ? 'update' : 'store'}}">Simpan</button>
                    </div>
                </div>
            </div>
            @else
            <livewire:table.event-table />
            @endif

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
    <script src="{{ asset('assets/js/plugin/select2/select2.full.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function(e) {
            window.livewire.on('loadForm', (data) => {
                $('#event_description').summernote({
                    placeholder: 'event_description',
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                    tabsize: 2,
                    height: 300,
                    callbacks: {
                        onChange: function(contents, $editable) {
                            @this.set('event_description', contents);
                        }
                    }
                });
                $('#event_narasumber').summernote({
                    placeholder: 'event_narasumber',
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                    tabsize: 2,
                    height: 300,
                    callbacks: {
                            onChange: function(contents, $editable) {
                                @this.set('event_narasumber', contents);
                            }
                        }
                });
                $('#event_benefit').summernote({
                    placeholder: 'event_benefit',
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                    tabsize: 2,
                    height: 300,
                    callbacks: {
                            onChange: function(contents, $editable) {
                                @this.set('event_benefit', contents);
                            }
                        }
                });
                $('#event_note').summernote({
                    placeholder: 'event_note',
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                    tabsize: 2,
                    height: 300,
                    callbacks: {
                            onChange: function(contents, $editable) {
                                @this.set('event_note', contents);
                            }
                        }
                });

                $('#choices-multiple-remove-button').select2({
                    theme: "bootstrap",
                });
                
                $('#choices-multiple-remove-button').on('change', function (e) {
                    let data = $(this).val();
                    console.log(data)
                    @this.set('event_category_id', data);
                });
            });

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
            });
        })
    </script>
    @endpush
</div>