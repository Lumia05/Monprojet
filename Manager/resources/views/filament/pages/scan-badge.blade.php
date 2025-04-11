<x-filament-panels::page>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Scan Employee Badge</h2>

        <div class="mb-4">
            <video id="preview" class="w-full max-w-md mx-auto"></video>
        </div>

        @if ($message)
            <div class="mb-4 p-4 bg-blue-100 text-blue-700 rounded-lg">
                {{ $message }}
            </div>
        @endif

        @if ($employee)
            <div class="p-4 border rounded-lg mb-4">
                <h3 class="text-xl font-semibold mb-2">Employee Details</h3>
                <p><strong>Name:</strong> {{ $employee->name }} {{ $employee->prenom }}</p>
                <p><strong>Employee Code:</strong> {{ $employee->employee_code }}</p>
                <p><strong>Role:</strong> {{ $employee->role }}</p>
                <p><strong>Position:</strong> {{ $employee->poste ?? 'N/A' }}</p>
            </div>
        @endif

        <x-filament::button wire:click="resetScanner" class="mt-4">
            Scan Another Badge
        </x-filament::button>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

            scanner.addListener('scan', function (content) {
                // Call the processScan method with the scanned employee_code
                @this.call('processScan', content);
            });

            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]); // Use the first available camera
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error('Error accessing camera:', e);
            });

            // Listen for reset-scanner event to restart the scanner
            Livewire.on('reset-scanner', () => {
                scanner.stop().then(() => {
                    if (Instascan.Camera.getCameras().length > 0) {
                        scanner.start(Instascan.Camera.getCameras()[0]);
                    }
                });
            });
        });
    </script>
</x-filament-panels::page>
