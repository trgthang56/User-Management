<!-- Import User Modal -->
<div id="importUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium dark:text-gray-100 text-gray-900">Import Users</h3>
            <div class="mt-2">
                <form id="importUserForm" action="{{ route('user.import') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4">
                        <label class="block text-sm font-medium dark:text-gray-100 text-gray-300">Choose File:</label>
                        <input type="file" name="csv_file" class="mt-1 block w-full text-gray-200 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="mt-4 flex dark:text-gray-100 justify-end space-x-3">
                        <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openImportModal() {
    document.getElementById('importUserModal').classList.remove('hidden');
}

function closeImportModal() {
    document.getElementById('importUserModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('importUserModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImportModal();
    }
});
</script>
