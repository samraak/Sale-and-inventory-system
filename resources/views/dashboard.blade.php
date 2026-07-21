<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            
            <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Welcome Back, Samra Azhar! 👋</h3>
                    <p class="text-sm text-gray-500 mt-1">Here is a quick overview of your warehouse station. Everything is up and running smoothly today.</p>
                </div>
                <div class="flex items-center space-x-2 bg-green-50 text-green-700 px-4 py-2 rounded-xl border border-green-100 text-xs font-bold">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span>System Status: Online</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                    <div class="mb-5">
                        <h4 class="text-base font-bold text-slate-800">How to use the System? 📋</h4>
                        <p class="text-xs text-gray-400 mt-0.5">Follow these simple steps to manage your business operations daily.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start space-x-3 p-3 rounded-xl bg-slate-50 border border-gray-100">
                            <span class="text-lg p-1.5 bg-blue-100 rounded-lg text-blue-600">1️⃣</span>
                            <div>
                                <h5 class="text-sm font-semibold text-slate-700">Check Sidebar Navigation</h5>
                                <p class="text-xs text-gray-500 mt-0.5">Use the menu panel on the left side to move between Products, Suppliers, Units, Purchases, and Sales.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 rounded-xl bg-slate-50 border border-gray-100">
                            <span class="text-lg p-1.5 bg-amber-100 rounded-lg text-amber-600">2️⃣</span>
                            <div>
                                <h5 class="text-sm font-semibold text-slate-700">Add or Manage Records</h5>
                                <p class="text-xs text-gray-500 mt-0.5">Inside any section, click the green buttons to add new information, or use standard buttons to edit and delete.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 rounded-xl bg-slate-50 border border-gray-100">
                            <span class="text-lg p-1.5 bg-purple-100 rounded-lg text-purple-600">3️⃣</span>
                            <div>
                                <h5 class="text-sm font-semibold text-slate-700">Creating Purchases & Sales</h5>
                                <p class="text-xs text-gray-500 mt-0.5">When creating invoices, rows can be dynamically added to list multiple goods and calculate total prices instantly.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="mb-5">
                            <h4 class="text-base font-bold text-slate-800">Need Help? 🛠️</h4>
                            <p class="text-xs text-gray-400 mt-0.5">Support and system details for the store manager.</p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-xs text-gray-500 font-medium">Access Control</span>
                                <span class="text-xs font-bold text-slate-700">Administrator</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-xs text-gray-500 font-medium">Data Protection</span>
                                <span class="text-xs font-bold text-emerald-600">Active & Secure</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-xs text-gray-500 font-medium">Current Session</span>
                                <span class="text-xs font-bold text-blue-600">Authorized</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-3 bg-slate-50 border border-gray-100 rounded-xl text-center">
                        <p class="text-[11px] text-gray-500 leading-relaxed">
                            🔒 Your records are encrypted. Always make sure to <strong>Logout</strong> before leaving the application panel.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>