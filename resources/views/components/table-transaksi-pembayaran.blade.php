<div x-data="{ status: '{{ $status }}' }">
    <select x-model="status" @change="$wire.updateStatus('{{ $id }}', status, 'pembayaran')"
        class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm font-medium 
               bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 
               focus:ring focus:ring-indigo-300 focus:outline-none 
               transition duration-300 ease-in-out transform hover:scale-105">
        <option value="Belum Bayar" class="text-red-500 font-semibold">❌ Belum Bayar</option>
        <option value="Lunas" class="text-green-500 font-semibold">✅ Lunas</option>
    </select>
</div>
