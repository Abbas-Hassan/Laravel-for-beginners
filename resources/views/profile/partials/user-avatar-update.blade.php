
<section>
    <header></header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            User Avatar  
        </h2>
 
        <img width="50" height="50" class= "rounded-full"src="{{ $user->avatar }}" alt="user avatar" >

        <form action="{{route('profile.avatar.ai')}}" method="POST" class="mt-4">
            @csrf
            <p class="mt-1 text-sm text-gray-600 2dark:text-gray-400">
                GENERATE AVATAR FROM AI
            </p>
        
            <x-primary-button>Generate Avatar</x-primary-button>
        
        </form>
        
        <p class="my-4 text-sm text-gray-600 2dark:text-gray-400">
            OR
        </p>

   @if(session('message'))
        <div class="text-red-500">
            {{ session('message') }}
        </div>
    @endif
    <form method="post" action="{{ route('profile.avatar') }}" enctype = "multipart/form-data">
        @method('patch')
        @csrf
 
        <div>
            <x-input-label for="name" value="Upload Avatar from Computer" />
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('avatar', $user->avatar)" required autofocus autocomplete="avatar" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

       
        <div class="flex items-center gap-4 mt-4      ">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

         
        </div>
    </form>
</section>
