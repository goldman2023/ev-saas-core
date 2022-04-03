@extends('frontend.layouts.' . $globalLayout)

@section('content')
    <div class="w-full">

        <div class="flex flex-col shadow bg-card">
            <div>
                <img src="{{ $user->getCover(['w' => 0]) }}" alt="Cover image" class="w-full h-40 lg:h-80 object-cover"></div>
                <div class="flex flex-col flex-0 lg:flex-row items-center max-w-5xl w-full mx-auto px-8 lg:h-18 bg-card">
                    <div class="mt-[-20px] lg:mt-[-40px] rounded-full relative top-[-20px]">
                        <img src="{{ $user->getThumbnail(['w' => 400]) }}" alt="User avatar" class="w-32 h-32 rounded-full ring-4 ring-white">
                    </div>
                    <div class="flex flex-col items-center lg:items-start mt-4 lg:mt-0 lg:ml-8">
                        <div class="text-lg font-bold leading-none">{{ $user->name .' '.$user->surname }}</div>
                        <div class="text-gray-500">{{ $user->email }}</div>
                    </div>
                    <div class="hidden lg:flex h-8 mx-8 border-l-2"></div>
                    <div class="flex items-center mt-6 lg:mt-0 space-x-6">
                        <div class="flex flex-col items-center">
                            <span class="font-bold">200k</span>
                            <span class="text-sm font-medium text-gray-500">FOLLOWERS</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="font-bold">1.2k</span>
                            <span class="text-sm font-medium text-gray-500">FOLLOWING</span>
                        </div>
                    </div>
                    {{-- <div class="flex items-center mt-8 mb-4 lg:m-0 lg:ml-auto space-x-6">
                        <a class="font-medium" href="/pages/profile"> Home </a>
                        <a class="text-secondary" href="/pages/profile"> About </a>
                        <a class="text-secondary" href="/pages/profile"> Followers </a>
                        <a class="text-secondary" href="/pages/profile"> Gallery </a>
                    </div> --}}
                </div>
            </div>

            <div class="flex flex-auto justify-center w-full max-w-5xl mx-auto p-6 sm:p-8">
                <div class="w-full grid grid-cols-12 gap-6">
                    <div class="col-span-5 shadow rounded border">
                        
                        <div class="flex flex-col max-w-80 w-full p-8 ng-tns-c148-34 ng-star-inserted">
                            <!---->
                            <div class="text-2xl font-semibold leading-tight ng-tns-c148-34 ng-star-inserted">About Me</div>
                            <div class="mt-4 ng-tns-c148-34 ng-star-inserted"> I’m a friendly kitchen assistant who suffers from a severe phobia of buttons. <br><br> Brother of Elijah Jay Watkins, who has phobia of buttons and trust issues. </div><hr class="w-full border-t my-6 ng-tns-c148-34 ng-star-inserted">
                            <div class="flex flex-col ng-tns-c148-34 ng-star-inserted">
                                <div class="flex items-center">
                                    @svg('heroicon-o-mail', ['class' => 'w-5 h-5 mr-2'])
                                    <span class="leading-none">{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    @svg('lineawesome-user-tie-solid', ['class' => 'w-5 h-5 mr-2'])
                                    <span class="leading-none">User's occupation or role if needed</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    @svg('heroicon-o-cake', ['class' => 'w-5 h-5 mr-2'])
                                    <span class="leading-none">Registered on</span>
                                </div>
                            </div>
                            
                            {{-- <button mat-flat-button="" class="mat-focus-indicator px-6 mt-8 mat-flat-button mat-button-base mat-primary ng-tns-c148-34 ng-star-inserted" tabindex="0"><span class="mat-button-wrapper"> See complete bio </span><span matripple="" class="mat-ripple mat-button-ripple"></span><span class="mat-button-focus-overlay"></span></button><!----><!----><!----></div> --}}
                    </div>
{{-- 
                    <div class="col-span-7 shadow rounded border">
123
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection