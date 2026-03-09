<div class="border rounded-lg p-4">
    <h3 class="text-lg font-semibold mb-4">Livewire Test Component</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="bg-gray-50 p-3 rounded">
            <p class="text-sm text-gray-600">Count</p>
            <p class="text-2xl font-bold">{{ $count }}</p>
        </div>
        
        <div class="bg-gray-50 p-3 rounded">
            <p class="text-sm text-gray-600">Message</p>
            <p class="text-lg">{{ $message }}</p>
        </div>
        
        <div class="bg-gray-50 p-3 rounded">
            <p class="text-sm text-gray-600">Current Time</p>
            <p class="text-lg">{{ $this->timestamp }}</p>
        </div>
        
        <div class="bg-gray-50 p-3 rounded">
            <p class="text-sm text-gray-600">Session ID</p>
            <p class="text-sm font-mono">{{ $this->sessionId }}</p>
        </div>
    </div>

    <div class="flex gap-2 mb-4">
        <button wire:click="increment" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Increment
        </button>
        <button wire:click="decrement" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            Decrement
        </button>
        <button wire:click="resetCount" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Reset
        </button>
    </div>

    <div class="mb-4">
        <form wire:submit="submit">
            <div class="flex gap-2">
                <input 
                    type="text" 
                    wire:model="input" 
                    placeholder="Type something..."
                    class="flex-1 border rounded px-3 py-2"
                >
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Submit
                </button>
            </div>
        </form>
    </div>

    <div class="text-sm text-gray-600">
        <p>Livewire Status: <span class="text-green-600 font-semibold">✓ Active</span></p>
        <p>Wire:loading indicator: <span wire:loading class="text-blue-600">Loading...</span></p>
    </div>
</div>
