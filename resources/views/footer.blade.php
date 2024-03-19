<footer class="bg-gray-800 text-white py-12 absolute bottom-0 w-full flex items-center">
    <div class="px-4 sm:px-6 lg:px-8 w-full">
        <div class="sm:flex w-full justify-between text-center">
            <div class="mb-2">Copyright &copy; {{ date('Y') }} {{ config('app.name') }}</div>
            <div class="flex justify-center mb-2">
                <div class="px-2">
                    <a href="/privacy-policy">
                        Privacy Policy
                    </a>
                </div>
                <div class="px-2">
                    <a href="/terms-of-service">
                        Terms of Service
                    </a>
                </div>                
            </div>
        </div>
    </div>
</footer>
