<div class="we-pie-chart-wrapper">
    <div class="h-[400px] card">
        <div class="text-xl font-medium">
            {{ translate("Orders This Month") }}
        </div>
        <livewire:livewire-line-chart  :line-chart-model="$lineChartModel" />

        {{-- <livewire:livewire-pie-chart key="{{ $pieChartModel->reactiveKey() }}" :pie-chart-model="$pieChartModel" /> --}}
    </div>
    @livewireChartsScripts

</div>
