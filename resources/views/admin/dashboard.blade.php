
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
       
    </style>

    <div class="container mx-auto mb-5">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Enquiries Dashboard</h1>
            <div class="space-x-2">
                <button class="bg-yellow-500 text-white p-2 rounded">Pending Request</button>
                <button class="bg-green-500 text-white p-2 rounded">Follow Up</button>
                <button class="bg-blue-500 text-white p-2 rounded">Download</button>
                <button class="bg-indigo-500 text-white p-2 rounded"><i class="fas fa-plus"></i> Add New</button>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="grid grid-cols-4 gap-4 mb-4">
            <input type="text" placeholder="Search by pin code, school name, CRM name" class="p-2 border rounded col-span-3">
            <button class="bg-blue-500 text-white p-2 rounded">Search</button>
        </div>
        <div class="grid grid-cols-4 gap-4 mb-6">
            <select class="p-2 border rounded"><option>CRM</option></select>
            <select class="p-2 border rounded"><option>City</option></select>
            <select class="p-2 border rounded"><option>Status</option></select>
            <select class="p-2 border rounded"><option>Flow</option></select>
        </div>

        <!-- Enquiries Table -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold mb-4">Enquiries</h2>
            <div class="table-responsive">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2">S. No.</th>
                            <th class="p-2">School Name</th>
                            <th class="p-2">CRM Name</th>
                            <th class="p-2">City</th>
                            <th class="p-2">Last Visit Date</th>
                            <th class="p-2">Follow Up Date</th>
                            <th class="p-2">Status</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-50">
                            <td class="p-2">PRE2309</td>
                            <td class="p-2">Aaliyah</td>
                            <td class="p-2">10</td>
                            <td class="p-2">English</td>
                            <td class="p-2">10:00 AM</td>
                            <td class="p-2">01:00 PM</td>
                            <td class="p-2">23 Apr 2020</td>
                            <td class="p-2 text-right space-x-2">
                                <button class="bg-green-500 text-white p-1 rounded">View</button>
                                <button class="bg-red-500 text-white p-1 rounded">Edit</button>
                            </td>
                        </tr>
                        <!-- More rows can be dynamically added -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Follow Up Section -->
        <div class="bg-white shadow-md rounded-lg p-4 mt-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-semibold">Follow Up</h2>
                <div class="flex items-center">
                    <label class="mr-2">Show Expired Follow Ups Only</label>
                    <input type="checkbox" id="toggleExpired" class="toggle-btn">
                </div>
            </div>
            <div class="toggle-content hidden">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2">S. No.</th>
                            <th class="p-2">School Name</th>
                            <th class="p-2">CRM Name</th>
                            <th class="p-2">Follow Up Date</th>
                            <th class="p-2">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Expired follow-ups rows -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleExpired').addEventListener('change', function () {
            const content = document.querySelector('.toggle-content');
            content.style.display = this.checked ? 'block' : 'none';
        });
    </script>
