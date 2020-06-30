<div class="w-full relative"
     x-init="
        setTimeout(() => {
            range = MultiRange($refs.input);
            range.onUpdate = value => {
                $dispatch('input', value)
            }
        }, 50)
     "
     wire:model="{{ $model }}"
>
    <div wire:ignore>
        <input multiple
               type="range"
               x-ref="input"
               step="{{ $step }}"
               min="{{ $min }}"
               max="{{ $max }}"
               value="{{ $value }}"
        >
    </div>
</div>
