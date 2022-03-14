<div id="we-edit" class="h-full w-full flex" x-data="{}">

    <livewire:we-edit.navigation.sidebar :menu="$we_menu" />

    <div class="flex-1 flex flex-col overflow-hidden">
        <livewire:we-edit.navigation.topbar />

        <livewire:we-edit.router-outlet :we_menu="$we_menu" :selected_container="$selected_container" />
    </div>

    <livewire:we-media-library />
</div>
