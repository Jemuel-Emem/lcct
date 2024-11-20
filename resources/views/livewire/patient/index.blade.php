<div class="flex items-center justify-center  ">
    <div class="text-center bg-white rounded-3xl shadow-2xl p-10 w-full ">

        <div class="flex justify-center ">
            <div class="h-20 w-20 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-full shadow-lg flex items-center justify-center">
                <span class="text-white text-3xl font-bold">🌟</span>
            </div>
        </div>


        <h1 class="text-5xl font-extrabold text-gray-800 mb-4">
            Hello, <span class="text-cyan-500">{{ Auth::user()->name ?? 'Guest' }}</span>!
        </h1>

        <p class="text-gray-600 text-lg mb-6">
            Welcome to LCCT Clinic. Let’s achieve great things together!
        </p>


    </div>
</div>
