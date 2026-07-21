<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        
        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-xs mb-6">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Manage Purchases</h2>
            </div>

            <div class="w-full md:w-80">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input 
                        type="text" 
                        id="searchPurchase"
                        placeholder="Search purchase or supplier..." 
                        class="w-full pl-9 pr-4 py-2 text-sm bg-gray-100 text-gray-900 placeholder-gray-500 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium shadow-inner"
                    >
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; margin-bottom: 15px; width: 100%;">
            <a href="{{ route('purchases.create') }}" 
               style="display: inline-flex; items-center: center; justify-content: center; background-color: #22c55e; color: white; padding: 8px 16px; font-size: 14px; font-weight: 500; border-radius: 6px; text-decoration: none; border: none; cursor: pointer; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); transition: background-color 0.15s ease;"
               onmouseover="this.style.backgroundColor='#16a34a'" 
               onmouseout="this.style.backgroundColor='#22c55e'">
                + Add Purchase Voucher
            </a>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-xs overflow-hidden" id="tableResponseWrapper">
            @include('purchases.partials.table')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let debounceTimer;

            // Input element tracking event handler
            $('#searchPurchase').on('input', function() {
                let searchQuery = $(this).val();

                // Clear previous database hit timer
                clearTimeout(debounceTimer);

                // Wait 300ms after user stops typing to trigger MySQL request
                debounceTimer = setTimeout(function() {
                    executeSearch(searchQuery);
                }, 300);
            });

            // Pagination links logic: Dynamic link overriding so page does not refresh
            $(document).on('click', '#tableResponseWrapper .pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let searchQuery = $('#searchPurchase').val();

                // Append current search parameters safely to navigation
                if (url.indexOf('?') !== -1) {
                    url += '&search=' + encodeURIComponent(searchQuery);
                } else {
                    url += '?search=' + encodeURIComponent(searchQuery);
                }

                fetchPaginatedData(url);
            });

            // Core AJAX Function to filter database results
            function executeSearch(query) {
                $.ajax({
                    url: "{{ route('purchases.index') }}",
                    type: "GET",
                    data: { search: query },
                    beforeSend: function() {
                        $('#tableResponseWrapper').css('opacity', '0.6');
                    },
                    success: function(htmlManifest) {
                        $('#tableResponseWrapper').html(htmlManifest);
                        $('#tableResponseWrapper').css('opacity', '1');
                    },
                    error: function(xhr) {
                        console.error("Database connection parameter failure: ", xhr.statusText);
                        $('#tableResponseWrapper').css('opacity', '1');
                    }
                });
            }

            // Pagination data fetch async function
            function fetchPaginatedData(url) {
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(htmlManifest) {
                        $('#tableResponseWrapper').html(htmlManifest);
                    },
                    error: function(xhr) {
                        console.error("Pagination link index structural failure: ", xhr.statusText);
                    }
                });
            }
        });
    </script>
</x-app-layout>