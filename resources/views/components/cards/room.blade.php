 <a class="{{ $room->is_active ? 'border-purple-500' : 'border-purple-500 opacity-40 cursor-not-allowed' }} max-w-52 w-full hover:bg-purple-50 border-2 rounded-md p-2 flex flex-col items-center aspect-square shadow-md shadow-black/25 dark:hover:bg-slate-800 relative"
     href="{{ route(auth()->user()->is_admin ? 'admin.rooms.detail' : 'user.room.detail', $room->id) }}">
     <p class="text-xs text-center">{{ \Carbon\Carbon::parse($room->updated_at)->format('j F Y') }}</p>
     <div class="h-full flex justify-center items-center">
         <p class="text-2xl text-center">{{ $room->name }}</p>
     </div>
 </a>
