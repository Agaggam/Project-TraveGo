@auth
<style>[x-cloak] { display: none !important; }</style>
<div x-data="{ open: false, supportUnread: 0 }" 
     @update-support-badge.window="supportUnread = $event.detail"
     class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end gap-3 font-sans"
     style="display: flex !important;">
     
    <!-- Overlay/Backdrop -->
    <div x-show="open" @click="open = false" 
         class="fixed inset-0 bg-black/20 backdrop-blur-[1px] z-[9990]"
         style="display: none;"
         x-show.important="open"
         x-transition.opacity></div>

    <!-- AI Bot Option -->
    <div x-show="open" 
         style="display: none;"
         x-show.important="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8 scale-50"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-50"
         class="flex items-center gap-3 z-[9999] group cursor-pointer"
         @click="$dispatch('open-chatbot'); open = false">
         <!-- Content same -->
         <span class="bg-white text-gray-800 text-sm font-medium px-3 py-1.5 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all duration-300">
            TraveGo AI
        </span>
        <button class="w-12 h-12 rounded-full bg-emerald-500 text-white shadow-xl group-hover:scale-110 transition-all duration-300 flex items-center justify-center border-2 border-white/20">
            <i class="fas fa-robot text-lg"></i>
        </button>
    </div>

    <!-- Live Support Option -->
    <div x-show="open" 
         style="display: none;"
         x-show.important="open"
         x-transition:enter="transition ease-out duration-300 delay-75"
         x-transition:enter-start="opacity-0 translate-y-8 scale-50"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 delay-75"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-50"
         class="flex items-center gap-3 z-[9999] group cursor-pointer"
         @click="$dispatch('open-support-chat'); open = false">
         <!-- Content same -->
         <span class="bg-white text-gray-800 text-sm font-medium px-3 py-1.5 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all duration-300">
            Live Support
        </span>
        <button class="w-12 h-12 rounded-full bg-blue-600 text-white shadow-xl group-hover:scale-110 transition-all duration-300 flex items-center justify-center border-2 border-white/20 relative">
            <i class="fas fa-headset text-lg"></i>
            <span x-show="supportUnread > 0" x-text="supportUnread" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-xs flex items-center justify-center border-2 border-white animate-pulse"></span>
        </button>
    </div>

    <!-- Main Toggle -->
    <button @click="open = !open" 
            class="w-16 h-16 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 text-white shadow-2xl flex items-center justify-center transition-all duration-300 hover:shadow-[0_0_30px_rgba(99,102,241,0.6)] z-[9999] relative group">
        
        <!-- FORCE TEXT VISIBILITY IF ICON FAILS -->
        <span x-show="!open" class="font-bold text-xs absolute bottom-1">CHAT</span>

        <!-- Icons with rotation -->
        <div class="relative w-full h-full flex items-center justify-center transition-transform duration-500"
             :class="open ? 'rotate-[135deg]' : 'rotate-0'">
             
             <!-- Plus Icon (Default) -->
            <i class="fas fa-plus text-3xl transition-opacity duration-300 absolute"
               :class="open ? 'opacity-0' : 'opacity-100'" style="margin-bottom: 5px;"></i>
               
             <!-- Comment Icon alt (optional) -->
             <i class="fas fa-comment-alt text-xl absolute -translate-y-4 opacity-0 transition-all duration-300 delay-100"
                :class="!open ? 'opacity-100 translate-y-[-10px]' : 'opacity-0'"></i>
        </div>

        <i class="fas fa-times text-2xl absolute transition-all duration-300"
           :class="open ? 'opacity-100 rotate-0 scale-100' : 'opacity-0 rotate-[-90deg] scale-50'"></i>
        
         <!-- Main Badge if closed -->
         <span x-show="!open && supportUnread > 0" 
               x-text="supportUnread" 
               class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full text-xs font-bold flex items-center justify-center border-2 border-white animate-bounce shadow-md"></span>
         
         <div class="absolute inset-0 rounded-full border-2 border-white/20 animate-[ping_2s_ease-in-out_infinite]" x-show="!open && supportUnread > 0"></div>
    </button>
</div>
@endauth
