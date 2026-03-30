@props([
    'name', 
    'items' => [], 
    'label' => 'Items', 
    'placeholder' => 'Add item...', 
    'type' => 'text'
])

<div class="form-control w-full mb-4" x-data="{
    newItem: '',
    items: {{ json_encode($items ?? []) }}
}">
    <label class="label" for="new-{{ $name }}">
        <span class="label-text font-semibold">{{ $label }}</span>
    </label>
    
    <div class="flex gap-2 items-end mb-4">
        <input
            id="new-{{ $name }}"
            x-model="newItem"
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            class="input input-bordered flex-1 focus:input-primary"
            spellcheck="false"
            @keydown.enter.prevent="if(newItem.trim().length > 0 && !items.includes(newItem.trim())) { items.push(newItem.trim()); newItem = ''; }"
        >
        <button
            type="button"
            @click="if(newItem.trim().length > 0 && !items.includes(newItem.trim())) { items.push(newItem.trim()); newItem = ''; }"
            :disabled="newItem.trim().length === 0"
            class="btn btn-outline"
        >
            + Add
        </button>
    </div>

    <template x-for="(item, index) in items" :key="index">
        <input type="hidden" :name="`{{ $name }}[]`" :value="item">
    </template>

    <template x-if="items.length > 0">
        <div class="space-y-2">
            <template x-for="(item, index) in items" :key="index">
                <div class="flex items-center justify-between bg-base-200 p-3 rounded-lg border border-base-300">
                    <span class="break-all flex-1" x-text="item"></span>
                    <button
                        type="button"
                        @click="items.splice(index, 1)"
                        class="btn btn-sm btn-ghost ml-2"
                        title="Remove item"
                    >
                        ✕
                    </button>
                </div>
            </template>
        </div>
    </template>
</div>
