<div class="form-group {{$errors->has($name) ? 'has-error has-feedback' : '' }}">
    @isset($label)
    @if (in_array($type, ['text', 'password', 'date', 'email','number','time']))
    <label for="{{$name}}" class="placeholder"><b>{{$label}}</b></label>
    @endif
    @endisset

    <input id="{{$name}}" value="{{$value ?? ''}}" name="{{$name}}" wire:model="{{$name}}" type="{{$type ?? 'text'}}"
        class="form-control" {{isset($readonly) ? 'readonly' : ''}}>
    <small id="helpId" class="text-danger">{{ $errors->has($name) ? $errors->first($name) : '' }}</small>
</div>