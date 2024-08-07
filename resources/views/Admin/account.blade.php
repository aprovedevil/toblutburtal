<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                            class="fixed top-0 right-0 z-50 mt-6 mr-6">
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                                role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                    <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="overflow-x-hidden mt-5">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nomor Kursi
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tujuan
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tindakan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class=" divide-y divide-gray-200">
                                @foreach ($posts as $index => $post)
                                    <tr class="transition-all hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $post->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $post->nisn }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $post->alamat }}
                                        </td>
                                        <td>
                                            <button class="text-green-500 btn-verifikasi"
                                                data-post-id="{{ $post->id }}"
                                                data-verified="{{ $post->verified ? 'true' : 'false' }}">
                                                {{ $post->verified ? 'Terdaftar' : 'Verifikasi' }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-verifikasi').forEach(button => {
            button.addEventListener('click', function() {
                let postId = this.dataset.postId;
                let verified = this.dataset.verified === 'true';
    
                if (!verified) {
                    // Kirim permintaan AJAX untuk verifikasi hanya jika statusnya belum terverifikasi
                    fetch(`/verifikasi/${postId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Perbarui status verifikasi di sisi klien jika permintaan berhasil
                            if (data.message === 'Data berhasil diverifikasi') {
                                this.dataset.verified = 'true';
                                this.innerText = 'Terdaftar';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });
    });
    </script>
    
